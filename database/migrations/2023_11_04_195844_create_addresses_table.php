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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->morphs('addressable');
            $table->string('address');
            $table->foreignId('division_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('district_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('area_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('landmark')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('type')->nullable()->comment('1 = supplier Address,2 = customer present,3 = customer Permanent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
