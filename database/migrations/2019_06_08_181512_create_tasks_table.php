<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            // Columns
            $table->increments('id');
            $table->string('description');
            $table->text('details')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->timestamps();
            // Constraints
            $table->integer('todolist_id')->unsigned();
            $table->foreign('todolist_id')
                ->references('id')->on('todo_lists')
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
        Schema::dropIfExists('tasks');
    }
}
