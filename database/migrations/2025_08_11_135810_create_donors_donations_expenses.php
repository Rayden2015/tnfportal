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
            // donors
        Schema::create('donors', function (Blueprint $t){
            $t->id();
            $t->unsignedBigInteger('tenant_id');
            $t->string('name');
            $t->string('email')->nullable();
            $t->string('phone')->nullable();
            $t->timestamps();
        });
        
        // donations
        Schema::create('donations', function (Blueprint $t){
            $t->id();
            $t->unsignedBigInteger('tenant_id');
            $t->unsignedBigInteger('donor_id')->nullable();
            $t->unsignedBigInteger('project_id')->nullable();
            $t->decimal('amount', 12, 2);
            $t->string('currency')->default('GHS');
            $t->string('payment_method')->nullable();
            $t->string('status')->default('completed'); // pending, completed, refunded
            $t->json('meta')->nullable(); // payment gateway response
            $t->timestamps();
        });
        
        // expenses
        Schema::create('expenses', function (Blueprint $t){
            $t->id();
            $t->unsignedBigInteger('tenant_id');
            $t->unsignedBigInteger('project_id')->nullable();
            $t->decimal('amount',12,2);
            $t->text('description')->nullable();
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donors');
        Schema::dropIfExists('donations');
        Schema::dropIfExists('expenses');
    }
};
