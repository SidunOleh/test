<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'plisio_txn_id',
        'invoice_sum',
        'invoice_commission',
        'invoice_total_sum',
        'currency',
        'qr_url',
        'qr_code',
        'expire_at_utc',
        'status',
    ];  
}
