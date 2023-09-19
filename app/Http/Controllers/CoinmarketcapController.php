<?php

namespace App\Http\Controllers;

use App\Models\Coinmarketcap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
// use Yajra\DataTables\Facades\DataTables;
use DataTables;

class CoinmarketcapController extends Controller
{

    public function storeCoinMarketCapData()
{
    $apiUrl = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
    $apiKey = '375a345d-f49b-40d0-820c-58b27ac18abf';
    $response = Http::withoutVerifying()->withHeaders([
        'Accept' => 'application/json',
        'X-CMC_PRO_API_KEY' => $apiKey,
        ])->get($apiUrl, [
        'start' => '1',
        'limit' => '5000',
        'convert' => 'EUR',
    ]);
    
    if ($response->successful()) {
        $data = $response->json();
        // dd($data['data']);

        foreach ($data['data'] as $item) {
            Coinmarketcap::updateOrCreate(
                ['id' => $item['id']],
                [
                    'name' => $item['name'],
                    'price' => $item['quote']['EUR']['price'],
                    'market_cap' => number_format($item['quote']['EUR']['market_cap'], 2, '.', ''),
                    'volume_24h' => number_format($item['quote']['EUR']['volume_24h'], 2, '.', ''),
                    'volume_change_24h' => number_format($item['quote']['EUR']['volume_change_24h'], 2, '.', ''),
                    'last_updated' => $item['last_updated'],
                ]
            );
        }

        return response()->json(['message' => 'Data saved to the database']);
    } else {
        // Handle the error, e.g., log it or return an error response
        return response()->json(['error' => 'Failed to fetch data from CoinMarketCap API'], 500);
    }
}

public function getList() {
    $crypto = Coinmarketcap::select('id', 'name', 'price', 'market_cap', 'volume_24h', 'volume_change_24h', 'last_updated');
    return DataTables::of($crypto)->make(true);
}
}
