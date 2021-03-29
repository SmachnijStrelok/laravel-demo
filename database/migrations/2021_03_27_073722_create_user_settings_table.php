<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->bigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->string('name');
            $table->foreign('name')->references('name')->on('settings')->onDelete('CASCADE');
            $table->string('description')->nullable();
            $table->string('group_name')->nullable();
            $table->string('value_type');
            $table->text('string_value')->nullable();
            $table->integer('number_value')->nullable();
            $table->double('double_value')->nullable();
            $table->boolean('boolean_value')->nullable();
            $table->jsonb('json_value')->nullable();
            $table->primary(['user_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_settings');
    }
}
