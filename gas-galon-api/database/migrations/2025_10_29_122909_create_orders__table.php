<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); 


            $table->foreignId('customer_id')
                  ->constrained('users')
                  ->onDelete('cascade');


            $table->foreignId('driver_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');


            $table->foreignId('order_detail_id')
                  ->nullable()
                  ->constrained('order_details')
                  ->onDelete('set null');

            $table->dateTime('order_date')->default(now());
            $table->string('status', 50)->default('processing'); // pending, processing, delivered, completed
            $table->decimal('total_price', 10, 2)->default(0);
            $table->string('delivery_address', 255)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
