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
        'account_number',
        'beneficiary_account_number',
        'amount_payer',
        'amount_beneficiary',
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query
                ->where('description', 'like', '%' . $search . '%')
                ->orWhere('account_number', 'like', '%' . $search . '%')
                ->orWhere('beneficiary_account_number', 'like', '%' . $search . '%');
        });
    }
}
