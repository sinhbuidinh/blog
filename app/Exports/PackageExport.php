<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PackageExport implements FromView, ShouldAutoSize
{
    private $parcels;
    private $package;
    public function __construct($parcels, $package)
    {
        $this->parcels = $parcels;
        $this->package = $package;
    }
    public function view(): View
    {
        return view('admin.package.export', [
            'parcels' => $this->parcels,
            'package' => $this->package,
            'export'  => true,
        ]);
    }
}
