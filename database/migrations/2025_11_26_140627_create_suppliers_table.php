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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('contact_person', 100);
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            
            // Kolom untuk rating feedback (Optional, tapi disiapkan)
            $table->decimal('average_rating', 3, 2)->default(0.00); 
            $table->unsignedInteger('rating_count')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};