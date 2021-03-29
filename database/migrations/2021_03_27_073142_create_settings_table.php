<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('name')->primary();
            $table->string('description')->nullable();
            $table->string('group_name')->nullable();
            $table->string('value_type');
            $table->text('string_value')->nullable();
            $table->integer('number_value')->nullable();
            $table->double('double_value')->nullable();
            $table->boolean('boolean_value')->nullable();
            $table->jsonb('json_value')->nullable();
            $table->bigInteger('file_value')->nullable(true);
            $table->foreign('file_value')->references('id')->on('uploaded_files')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
