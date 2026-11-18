<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('showcase_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('title_bn')->nullable();
            $table->string('title_en')->nullable();
            $table->string('subtitle_bn')->nullable();
            $table->string('subtitle_en')->nullable();
            $table->string('image');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('showcase_certificates');
    }
};
