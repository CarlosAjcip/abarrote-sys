<?php

namespace Database\Seeders;

use App\Models\Documento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Documento::insert([
           [
            'tipo_documento' => 'DNI',
           ],
           [
            'tipo_documento' => 'Pasaporte',
           ],
           [
            'tipo_documento' => 'RUC',
           ],
           [
            'tipo_documento' => 'Carnet Extranjero',
           ],
        ]);
    }
}
