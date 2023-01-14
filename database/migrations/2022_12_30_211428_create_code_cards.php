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
        Schema::create('code_cards', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('code_1');
            $table->string('code_2');
            $table->string('code_3');
            $table->string('code_4');
            $table->string('code_5');
            $table->string('code_6');
            $table->string('code_7');
            $table->string('code_8');
            $table->string('code_9');
            $table->string('code_10');
            $table->string('code_11');
            $table->string('code_12');
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
        Schema::dropIfExists('code_cards');
    }
};
