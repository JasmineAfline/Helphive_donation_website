<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            if (!Schema::hasColumn('donations', 'first_name')) {
                $table->string('first_name')->nullable();
            }
            if (!Schema::hasColumn('donations', 'last_name')) {
                $table->string('last_name')->nullable();
            }
            if (!Schema::hasColumn('donations', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('donations', 'address')) {
                $table->string('address')->nullable();
            }
            if (!Schema::hasColumn('donations', 'payment_method')) {
                $table->string('payment_method')->nullable();
            }
            if (!Schema::hasColumn('donations', 'mobile_money_provider')) {
                $table->string('mobile_money_provider')->nullable();
            }
            if (!Schema::hasColumn('donations', 'cover_fee')) {
                $table->boolean('cover_fee')->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $columns = [
                'first_name',
                'last_name',
                'email',
                'address',
                'payment_method',
                'mobile_money_provider',
                'cover_fee',
            ];

            // Only drop columns that exist
            foreach ($columns as $column) {
                if (Schema::hasColumn('donations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
