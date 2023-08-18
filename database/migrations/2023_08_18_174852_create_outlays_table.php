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
        Schema::disableForeignKeyConstraints();

        Schema::create('outlays', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('amount');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('outlay_types');
            $table->string('description');
            $table->unsignedBigInteger('cashier_id');
            $table->foreign('cashier_id')->references('id')->on('cashiers');
            $table->date('date');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outlays');
    }
};
