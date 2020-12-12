<?php

namespace App\Models;

use App\Presenters\TransactionPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'partner_account_id', 'funds'
    ];

    public function setFundsAttribute($funds)
    {
        $this->attributes['funds'] = $funds * 100;
    }

    public function getFundsAttribute()
    {
        return $this->attributes['funds'] / 100;
    }

    public function isIncoming()
    {
        return $this->funds > 0;
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function partner()
    {
        return $this->belongsTo(Account::class, 'partner_account_id', 'id');
    }

    public function present()
    {
        return new TransactionPresenter($this);
    }
}
