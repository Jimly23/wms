<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoodsIn;
use App\Models\GoodsOut;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        list($transactions, $type, $startDate, $endDate) = $this->getFilteredData($request);
        
        return view('reports.index', compact('transactions', 'type', 'startDate', 'endDate'));
    }

    public function exportPdf(Request $request)
    {
        list($transactions, $type, $startDate, $endDate) = $this->getFilteredData($request);

        $pdf = Pdf::loadView('reports.pdf', compact('transactions', 'type', 'startDate', 'endDate'));
        
        $filename = 'Laporan_Barang_' . $type . '_' . Carbon::now()->format('Ymd_His') . '.pdf';
        
        return $pdf->download($filename);
    }

    private function getFilteredData(Request $request)
    {
        $type = $request->input('type', 'masuk');
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        if ($type === 'masuk') {
            $query = GoodsIn::with(['item.rack', 'createdBy']);
        } else {
            $query = GoodsOut::with(['item.rack', 'createdBy']);
        }

        if ($startDate) {
            $query->whereDate('tanggal', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->whereDate('tanggal', '<=', $endDate);
        }

        $transactions = $query->orderBy('tanggal', 'desc')->get();

        return [$transactions, $type, $startDate, $endDate];
    }
}
