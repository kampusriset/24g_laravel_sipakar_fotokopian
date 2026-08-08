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
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('customer_name');
            $table->integer('total_pages');
            $table->integer('copies')->default(1);
            $table->string('binding_type'); // tanpa_jilid, staples, spiral, dll.
            $table->integer('urgency_level'); // skala 1 - 10
            $table->integer('estimated_duration_minutes')->nullable();
            $table->float('priority_score')->nullable(); // skor hasil Fuzzy (0-100)
            $table->timestamp('pickup_time')->nullable();
            $table->string('status')->default('Dalam Antrean AI');
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