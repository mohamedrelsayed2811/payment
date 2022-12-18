<?php

namespace Radwan\Payment\Fawaterk\Models;

use Illuminate\Database\Eloquent\Model;

class FawaterkTransactions extends Model
{
    protected $table = 'fawaterk_transactions';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference_id','invoice_url', 'order', 'request', 'response'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'order' => 'array',
        'request' => 'array',
        'response' => 'array',
    ];
}
