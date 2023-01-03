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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('iam_rating');
            $table->unsignedBigInteger('rated_by');
            $table->unsignedBigInteger('accommodation_id');
            $table->integer('star_number');
            $table->string('description');
            $table->timestamps();

            $table->foreign('iam_rating')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('rated_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('accommodation_id')
                ->references('id')
                ->on('accommodations')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
};
