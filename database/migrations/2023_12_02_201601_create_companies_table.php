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
        Schema::create('companies', function (Blueprint $table) {
            $table->id(); // UnsignedBigInteger() -> UNSIGNED BIG INTEGER PRIMARY KEY AUTO_INCREMENT
            $table->string('name');
            $table->string('address')->nullable();  // by adding nullable, the column isnt required to be filled
            $table->string('website')->nullable();
            $table->string('email')->comment('Company email');
            $table->timestamps(); //created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
