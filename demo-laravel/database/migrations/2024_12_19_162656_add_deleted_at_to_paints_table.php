<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class   AddDeletedAtToPaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function down()
    {
        Schema::table('paints', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }

}
