<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RechargeSetting extends Model
{
    protected $fillable = [
        'site_id',
        'recharge_amount',
        'mains_fixed_charge',
        'mains_unit_charge',
        'mains_sanction_load',
        'dg_fixed_charge',
        'dg_unit_charge',
        'dg_sanction_load',
    ];
}
