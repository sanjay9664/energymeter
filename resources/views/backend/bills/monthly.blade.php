<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Monthly Bill</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px; }
        .no-border td, .no-border th { border: none; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .header { background: #4ba82e; color: #fff; padding: 6px; font-weight: bold; }
    </style>
</head>
<body>

    {{-- Header like “Maxblis White House…” --}}
    <div class="header">
        {{ $site->project_name ?? 'Project Name' }}, {{ $site->address ?? '' }}
    </div>

    <table class="no-border">
        <tr>
            <td><strong>Name & Address</strong><br>
                {{ $site->customer_name ?? 'Customer Name' }}<br>
                {{ $site->address ?? '' }}
            </td>
            <td>
                <strong>Flat No.</strong> {{ $site->flat_no ?? '-' }}<br>
                <strong>Bill No.</strong> {{ $site->id }}{{ $month }}{{ $year }}<br>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Cust Meter No</strong> {{ $site->meter_no ?? '-' }}<br>
                <strong>Bill Gen. Date</strong> {{ now()->format('d/m/Y') }}<br>
                <strong>Bill Period</strong>
                {{ $period_start->format('d/m/Y') }} to {{ $period_end->format('d/m/Y') }}
            </td>
            <td>
                <strong>Amount Rs(+/-)</strong> {{ number_format($balanceAmount, 3) }}<br>
            </td>
        </tr>
    </table>

    <br>

    {{-- Consumption table --}}
    <table>
        <thead>
        <tr>
            <th></th>
            <th>Units</th>
            <th>Rate</th>
            <th>Amount (Rs.)</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>DG</td>
            <td class="text-right">{{ number_format($dgUnits, 3) }}</td>
            <td class="text-right">17.000</td>
            <td class="text-right">{{ number_format($dgAmount, 3) }}</td>
        </tr>
        <tr>
            <td>Mains</td>
            <td class="text-right">{{ number_format($mainsUnits, 3) }}</td>
            <td class="text-right">6.170</td>
            <td class="text-right">{{ number_format($mainsAmount, 3) }}</td>
        </tr>
        </tbody>
    </table>

    <br>

    {{-- Recharge table --}}
    <table>
        <thead>
        <tr>
            <th>Recharged On</th>
            <th>Type</th>
            <th class="text-right">Amount (Rs.)</th>
        </tr>
        </thead>
        <tbody>
        @forelse($recharges as $recharge)
            <tr>
                <td>{{ $recharge->created_at->format('d/m/Y') }}</td>
                <td>{{ $recharge->type ?? 'Credit' }}</td>
                <td class="text-right">{{ number_format($recharge->amount, 3) }}</td>
            </tr>
        @empty
            <tr><td colspan="3">No recharges this period.</td></tr>
        @endforelse
        </tbody>
    </table>

    <br>

    {{-- Summary --}}
    <table>
        <tr>
            <td>Server Rent</td>
            <td class="text-right">{{ number_format($serverRent, 3) }}</td>
        </tr>
        <tr>
            <td>Fix Charges on Sanctioned Load Mains</td>
            <td class="text-right">{{ number_format($fixChargeMains, 3) }}</td>
        </tr>
        <tr>
            <td>Water Charges</td>
            <td class="text-right">{{ number_format($waterCharges, 3) }}</td>
        </tr>
        <tr>
            <td>Charge 1</td>
            <td class="text-right">{{ number_format($charge1, 3) }}</td>
        </tr>
        <tr>
            <td>Charge 2</td>
            <td class="text-right">{{ number_format($charge2, 3) }}</td>
        </tr>
        <tr>
            <td><strong>Current Month Total</strong></td>
            <td class="text-right"><strong>{{ number_format($currentMonthTotal, 3) }}</strong></td>
        </tr>
        <tr>
            <td>Recharge Amount</td>
            <td class="text-right">{{ number_format($rechargeTotal, 3) }}</td>
        </tr>
        <tr>
            <td>Last Balance</td>
            <td class="text-right">{{ number_format($lastBalance, 3) }}</td>
        </tr>
        <tr>
            <td><strong>Balance Amount</strong></td>
            <td class="text-right"><strong>{{ number_format($balanceAmount, 3) }}</strong></td>
        </tr>
    </table>

    <br>

    <p style="font-size: 9px;">
        Notes/Instructions: All payments are to be made in Cash/Cheque/DD.
        In case of cheque dishonored customer shall pay penalty, etc…
    </p>

</body>
</html>
