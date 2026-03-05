<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. حساب الإدارة (Admin)
        User::create([
            'name' => 'Admin Manager',
            'email' => 'admin@company.com',
            'password' => Hash::make('12345678'), // الباسورد الموحد للتجربة
            'role' => 'admin',
            'department' => 'Management',
            'jira_id' => 'JIRA_ADMIN_01', // داتا وهمية للربط حالياً
        ]);

        // 2. حساب محلل الأعمال (BA)
        User::create([
            'name' => 'Ahmed BA',
            'email' => 'ba@company.com',
            'password' => Hash::make('12345678'),
            'role' => 'ba',
            'department' => 'Business Analysis',
            'jira_id' => 'JIRA_BA_01',
        ]);

        // 3. حساب مطور (Frontend Dev)
        User::create([
            'name' => 'Mohamed Dev',
            'email' => 'dev@company.com',
            'password' => Hash::make('12345678'),
            'role' => 'dev',
            'department' => 'Frontend',
            'jira_id' => 'JIRA_DEV_01',
            'jibble_id' => 'JIBBLE_USER_01',
        ]);

        // 4. حساب ماركتينج (Marketing)
        User::create([
            'name' => 'Sara Marketing',
            'email' => 'marketing@company.com',
            'password' => Hash::make('12345678'),
            'role' => 'marketing',
            'department' => 'Social Media',
            'odoo_id' => 'ODOO_MARKETER_01',
        ]);
    }
}