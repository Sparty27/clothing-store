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
            $table->foreignId('user_id')->nullable()->constrained('users', 'id')->nullOnDelete();
            $table->foreignId('warehouse_id')->nullable()->constrained('warehouses', 'id')->nullOnDelete();
            $table->string('status');
            $table->bigInteger('total');
            $table->string('phone');
            $table->string('customer_name');
            $table->string('customer_last_name');
            $table->string('payment_method');
            $table->string('payment_status');
            $table->string('transaction_id')->nullable();
            $table->timestamp('transaction_modified_at')->nullable();
            $table->string('delivery_method');
            $table->string('delivery_status');
            $table->string('ttn')->nullable();
            $table->text('note')->nullable();
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
