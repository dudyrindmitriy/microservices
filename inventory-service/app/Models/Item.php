<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
   public $timestamps = false;

    protected $fillable = [
        'sku',
        'name',
        'unit',
    ];

    public function stockBalances(): HasMany
    {
        return $this->hasMany(StockBalance::class);
    }
}
