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
  Schema::table('donations', function (Blueprint $table) {
        if (!Schema::hasColumn('donations', 'mobile_money_provider')) {
            $table->string('mobile_money_provider')->nullable();
        }
    });  
}

public function down()
{
   Schema::table('donations', function (Blueprint $table) {
        if (Schema::hasColumn('donations', 'mobile_money_provider')) {
            $table->dropColumn('mobile_money_provider');
        }
    });
}

};
