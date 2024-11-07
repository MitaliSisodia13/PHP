<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('_token'); // Remove _token column if it exists
        });
    }
    
    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->string('_token'); // Add _token back if you want to revert this change
        });
    }
    
};
