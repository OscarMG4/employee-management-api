<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('first_name')->after('id')->nullable();
            $table->string('last_name')->after('first_name')->nullable();
            $table->string('phone')->after('email')->nullable();
            $table->text('address')->after('notes')->nullable();
        });

        DB::statement("
            UPDATE employees 
            SET 
                first_name = SUBSTRING_INDEX(name, ' ', 1),
                last_name = SUBSTRING_INDEX(name, ' ', -1)
            WHERE name IS NOT NULL
        ");

        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('name')->after('id');
        });

        DB::statement("
            UPDATE employees 
            SET name = CONCAT(IFNULL(first_name, ''), ' ', IFNULL(last_name, ''))
            WHERE first_name IS NOT NULL OR last_name IS NOT NULL
        ");

        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'phone', 'address']);
        });
    }
};
