<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransaksiExport implements FromView
{
    protected $laporantransaksis;

    public function __construct($laporantransaksis)
    {
        $this->laporantransaksis = $laporantransaksis;
    }

    public function view(): View
    {
        return view('laporantransaksi.excel', [
            'laporantransaksis' => $this->laporantransaksis
        ]);
    }
}
