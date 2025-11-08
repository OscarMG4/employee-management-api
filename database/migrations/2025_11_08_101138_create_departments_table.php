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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45)->unique();
            $table->foreignId('parent_id')->nullable()->constrained('departments')->onDelete('cascade');
            $table->integer('level')->unsigned();
            $table->integer('employee_count')->unsigned();
            $table->string('ambassador_name')->nullable();
            $table->timestamps();
            
            $table->index('parent_id');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
