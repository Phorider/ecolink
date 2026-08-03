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
        Schema::create('waste_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('collector_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('type', ['Plastic', 'Paper', 'Glass', 'Metal', 'E-waste', 'Organic']);
            $table->decimal('weight', 8, 2)->comment('Estimated weight in kg');
            $table->string('address');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['Pending', 'Accepted', 'Collected', 'Cancelled'])->default('Pending');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('collected_at')->nullable();
            $table->timestamps();

            $table->index(['status']);
            $table->index(['type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_requests');
    }
};
