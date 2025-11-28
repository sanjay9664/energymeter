<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Recharge extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'site_id',
        'recharge_id',
        'recharge_amount',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'recharge_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relationship with Site
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Relationship with DeductionHistory
     */
    public function deductionHistories(): HasMany
    {
        return $this->hasMany(DeductionHistory::class, 'recharge_id');
    }

    /**
     * Scope for current site
     */
    public function scopeForSite(Builder $query, int $siteId): Builder
    {
        return $query->where('site_id', $siteId);
    }

    /**
     * Scope for date range
     */
    public function scopeDateRange(Builder $query, string $startDate, string $endDate): Builder
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope for recharge ID
     */
    public function scopeByRechargeId(Builder $query, string $rechargeId): Builder
    {
        return $query->where('recharge_id', $rechargeId);
    }

    /**
     * Get total recharge amount for a site
     */
    public static function getTotalRecharge(?int $siteId = null): float
    {
        $query = self::query();
        
        if ($siteId) {
            $query->where('site_id', $siteId);
        }
        
        return (float) $query->sum('recharge_amount');
    }

    /**
     * Get total recharge amount with date range
     */
    public static function getTotalRechargeInDateRange(string $startDate, string $endDate, ?int $siteId = null): float
    {
        $query = self::query()->dateRange($startDate, $endDate);
        
        if ($siteId) {
            $query->where('site_id', $siteId);
        }
        
        return (float) $query->sum('recharge_amount');
    }

    /**
     * Get recent recharges
     */
    public static function getRecentRecharges(?int $siteId = null, int $limit = 10): Builder
    {
        $query = self::query()->latest();
        
        if ($siteId) {
            $query->where('site_id', $siteId);
        }
        
        return $query->limit($limit);
    }

    /**
     * Check if recharge exists by recharge_id
     */
    public static function rechargeExists(string $rechargeId): bool
    {
        return self::where('recharge_id', $rechargeId)->exists();
    }

    /**
     * Get recharge by recharge_id
     */
    public static function getByRechargeId(string $rechargeId): ?self
    {
        return self::where('recharge_id', $rechargeId)->first();
    }
}