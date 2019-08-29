<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DebtExport implements FromView
{
    private $parcels;
    public function __construct($parcels)
    {
        $this->parcels = $parcels;
    }
    public function view(): View
    {
        return view('admin.debt.export', [
            'parcels' => $this->parcels
        ]);
    }
}
