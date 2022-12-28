<?php

namespace Radwan\Payment\Fawaterk\Models;

use Illuminate\Database\Eloquent\Model;


class FawaterkTransactions extends Model
{
    protected $table = 'fawaterk_transactions';

    protected $fillable = ['reference_id', 'invoice_url', 'order', 'request', 'response', 'status', 'user_id','data_fields'];
    public $timestamps = true;

    protected $guarded = ['id'];

    protected $hidden = [
    ];

    protected $casts = [
        'order' => 'array',
        'request' => 'array',
        'response' => 'array',
        'data_fields' => 'array',
    ];
}
