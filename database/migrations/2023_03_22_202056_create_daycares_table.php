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
        Schema::create('daycare', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dog_id')->constrained();
            $table->string('visit-type');
            $table->boolean('paid');
            $table->dateTime('check-in')->default(null);
            $table->dateTime('check-out')->default(null);
            $table->date('daycare-date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daycare');
    }
};
