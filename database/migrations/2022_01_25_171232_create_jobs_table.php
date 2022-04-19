<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->datetime("started_date");
            $table->integer('machine_id');
            $table->integer('partnumber_id');
            $table->string('active', 10);
            $table->string('complete', 10);
            $table->binary('recorded_date');
            $table->integer('qty_good')->default(0);
            $table->integer('qty_bad')->default(0);
            $table->string('time_to_complete', 10)->default(0.00);
            $table->string('part_hr', 10)->default(0.000);
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
        Schema::dropIfExists('jobs');
    }
}
