<?php

/**
 * Module Seeder Class
 *
 * @author Md Abu Ahsan Basir <maab.career@gmail.com>
 */

use Illuminate\Database\Seeder;
use App\Module;
use App\Models\Auth\User\User;
use Illuminate\Support\Str;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::firstOrCreate(
            ['name' => 'Dashboard', 'slug' => Str::slug('Dashboard')],
            ['name' => 'Dashboard', 'slug' => Str::slug('Dashboard')]
        );
        Module::firstOrCreate(
            ['name' => 'Settings', 'slug' => Str::slug('Settings')],
            ['name' => 'Settings', 'slug' => Str::slug('Settings')],
        );
        Module::firstOrCreate(
            ['name' => 'Users', 'slug' => Str::slug('Users')],
            ['name' => 'Users', 'slug' => Str::slug('Users')],
        );
        Module::firstOrCreate(
            ['name' => 'Company Management', 'slug' => Str::slug('Company Management')],
            ['name' => 'Company Management', 'slug' => Str::slug('Company Management')],
        );
        Module::firstOrCreate(
            ['name' => 'Email Management', 'slug' => Str::slug('Email Management')],
            ['name' => 'Email Management', 'slug' => Str::slug('Email Management')],
        );
        Module::firstOrCreate(
            ['name' => 'SMTP Settings', 'slug' => Str::slug('SMTP Settings')],
            ['name' => 'SMTP Settings', 'slug' => Str::slug('SMTP Settings')],
        );
        Module::firstOrCreate(
            ['name' => 'Payment Services', 'slug' => Str::slug('Payment Services')],
            ['name' => 'Payment Services', 'slug' => Str::slug('Payment Services')],
        );
        Module::firstOrCreate(
            ['name' => 'Invoices', 'slug' => Str::slug('Invoices')],
            ['name' => 'Invoices', 'slug' => Str::slug('Invoices')],
        );
        Module::firstOrCreate(
            ['name' => 'Payments', 'slug' => Str::slug('Payments')],
            ['name' => 'Payments', 'slug' => Str::slug('Payments')],
        );
        Module::firstOrCreate(
            ['name' => 'Recurring Payments', 'slug' => Str::slug('Recurring Payments')],
            ['name' => 'Recurring Payments', 'slug' => Str::slug('Recurring Payments')],
        );
        Module::firstOrCreate(
            ['name' => 'Logs', 'slug' => Str::slug('Logs')],
            ['name' => 'Logs', 'slug' => Str::slug('Logs')],
        );

        Module::firstOrCreate(
            ['name' => 'Online Payments', 'slug' => Str::slug('Online Payments')],
            ['name' => 'Online Payments', 'slug' => Str::slug('Online Payments')],
        );
        $modules = Module::all();   

        if (count($modules) > 0) {
            $users = User::all();

            if (count($users) > 0) {
                foreach ($users as $user) {
                    if ($user->roles->contains('name', 'Admin User') || $user->roles->contains('name', 'Super User')) {
                        $user->modules()->sync($modules);
                    }
                }
            }
        }

    }
}
