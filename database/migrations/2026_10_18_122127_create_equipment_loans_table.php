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
        Schema::create('equipment_loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('operator_id');
            $table->unsignedBigInteger('crew_id');
            $table->foreignId('equipment_id')->constrained()->cascadeOnDelete();
            $table->string('project_name');
            $table->integer('quantity')->default(1);

            // tanggal yang diajukan
            $table->date('requested_checkout_date');
            $table->date('expected_return_date');

            // tanggal yang dicatat petugas
            $table->date('actual_checkout_date')->nullable();
            $table->date('actual_return_date')->nullable();

            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'borrowed',
                'returned',
                'late_returned',
                'overdue'
            ])->default('pending');

            $table->text('feedback')->nullable(); // untuk alasan penolakan atau informasi kondisi barang

            $table->foreign('operator_id')->on('users')->references('id')->cascadeOnDelete();
            $table->foreign('crew_id')->on('users')->references('id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_loans');
    }
};
