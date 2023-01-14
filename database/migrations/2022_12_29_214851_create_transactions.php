<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('account_number');
            $table->string('beneficiary_account_number');
            $table->string('description');
            $table->string('type');
            $table->float('amount_payer', 60, 30);
            $table->string('currency_payer');
            $table->float('amount_beneficiary', 60, 30)->nullable();
            $table->string('currency_beneficiary')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
