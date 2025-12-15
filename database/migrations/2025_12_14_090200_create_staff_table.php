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
        Schema::create('staff', function (Blueprint $table) {
            $table->id('StaffID'); // PK

            $table->unsignedBigInteger('RoleID');
            $table->unsignedBigInteger('DeptID');

            $table->string('Username', 100);
            $table->string('Name', 100);
            $table->string('password'); // The password column
            $table->timestamps();

            // Foreign Keys
            $table->foreign('RoleID')->references('RoleID')->on('user_roles');
            $table->foreign('DeptID')->references('DepartmentID')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};