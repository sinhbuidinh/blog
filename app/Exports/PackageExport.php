<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PackageExport implements FromView, ShouldAutoSize
{
    private $parcels;
    private $package;
    private $amounts;
    public function __construct($parcels, $package, $amounts)
    {
        $this->parcels = $parcels;
        $this->package = $package;
        $this->amounts = $amounts;
    }
    public function view(): View
    {
        return view('admin.package.export', [
            'parcels' => $this->parcels,
            'package' => $this->package,
            'amounts' => $this->amounts,
            'export'  => true,
        ]);
    }
}
