<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // idPayments
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->onDelete('cascade');
            $table->string('method', 45)->nullable(); // metode pembayaran
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('status', 45)->default('pending'); // pending, paid, failed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
