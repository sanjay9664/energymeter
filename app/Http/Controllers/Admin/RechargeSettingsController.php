<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RechargeSetting;

class RechargeSettingsController extends Controller
{
    // Load existing values
    public function index($site_id = null)
    {
        // Agar site wise data store kar rahe ho
        $setting = RechargeSetting::where('site_id', $site_id)->first();

        return view('admin.recharge_settings', compact('setting', 'site_id'));
    }

    // Save or update
    public function store(Request $request)
    {
        $validated = $request->validate([
            'site_id' => 'nullable|integer',
            'recharge_amount' => 'nullable|numeric',
            'mains_fixed_charge' => 'nullable|numeric',
            'mains_unit_charge' => 'nullable|numeric',
            'mains_sanction_load' => 'nullable|numeric',
            'dg_fixed_charge' => 'nullable|numeric',
            'dg_unit_charge' => 'nullable|numeric',
            'dg_sanction_load' => 'nullable|numeric',
        ]);

        // updateOrCreate ka matlab: agar site_id ka record hai to update, nahi to create
        RechargeSetting::updateOrCreate(
            ['site_id' => $request->site_id],
            $validated
        );

        return back()->with('success', 'Recharge settings saved successfully!');
    }
}
