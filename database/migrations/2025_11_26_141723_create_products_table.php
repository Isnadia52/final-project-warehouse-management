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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 50)->unique(); // Wajib Unique Identifier
            $table->string('name', 150); // Nama produk
            $table->text('description')->nullable(); // Deskripsi produk
            $table->string('image')->nullable(); // Gambar produk
            
            // Foreign Key ke Categories (relasi One-to-Many)
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict'); 
            
            // Informasi Stok dan Harga
            $table->string('unit', 20); // Satuan (pcs, box, kg, liter)
            $table->integer('current_stock')->default(0); // Stok saat ini
            $table->integer('min_stock_alert')->default(10); // Stok minimum untuk alert
            $table->string('warehouse_location', 50)->nullable(); // Lokasi rak di gudang
            
            $table->decimal('purchase_price', 10, 2); // Harga beli
            $table->decimal('selling_price', 10, 2); // Harga jual
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};