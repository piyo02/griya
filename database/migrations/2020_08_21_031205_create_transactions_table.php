<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned()->nullable();
            $table->integer('source_acc_id')->unsigned()->nullable();
            $table->integer('destination_acc_id')->unsigned()->nullable();
            $table->integer('type_id')->unsigned();
            $table->date('date');
            $table->integer('total');
            $table->text('description');
            $table->timestamps();

            $table->foreign('customer_id')
                    ->references('id')
                    ->on('customers');

            $table->foreign('type_id')
                    ->references('id')
                    ->on('types');

            $table->foreign('source_acc_id')
                    ->references('id')
                    ->on('accounts');

            $table->foreign('destination_acc_id')
                    ->references('id')
                    ->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
