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
    Schema::create('visit_records', function (Blueprint $table) {
        $table->id('VisitID'); // PK
        
        // Foreign Keys
        $table->unsignedBigInteger('VisitorID');
        $table->unsignedBigInteger('StaffID'); // Who handled them
        $table->unsignedBigInteger('DeptID'); // Where they visited
        
        $table->date('VisitDate');
        $table->string('Purpose', 255);
        $table->dateTime('CheckInTime')->nullable(); // Nullable because they might not be in yet
        $table->dateTime('CheckOutTime')->nullable(); // Nullable because they haven't left yet
        $table->string('Status')->default('Active'); // For your "Identify Duplicates" rule
        $table->timestamps();

        // Linking keys
        $table->foreign('VisitorID')->references('VisitorID')->on('visitors')->onDelete('cascade');
        $table->foreign('StaffID')->references('StaffID')->on('staff');
        $table->foreign('DeptID')->references('DepartmentID')->on('departments');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_records');
    }
};
