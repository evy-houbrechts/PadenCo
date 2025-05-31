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

        if (Schema::hasTable('waarnemingen')) {
            // tabel bestaat al, niets doen
            return;
        }
                Schema::create('waarnemingen', function (Blueprint $table) {
            $table->id();
            $table->date('datum');
            $table->foreignId('straat_id')->constrained('straten');
            $table->foreignId('tijd_id')->constrained('tijden');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waarmenings');
    }
};
