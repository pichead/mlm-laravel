<?php

namespace App\Exports;
use Illuminate\Http\Request;

use App\Models\PurchaseOrder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SaleReportExport implements FromView
{
    public function view(): View
    {

        return view('report.ReportExcel', [
            'PurchaseOrders' => PurchaseOrder::all()
        ]);
    }
}
