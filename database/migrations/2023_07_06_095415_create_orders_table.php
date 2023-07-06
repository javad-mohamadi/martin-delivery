<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('provider_name');
            $table->string('provider_mobile');
            $table->text('provider_address');
            $table->decimal('provider_latitude', 10, 7);
            $table->decimal('provider_longitude', 10, 7);
            $table->string('receiver_name');
            $table->string('receiver_mobile');
            $table->text('receiver_address');
            $table->decimal('receiver_latitude', 10, 7);
            $table->decimal('receiver_longitude', 10, 7);
            $table->string('status');

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
