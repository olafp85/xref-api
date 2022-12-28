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
        Schema::create('xrefs', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('name');
            $table->string('component')->nullable();
            $table->string('unit')->nullable();
            $table->integer('depthWhereUsed')->unsigned()->nullable();
            $table->integer('depthCalls')->unsigned()->nullable();
            $table->boolean('includeSapObjects')->nullable();
            $table->string('system')->nullable();
            $table->string('release')->nullable();
            $table->date('date')->nullable();
            $table->string('createdBy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xrefs');
    }
};
