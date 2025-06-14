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
        Schema::create('licenses', function (Blueprint $table) {
            $table -> integer('id');
            $table -> string('name');
            $table -> string('description');
            $table -> double('price');
            $table -> integer('renovation-month');
            $table -> integer('provider');
            $table -> integer('client');
            $table -> integer('payment');
            $table -> string('runtime-start');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('licenses');
    }
};
