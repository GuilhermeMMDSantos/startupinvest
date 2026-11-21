<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AdminApprovalTest extends TestCase
{
    public function test_approval_is_persisted_when_notification_email_fails()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('password');
            $table->string('estado');
            $table->string('tipo');
            $table->string('code_user');
            $table->timestamps();
        });

        $admin = User::create([
            'email' => 'admin@example.test',
            'password' => 'password',
            'estado' => 'aceite',
            'tipo' => 'admin',
            'code_user' => 'admin-test',
        ]);
        $user = User::create([
            'email' => 'startup@example.test',
            'password' => 'password',
            'estado' => 'espera',
            'tipo' => 'startup',
            'code_user' => 'startup-test',
        ]);

        Mail::shouldReceive('to')
            ->once()
            ->andThrow(new \RuntimeException('SMTP unavailable'));

        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->actingAs($admin)
            ->withHeader('X-Requested-With', 'XMLHttpRequest')
            ->postJson('/atualizar_stado', [
                'id' => $user->id,
                'action_' => 'Aceitar',
            ])
            ->assertOk()
            ->assertJson([
                'estado' => 'aceite',
                'email_enviado' => false,
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'estado' => 'aceite',
        ]);
    }
}
