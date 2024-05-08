<?php

use App\Models\Address;
use App\Models\Item;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pay', function () {
    return view('pay');
});

Route::post('/pay', function (Request $request) {
    $response = Http::get('https://api.plisio.net/api/v1/invoices/new', [
        'api_key' => env('PLISIO_API_KEY'),
        'source_currency' => 'USD',
        'source_amount' => 3,
        'currency' => $request->input('currency'),
        'order_name' => 'test',
        'order_number' => uniqid(),
        'callback_url' => 'http://vps63409.hyperhost.name/payment/callback',
    ])->json();

    if ($response['status'] == 'success') {
        $payment = Payment::create([
            'plisio_txn_id' => $response['data']['id'],
            'invoice_sum' => $response['data']['invoice_sum'],
            'invoice_commission' => $response['data']['invoice_commission'],
            'invoice_total_sum' => $response['data']['invoice_total_sum'],
            'currency' => $response['data']['currency'],
            'qr_url' => $response['data']['qr_url'],
            'qr_code' => $response['data']['qr_code'],
            'expire_at_utc' => $response['data']['expire_at_utc'],
            'status' => $response['data']['status'],
        ]);

        return redirect()->route('payment', ['payment' => $payment->id,]);
    } else {
        return back()->withErrors([$response['data']['name'],]);
    }
});

Route::get('/payment/{payment}', function (Payment $payment) {
    return view('payment', ['payment' => $payment,]);
})->name('payment');

Route::get('/payment/{payment}/status', function (Payment $payment) {
    return response()->json(['status' => $payment->status,]);
});

Route::post('/payment/callback', function (Request $request) {
    $txn_id = $request->input('txn_id');
    if ($payment = Payment::firstWhere('plisio_txn_id', $txn_id)) {
        $payment->status = $request->input('status');
        $payment->save();
    }
});

Route::get('/withdraw', function () {
    return view('withdraw');
});

Route::post('/withdraw', function (Request $request) {
    $response = Http::get('https://api.plisio.net/api/v1/operations/withdraw', [
        'api_key' => env('PLISIO_API_KEY'),
        'type' => 'cash_out',
        'to' => $request->input('to'),
        'currency' => $request->input('currency'),
        'amount' => $request->input('amount'),

    ])->json();

    if ($response['status'] == 'success') {
        return back()->with('message', 'OK');
    } else {
        return back()->withErrors($response['data']['name'] ?? $response['data']['message']);
    }
});

Route::get('/withdraw/info', function (Request $request) {
    $currency = $request->query('currency');
    $amount = $request->query('amount');

    $responses = Http::pool(fn (Pool $pool) => [
        $pool->get("https://api.plisio.net/api/v1/balances/{$currency}", [
            'api_key' => env('PLISIO_API_KEY'),
        ]),
        $pool->get("https://api.plisio.net/api/v1/operations/fee/{$currency}", [
            'api_key' => env('PLISIO_API_KEY'),
            'amounts' => $amount,
        ]),
    ]);

    $balance = $responses[0]->json();
    $fee = $responses[1]->json();

    if ($balance['status'] == 'success' and $fee['status'] == 'success') {
        return response()->json([
            'balance' => $balance['data']['balance'],
            'fee' => $fee['data']['fee'],
        ]);
    } else {
        return response('', 400);
    }
});

Route::get('/random', function (Request $request) {
    $page = $request->query('page', 1);

    $items = Item::random($page);
    $time = Cache::getTTL('seed');

    return view('random', [
        'items' => $items,
        'time' => $time,
    ]);
});

Route::get('/template', function () {
    return view('template');
});

Route::get('/distance', function (Request $request) {
    $radius = $request->query('radius');

    $geo = unserialize(file_get_contents('http://ip-api.com/php/' . $request->ip()));

    $addresses = Address::inRadius(
        $geo['lat'], 
        $geo['lon'], 
        $radius
    );

    return view('distance', [
        'radius' => $radius,
        'geo' => $geo,
        'addresses' => $addresses,
    ]);
});