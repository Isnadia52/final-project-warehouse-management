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
        Schema::table('users', function (Blueprint $table) {
            // Kita hanya tambahkan field yang gagal di sini
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('set null')->after('role');
            $table->enum('status', ['active', 'pending', 'rejected'])->default('active')->after('role'); // Kita letakkan status sebelum supplier_id (urutan bebas)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
            $table->dropColumn(['supplier_id', 'status']);
        });
    }
};