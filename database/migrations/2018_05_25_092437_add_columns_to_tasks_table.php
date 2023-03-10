<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('task_from_user');
            $table->dropColumn('finished');
            $table->dropColumn('task_description');
            $table->dropColumn('task_deadline');
            $table->integer('assigned_to');
            $table->text('subject');
            $table->dateTime('start_date');
            $table->dateTime('due_date');
            $table->string('status')->nullable();
            $table->string('priority')->nullable();
            $table->longText('description')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->integer('task_from_user')->nullable();
            $table->boolean('finished')->default(0);
            $table->string('task_description')->nullable();
            $table->dateTime('task_deadline')->nullable();
            $table->dropColumn(['assigned_to','subject','start_date','due_date',
                'status','priority','description','deleted_at']);
        });
    }
}
