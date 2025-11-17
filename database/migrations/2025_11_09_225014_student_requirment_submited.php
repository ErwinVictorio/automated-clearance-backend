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
        Schema::create('student_requirment_sub', function (Blueprint $table) {
            $table->id();
            $table->string('requestor_name');
            $table->string('teacher_or_office');
            $table->string('section');
            $table->string('course');
            $table->string('drive_link')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
