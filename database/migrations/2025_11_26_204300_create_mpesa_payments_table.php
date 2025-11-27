<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mpesa_payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('phone');
            $table->decimal('amount', 10, 2);

            $table->string('checkout_id')->nullable();      // MerchantRequestID
            $table->string('transaction_code')->nullable(); // Mpesa Receipt Number

            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mpesa_payments');
    }
};

