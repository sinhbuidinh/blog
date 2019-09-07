<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ParcelExport implements FromView, ShouldAutoSize
{
    private $parcels;
    private $guest;
    private $params;
    public function __construct($parcels, $params)
    {
        $this->parcels = $parcels;
        $this->guest = data_get($params, 'guest');
        $this->params = $params;
    }
    public function view(): View
    {
        $params = $this->params;
        $search = $params['search'];
        if (!empty($search['dates'])) {
            list($this->from, $this->to) = explode(' to ', $search['dates']);
        }
        return view('admin.parcel.export', [
            'parcels' => $this->parcels,
            'guest'   => $this->guest,
            'from'    => $from ?? null,
            'to'      => $to ?? null,
            'amounts' => $params['amounts'],
        ]);
    }
}
