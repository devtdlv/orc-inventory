<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'barcode',
        'qr_code',
        'stock_level',
        'min_stock_level',
        'location',
        'is_consumable',
        'is_tool',
    ];

    protected function casts(): array
    {
        return [
            'is_consumable' => 'boolean',
            'is_tool' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function maintenanceLogs(): HasMany
    {
        return $this->hasMany(MaintenanceLog::class);
    }

    public function checkouts(): HasMany
    {
        return $this->hasMany(Checkout::class);
    }

    public function consumables(): HasMany
    {
        return $this->hasMany(Consumable::class);
    }

    public function isLowStock(): bool
    {
        return $this->stock_level <= $this->min_stock_level;
    }

    public function isCheckedOut(): bool
    {
        return $this->checkouts()
            ->where('status', 'checked_out')
            ->exists();
    }
}
