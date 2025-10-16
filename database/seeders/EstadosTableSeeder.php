<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosTableSeeder extends Seeder
{
    public function run(): void
    {
        // Desabilitar o Mass Assignment Protection temporariamente
        // E o auto-incremento para poder inserir IDs específicos
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        DB::table('estados')->truncate(); 

        $estados = [
            ['id' => 12, 'uf' => 'AC', 'nome' => 'Acre'],
            ['id' => 27, 'uf' => 'AL', 'nome' => 'Alagoas'],
            ['id' => 16, 'uf' => 'AP', 'nome' => 'Amapá'],
            ['id' => 13, 'uf' => 'AM', 'nome' => 'Amazonas'],
            ['id' => 29, 'uf' => 'BA', 'nome' => 'Bahia'],
            ['id' => 23, 'uf' => 'CE', 'nome' => 'Ceará'],
            ['id' => 53, 'uf' => 'DF', 'nome' => 'Distrito Federal'],
            ['id' => 32, 'uf' => 'ES', 'nome' => 'Espírito Santo'],
            ['id' => 52, 'uf' => 'GO', 'nome' => 'Goiás'],
            ['id' => 21, 'uf' => 'MA', 'nome' => 'Maranhão'],
            ['id' => 51, 'uf' => 'MT', 'nome' => 'Mato Grosso'],
            ['id' => 50, 'uf' => 'MS', 'nome' => 'Mato Grosso do Sul'],
            ['id' => 31, 'uf' => 'MG', 'nome' => 'Minas Gerais'],
            ['id' => 15, 'uf' => 'PA', 'nome' => 'Pará'],
            ['id' => 25, 'uf' => 'PB', 'nome' => 'Paraíba'],
            ['id' => 41, 'uf' => 'PR', 'nome' => 'Paraná'],
            ['id' => 26, 'uf' => 'PE', 'nome' => 'Pernambuco'],
            ['id' => 22, 'uf' => 'PI', 'nome' => 'Piauí'],
            ['id' => 33, 'uf' => 'RJ', 'nome' => 'Rio de Janeiro'],
            ['id' => 24, 'uf' => 'RN', 'nome' => 'Rio Grande do Norte'],
            ['id' => 43, 'uf' => 'RS', 'nome' => 'Rio Grande do Sul'],
            ['id' => 11, 'uf' => 'RO', 'nome' => 'Rondônia'],
            ['id' => 14, 'uf' => 'RR', 'nome' => 'Roraima'],
            ['id' => 42, 'uf' => 'SC', 'nome' => 'Santa Catarina'],
            ['id' => 35, 'uf' => 'SP', 'nome' => 'São Paulo'],
            ['id' => 28, 'uf' => 'SE', 'nome' => 'Sergipe'],
            ['id' => 17, 'uf' => 'TO', 'nome' => 'Tocantins'],
        ];

        DB::table('estados')->insert($estados);
        
        // Reabilitar o auto-incremento e a checagem de FKs
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}