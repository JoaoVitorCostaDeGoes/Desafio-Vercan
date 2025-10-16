<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->foreignId('fornecedor_id')->primary()->constrained('fornecedores')->onDelete('cascade');
            
            $table->string('cep', 10);
            $table->string('logradouro', 255);
            $table->string('numero', 20);
            $table->string('complemento', 100)->nullable();
            $table->string('bairro', 100);
            $table->string('ponto_referencia', 255)->nullable();
            
            $table->unsignedBigInteger('estado_id');
            $table->foreign('estado_id')->references('id')->on('estados');
            
            $table->foreignId('cidade_id')->constrained('cidades');
            
            $table->enum('condominio_sn', ['Sim', 'Não']);
            $table->string('condominio_endereco', 255)->nullable();
            $table->string('condominio_numero', 20)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enderecos');
    }
};