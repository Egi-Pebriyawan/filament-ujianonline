<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('packages', function (Blueprint $table) {
        $table->renameColumn('start_time', 'start_datetime');
        $table->renameColumn('end_time', 'end_datetime');
    });
}

public function down()
{
    Schema::table('packages', function (Blueprint $table) {
        $table->renameColumn('start_datetime', 'start_time');
        $table->renameColumn('end_datetime', 'end_time');
    });
}
};
