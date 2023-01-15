<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Transaction extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'account_number',
        'beneficiary_account_number',
        'description',
        'type',
        'amount_payer',
        'currency_payer',
        'amount_beneficiary',
        'currency_beneficiary'
    ];

    public $sortable = [
        'created_at',
//        'account_number',
        'beneficiary_account_number',
//        'amount_payer',
        'amount_beneficiary',
    ];

    public function scopeFilter($query, array $filters)
    {
        if (!empty($filters)) {
            $query
                ->whereBetween('created_at', [request('from') ?? ('2018-01-01'), request('to') ?? ('2031-01-01')])
                ->where('description', 'like', '%' . request('search') . '%')
                ->orWhere('account_number', 'like', '%' . request('search') . '%')
                ->orWhere('beneficiary_account_number', 'like', '%' . request('search') . '%');
        }
    }
}
