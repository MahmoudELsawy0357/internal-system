<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // --- إضافات السستم الجديد (التعديلات هنا) ---
            
            // 1. تحديد دور الموظف في الشركة
            $table->enum('role', ['admin', 'hr', 'accountant', 'ba', 'dev', 'marketing'])->default('dev');
            
            // 2. القسم الفرعي (مثلاً: Frontend, SEO, Media Buying)
            $table->string('department')->nullable();

            // 3. ربط الـ 4 منصات (IDs من المواقع الخارجية)
            $table->string('odoo_id')->nullable();    // معرف الموظف في أودو
            $table->string('jira_id')->nullable();    // معرف الموظف في جيرا
            $table->string('jibble_id')->nullable();  // معرف الموظف في جيبل
            $table->string('discord_id')->nullable(); // معرف الموظف في ديسكورد
            
            // ---------------------------------------

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};