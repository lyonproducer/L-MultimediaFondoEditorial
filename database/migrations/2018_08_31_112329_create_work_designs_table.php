<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkDesignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_designs', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->integer('category_id')->unsigned();

            $table->string('title',128);
            $table->mediumText('excerpt')->nullable();
            $table->string('description');
            $table->string('dependency');
            $table->string('publishedDate');
            $table->string('file',128)->nullable();
            $table->enum('status', ['Finalizado','En proceso']);
            $table->string('uploadBy');
            $table->timestamps();

            //relation
            $table->foreign('user_id')->references('id')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('category_id')->references('id')->on('categories')
            ->onDelete('cascade')
            ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_designs');
    }
}
