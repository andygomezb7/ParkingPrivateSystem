<?php

namespace App\Exports;

use App\Models\EntradaSalida;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InformeExport implements FromCollection, WithHeadings
{
    protected $registros;

    public function __construct($registros)
    {
        $this->registros = $registros;
    }

    public function collection()
    {
        return $this->registros;
    }

    public function headings(): array
    {
        return [
            'Numero de placa',
            'Tiempo estacionado (min)',
            'Cantidad a pagar',
        ];
    }
}