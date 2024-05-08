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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('plisio_txn_id');
            $table->decimal('invoice_sum', 12, 6);
            $table->decimal('invoice_commission', 12, 6);
            $table->decimal('invoice_total_sum', 12, 6);
            $table->string('currency');
            $table->string('qr_url');
            $table->text('qr_code');
            $table->integer('expire_at_utc');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
