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
        Schema::create('forwarded_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->nullable()->references('id')->on('documents');
            $table->foreignId('forwarded_to')->nullable()->references('id')->on('users');
            $table->foreignId('accepted_by')->nullable()->references('id')->on('users');
            $table->timestamp('accepted_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forwarded_documents');
    }
};
