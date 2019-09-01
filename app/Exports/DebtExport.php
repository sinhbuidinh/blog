<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DebtExport implements FromView, ShouldAutoSize
{
    private $parcels;
    private $params;
    private $guest;
    public function __construct($parcels, $params, $guest)
    {
        $this->parcels = $parcels;
        $this->params = $params;
        $this->guest = $guest;
    }
    public function view(): View
    {
        $from = !empty($this->params['from']) ? $this->params['from'] : null;
        $to = !empty($this->params['to']) ? $this->params['to'] : null;
        $amount = !empty($this->params['amount']) ? $this->params['amount'] : null;
        return view('admin.debt.export', [
            'parcels' => $this->parcels,
            'guest' => $this->guest,
            'from' => $from,
            'to' => $to,
            'amount' => $amount,
            'export' => true,
        ]);
    }
}
