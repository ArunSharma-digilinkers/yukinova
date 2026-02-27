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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
              $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Billing Details
            $table->string('name');
            $table->string('email');
            $table->string('phone', 20);
            $table->text('address');
            $table->string('pincode', 10);
            $table->string('state');
            $table->string('city');
            $table->string('gstin')->nullable();

            // Shipping Details
            $table->string('shipping_name')->nullable();
            $table->string('shipping_phone', 20)->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('shipping_pincode', 10)->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_city')->nullable();

            // Pricing
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('gst_total', 10, 2)->default(0);
            $table->decimal('shipping_amount', 10, 2)->default(0);
            $table->decimal('shipping_gst', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);

            // Coupon
            $table->foreignId('coupon_id')->nullable()->constrained()->onDelete('set null');

            // Payment
            $table->string('payment_method')->nullable(); // razorpay, cod, etc
            $table->string('payment_status')->default('pending'); // pending, paid, failed
            $table->string('payment_id')->nullable();

            // Invoice
            $table->string('invoice_number')->unique()->nullable();

            // Order Status
            $table->string('status')->default('pending'); // pending, confirmed, shipped, delivered, cancelled

            $table->timestamps();
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
