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
        //TODO: HOW PAY MONIES?
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dog_id')->nullable()->constrained('dogs')->cascadeOnDelete();
            $table->string('serviceable_id');
            $table->string('serviceable_type');
            $table->boolean('is_paid');
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
        Schema::dropIfExists('services');
    }
};
