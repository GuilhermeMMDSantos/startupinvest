<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $email = trim((string) config('admin.email'));
        $password = config('admin.password');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Set a valid ADMIN_EMAIL before seeding the admin user.');
        }

        if (!is_string($password) || $password === '') {
            throw new InvalidArgumentException('Set a non-empty ADMIN_PASSWORD before seeding the admin user.');
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            if ($user->tipo !== 'admin' || $user->estado !== 'aceite') {
                throw new RuntimeException('ADMIN_EMAIL already belongs to an account that is not an accepted admin.');
            }

            $this->command->info('Admin user already exists; its credentials were left unchanged.');

            return;
        }

        User::create([
            'email' => $email,
            'password' => Hash::make($password),
            'estado' => 'aceite',
            'tipo' => 'admin',
            'code_user' => Str::uuid()->toString(),
        ]);

        $this->command->info('Admin user created.');
    }
}
