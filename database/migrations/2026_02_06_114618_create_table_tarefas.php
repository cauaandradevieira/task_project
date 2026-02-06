<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tarefas', function (Blueprint $table) {
            $table->id(); 

            $table->string('nome')->unique(); 

            $table->decimal('custo', 10, 2)->unsigned(); 

            $table->date('data_limite'); 

            $table->integer('ordem_apresentacao')->unique(); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_tarefas');
    }
};
