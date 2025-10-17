<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contatos', function (Blueprint $table) {
            $table->string('nome')->nullable()->after('fornecedor_id');
            $table->string('cargo')->nullable()->after('nome');
            $table->string('empresa')->nullable()->after('cargo');
        });
    }

    public function down(): void
    {
        Schema::table('contatos', function (Blueprint $table) {
            $table->dropColumn(['nome', 'cargo', 'empresa']);
        });
    }
};
