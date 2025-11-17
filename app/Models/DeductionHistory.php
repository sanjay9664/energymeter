<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeductionHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'recharge_id',
        'type',
        'units',
        'amount',
    ];

    // Optional relations
    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function recharge()
    {
        return $this->belongsTo(RechargeSetting::class);
    }
}
