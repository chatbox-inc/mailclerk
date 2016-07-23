<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\Facades\Schema;

class FirstTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $builder = Schema::getFacadeRoot();
        (new \App\Model\AuthTokenTable())->upTable($builder);
        (new \App\Model\UserTable())->upTable($builder);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $builder = Schema::getFacadeRoot();

        (new \App\Model\AuthTokenTable())->downTable($builder);
        (new \App\Model\UserTable())->downTable($builder);
    }
}
