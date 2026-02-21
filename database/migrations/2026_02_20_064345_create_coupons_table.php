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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
                        $table->string('code')->unique();

            $table->enum('type', ['flat', 'percentage']);

            $table->decimal('value', 10, 2);

            $table->decimal('max_discount', 10, 2)->nullable();

            $table->decimal('min_order_amount', 10, 2)->nullable();

            $table->integer('max_uses');

            $table->integer('used_count')->default(0);

            $table->dateTime('expires_at');

            $table->enum('status', ['active', 'inactive'])->default('active');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
