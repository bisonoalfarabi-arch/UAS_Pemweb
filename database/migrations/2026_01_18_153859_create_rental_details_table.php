<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rental_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rental_id')
                ->constrained('rentals')
                ->cascadeOnUpdate()
                ->cascadeOnDelete()
                ->unique();

            $table->string('pickup_location')->nullable();
            $table->string('return_location')->nullable();

            $table->string('phone')->nullable();
            $table->text('notes')->nullable();

            // kalau nanti butuh denda / deposit:
            $table->decimal('deposit', 12, 2)->default(0);
            $table->decimal('penalty', 12, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_details');
    }
};
