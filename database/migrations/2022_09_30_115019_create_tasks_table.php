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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('recurrence_type', ['interval', 'number_of_times']);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('number_of_times')->nullable();
            $table->enum('period', ['weekly', 'monthly', 'yearly']);
            $table->integer('month')->nullable();
            $table->integer('day_of_month')->nullable();
            $table->json('days')->nullable();
            $table->timestamps();
        });

        Schema::create('task_recurrences', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->date('date');
            $table->timestamps();

            $table->foreign('task_id')
                ->on('tasks')
                ->references('id')
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
        Schema::dropIfExists('task_recurrences');
        Schema::dropIfExists('tasks');
    }
};
