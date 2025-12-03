<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\DeductionHistory;
use App\Models\Recharge; // or whatever your recharge model is
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF; // from alias

class BillController extends Controller
{
    public function downloadMonthly(Request $request, Site $site)
    {
        $month = (int) ($request->query('month') ?? now()->month);
        $year  = (int) ($request->query('year')  ?? now()->year);

        // 1) Calculate billing period
        $start = Carbon::create($year, $month, 1)->startOfDay();
        $end   = (clone $start)->endOfMonth()->endOfDay();

        // 2) Get energy consumption (adjust field names to your DB)
        $deductions = DeductionHistory::where('site_id', $site->id)
            ->whereBetween('created_at', [$start, $end])
            ->get();

        // Example: assuming there is a 'source' column ('DG' or 'MAINS')
        $dgUnits    = $deductions->where('source', 'DG')->sum('units');
        $dgAmount   = $deductions->where('source', 'DG')->sum('amount');

        $mainsUnits  = $deductions->where('source', 'MAINS')->sum('units');
        $mainsAmount = $deductions->where('source', 'MAINS')->sum('amount');

        // 3) Recharges during this period
        $recharges = Recharge::where('site_id', $site->id)
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('created_at')
            ->get();

        // 4) Other charges (hard-coded or from config/DB)
        $serverRent         = 40.00;
        $fixChargeMains     = 475.00;
        $waterCharges       = 0.00;
        $charge1            = 0.00;
        $charge2            = 0.00;

        $currentMonthTotal  = $dgAmount + $mainsAmount
                            + $serverRent + $fixChargeMains
                            + $waterCharges + $charge1 + $charge2;

        // You might calculate these from account ledger
        $lastBalance   = 975.154;  // placeholder
        $rechargeTotal = $recharges->sum('amount');
        $balanceAmount = $lastBalance + $currentMonthTotal - $rechargeTotal;

        $data = [
            'site'              => $site,
            'month'             => $month,
            'year'              => $year,
            'period_start'      => $start,
            'period_end'        => $end,

            'dgUnits'           => $dgUnits,
            'dgAmount'          => $dgAmount,
            'mainsUnits'        => $mainsUnits,
            'mainsAmount'       => $mainsAmount,

            'serverRent'        => $serverRent,
            'fixChargeMains'    => $fixChargeMains,
            'waterCharges'      => $waterCharges,
            'charge1'           => $charge1,
            'charge2'           => $charge2,
            'currentMonthTotal' => $currentMonthTotal,

            'lastBalance'       => $lastBalance,
            'rechargeTotal'     => $rechargeTotal,
            'balanceAmount'     => $balanceAmount,

            'recharges'         => $recharges,
        ];

        $pdf = PDF::loadView('backend.bills.monthly', $data)
            ->setPaper('a4', 'portrait');

        $fileName = sprintf(
            'Bill_%s_%02d_%d.pdf',
            $site->meter_no ?? $site->id,
            $month,
            $year
        );

        return $pdf->download($fileName);
    }
}
