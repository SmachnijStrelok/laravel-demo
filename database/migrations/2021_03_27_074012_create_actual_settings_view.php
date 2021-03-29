<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActualSettingsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement(/** @lang PostgresPLSQL */"
            CREATE VIEW actual_settings AS
                select *
                  from user_settings
                UNION ALL
                select null, *
                  from settings
                where name not in (
                  select name
                    from user_settings
                  intersect
                  select name
                    from settings
                );
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::statement(/** @lang PostgresPLSQL */"
            DROP VIEW IF EXISTS actual_settings
        ");
    }
}
