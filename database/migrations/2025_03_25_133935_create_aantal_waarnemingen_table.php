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
       
        Schema::create('aantal_waarnemingen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('waarneming_id')->constrained('waarnemingen')->onDelete('cascade');
            $table->foreignId('soort_id')->constrained('soorten')->onDelete('cascade');
            $table->foreignId('categorie_id')->constrained('categorieen')->onDelete('cascade');
            $table->foreignId('straat_id')->constrained('straten')->onDelete('cascade');
            $table->unsignedInteger('aantal');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aantal_waarnemingen');
    }
};
