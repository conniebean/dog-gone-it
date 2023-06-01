<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dog_vaccine', function (Blueprint $table) {
            $table->date('expiry_date')->nullable()->after('dog_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dog_vaccine', function (Blueprint $table) {
            $table->removeColumn('expiry_date');
        });
    }
};
