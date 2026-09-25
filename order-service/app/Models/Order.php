<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
   public $timestamps = false;

    protected $fillable = [
        'requester',
        'status',
        'created_at',
    ];

    public function lines(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }
}
