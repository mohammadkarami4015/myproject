<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('details');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::create('letter_user', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('letter_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('letter_id')->references('id')->on('letters')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('exp_time')->default(null);
            $table->primary(['user_id','letter_id']);
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
        Schema::dropIfExists('letters');
    }
}
