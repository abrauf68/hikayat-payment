<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('variant_name');
            $table->string('client_name');
            $table->double('original_price', 10, 2)->default(0);
            $table->double('discounted_price', 10, 2)->default(0);
            $table->integer('discount_percentage')->default(0);
            $table->enum('payment_status', ['paid', 'unpaid'])->default('paid');
            $table->dateTime('purchase_date');
            $table->dateTime('payment_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
