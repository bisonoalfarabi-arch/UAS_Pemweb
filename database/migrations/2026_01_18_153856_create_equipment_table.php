<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('name');
            $table->text('description')->nullable();

            // kalau gambar kamu disimpan di public/images, biasanya cukup simpan nama file / path
            $table->string('image')->nullable(); // contoh: canon-r5.jpg atau images/canon-r5.jpg

            $table->unsignedInteger('stock')->default(0);
            $table->decimal('price_per_day', 12, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
