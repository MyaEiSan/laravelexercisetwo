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
        Schema::table('townships', function (Blueprint $table) {
            $table->dropColumn('country_id');
            $table->dropColumn('region_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('townships', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->after('name');
            $table->unsignedBigInteger('region_id')->after('city_id');
        });
    }
};
