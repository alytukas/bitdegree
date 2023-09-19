<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coinmarketcap extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', // Add 'id' to the fillable array
        'name',
        'symbol',
        'cmc_rank',
        'price',
        'market_cap',
        'volume_24h',
        'volume_change_24h',
        'last_updated',
        // Add more fields as needed
    ];
}
