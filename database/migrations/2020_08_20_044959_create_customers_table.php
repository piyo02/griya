<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('state_id')->unsigned();
            $table->integer('cluster_id')->unsigned();
            $table->date('date');
            $table->string('name');
            $table->string('phone', 15);
            $table->string('job');
            $table->string('type');
            $table->string('method_payment');
            $table->string('fee');
            $table->text('description');
            $table->timestamps();

            $table->foreign('state_id')
                    ->references('id')
                    ->on('states');

            $table->foreign('cluster_id')
                    ->references('id')
                    ->on('clusters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
