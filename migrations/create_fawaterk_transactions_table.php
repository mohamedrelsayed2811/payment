<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFawaterkTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fawaterk_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reference_id')->unique();
            $table->string('invoice_url')->unique();
            $table->json('order')->comment('Order data fields and values');
            $table->json('request')->comment('request data fields and values');
            $table->json('response')->nullable()->comment('response data fields and values');
            $table->enum('status', ['paid','pending', 'fail'])->default('pending');
            $table->integer('created_at');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fawaterk_transactions');
    }
}
