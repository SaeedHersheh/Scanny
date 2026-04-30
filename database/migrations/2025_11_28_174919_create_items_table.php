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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->decimal('price',10,2)->default(0);
            $table->integer('count')->default(0);
            $table->string('photo_path')->nullable();

            $table->timestamps();



            $table->foreignId('vending_machine_id')
                  ->constrained('vending_machines')// or ->references('id') ->on(vending_machines)
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
