<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'supplier',
        'status',
        'created_at',
    ];

    public function lines(): HasMany
    {
        return $this->hasMany(PurchaseLine::class);
    }
}
