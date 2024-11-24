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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('file');
            $table->string('file_name');
            $table->string('address_from');
            $table->string('category');
            $table->string('description');
            $table->string('location')->nullable();
            $table->foreignId('sender_id')->references('id')->on('users');
            $table->timestamp('sended_date');
            $table->foreignId('return_by')->nullable()->refernces('id')->on('users');
            $table->timestamp('return_date')->nullable();
            $table->foreignId('recieved_by')->references('id')->on('users');
            $table->timestamp('recieved_date')->nullable();
            $table->foreignId('fowarded_by')->nullable()->references('id')->on('users');
            $table->timestamp('fowarded_date')->nullable();
            $table->timestamp('active_years')->nullable();
            $table->timestamp('inactive_years')->nullable();
            $table->string('stage')->nullable(); // Default value is false
            $table->string('status');
            $table->string('type');
            $table->string('outgoing_email')->nullable();
            $table->string('lastcode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
