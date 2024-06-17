<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('foto')->nullable();
            $table->string('Pnombre');
            $table->string('Snombre');
            $table->string('Papellido');
            $table->string('Sapellido');
            $table->string('telefono');
            $table->string('correo');
            $table->unsignedBigInteger('departamento_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
