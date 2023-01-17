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
    ];

    public function scopeFilter($query, array $filters)
    {
        if (!empty($filters)) {
            $query
                ->whereBetween('created_at', [request('from') ?? null, request('to') ?? null])
                ->where('description', 'like', '%' . request('search') . '%')
                ->where('account_number', 'like', '%' . request('search') . '%')
                ->where('beneficiary_account_number', 'like', '%' . request('search') . '%');
        }
    }
}
