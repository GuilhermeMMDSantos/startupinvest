<?php

namespace Tests\Feature;

use App\Http\Controllers\AdminController;
use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class AdminProfileFilesTest extends TestCase
{
    public function test_admin_can_view_startup_and_investor_profile_files()
    {
        Schema::create('startups', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_user')->primary();
            $table->string('nif');
            $table->string('mvp');
        });

        Schema::create('investidores', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_user')->primary();
            $table->string('bilhete_identidade');
            $table->string('video_investidor');
        });

        Storage::fake('public');
        Storage::disk('public')->put('perfis/startup.pdf', 'pdf');
        Storage::disk('public')->put('perfis/startup.mp4', 'video');
        Storage::disk('public')->put('perfis/investidor.pdf', 'pdf');
        Storage::disk('public')->put('perfis/investidor.mp4', 'video');

        DB::table('startups')->insert([
            'fk_user' => 1,
            'nif' => 'perfis/startup.pdf',
            'mvp' => 'perfis/startup.mp4',
        ]);
        DB::table('investidores')->insert([
            'fk_user' => 2,
            'bilhete_identidade' => 'perfis/investidor.pdf',
            'video_investidor' => 'perfis/investidor.mp4',
        ]);

        $admin = new User();
        $admin->tipo = 'admin';
        Auth::setUser($admin);

        $controller = new AdminController();
        $files = [
            ['startup', 1, 'nif'],
            ['startup', 1, 'mvp'],
            ['investidor', 2, 'bi'],
            ['investidor', 2, 'video'],
        ];

        foreach ($files as $file) {
            $this->assertSame(200, $controller->visualizarArquivoPerfil(...$file)->getStatusCode());
        }
    }

    public function test_non_admin_cannot_view_profile_files()
    {
        $user = new User();
        $user->tipo = 'startup';
        Auth::setUser($user);

        try {
            (new AdminController())->visualizarArquivoPerfil('startup', 1, 'nif');
            $this->fail('Non-admin profile file request should be forbidden.');
        } catch (HttpException $exception) {
            $this->assertSame(403, $exception->getStatusCode());
        }
    }
}
