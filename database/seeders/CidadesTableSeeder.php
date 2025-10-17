<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CidadesTableSeeder extends Seeder
{
    public function run(): void
    {
        //DB::table('cidades')->truncate(); ou delete()
        $csvFile = database_path('seeders/data/municipios.csv'); 
        
        if (($handle = fopen($csvFile, 'r')) !== FALSE) {
            
            fgetcsv($handle, 1000, ','); 

            $cidadesParaInserir = [];

            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                
                $codigoIbge = $data[0];
                $nome = $data[1];
                $estadoId = $data[5]; 

                if (!empty($nome) && is_numeric($estadoId)) {
                    $cidadesParaInserir[] = [
                        'estado_id' => $estadoId,
                        'nome' => $nome,
                        'codigo_ibge' => $codigoIbge
                    ];
                }

                // Chunking: Inserir em lotes a cada 1000 registros para otimizar
                if (count($cidadesParaInserir) >= 1000) {
                    DB::table('cidades')->insert($cidadesParaInserir);
                    $cidadesParaInserir = [];
                }
            }
            
            if (!empty($cidadesParaInserir)) {
                DB::table('cidades')->insert($cidadesParaInserir);
            }

            fclose($handle);
        }
    }
}