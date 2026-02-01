<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if admin user exists by email (assuming username is stored in name or using email)
        // We will stick to the plan: Email field holds the 'admin' identifier or use a fake email.
        
        // Strategy: Use 'admin@example.com' for email, and 'admin' for name.
        // The LoginController checks both email and name for the 'username' input.
        
        $user = User::where('email', 'admin@ahf.com')->orWhere('name', 'admin')->first();

        if (!$user) {
            User::create([
                'name' => 'admin',
                'email' => 'admin@ahf.com', // Internal email
                'password' => Hash::make('passwordfoxadminv2'),
            ]);
            $this->command->info('Admin user created. Username: admin, Password: password');
        } else {
            // Update password just in case
            $user->password = Hash::make('password');
            $user->save();
            $this->command->info('Admin user updated.');
        }
    }
}
