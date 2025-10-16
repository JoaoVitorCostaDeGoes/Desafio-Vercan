<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fornecedor_pj', function (Blueprint $table) {
            $table->foreignId('fornecedor_id')->primary()->constrained('fornecedores')->onDelete('cascade');
            
            $table->string('cnpj', 18)->unique();
            $table->string('razao_social', 255);
            $table->string('nome_fantasia', 255);
            $table->enum('indicador_ie', ['contribuinte', 'isento', 'nao_contribuinte']);
            $table->string('inscricao_estadual', 50)->nullable();
            $table->string('inscricao_municipal', 50)->nullable();
            $table->string('situacao_cnpj', 50)->nullable();
            $table->enum('recolhimento', ['recolher', 'retido']); 
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes(); 
        });

        Schema::create('fornecedor_pf', function (Blueprint $table) {
            $table->foreignId('fornecedor_id')->primary()->constrained('fornecedores')->onDelete('cascade');
            
            $table->string('cpf', 14)->unique();
            $table->string('nome', 255);
            $table->string('apelido', 255)->nullable();
            $table->string('rg', 50);
            $table->boolean('ativo')->default(true);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fornecedor_pf');
        Schema::dropIfExists('fornecedor_pj');
    }
};