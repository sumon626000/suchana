<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('name');
            $table->string('mobile')->nullable()->unique()->after('email');
            $table->string('role')->default('student')->after('mobile');
            $table->boolean('is_active')->default(true)->after('role');
            $table->string('nid')->nullable()->after('is_active');
            $table->string('photo')->nullable()->after('nid');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'mobile', 'role', 'is_active', 'nid', 'photo']);
        });
    }
};
