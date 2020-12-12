<?php

namespace App\Models;

use App\Presenters\AccountPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'number', 'funds', 'currency_id'
    ];

    public function setFundsAttribute($funds)
    {
        $this->attributes['funds'] = $funds * 100;
    }

    public function getFundsAttribute()
    {
        return $this->attributes['funds'] / 100;
    }

    public function withdraw(float $funds, Account $partner)
    {
        if ($funds <= $this->getFundsAttribute()) {

            $this->update([
                'funds' => $this->getFundsAttribute() - $funds
            ]);

            $this->transactions()->create([
                'partner_account_id' => $partner->id,
                'funds' => $funds * (-1)
            ]);
        }
    }

    public function deposit(float $funds, Account $partner)
    {
        $this->update([
            'funds' => $this->getFundsAttribute() + $funds
        ]);

        $this->transactions()->create([
            'partner_account_id' => $partner->id,
            'funds' => $funds
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function present()
    {
        return new AccountPresenter($this);
    }
}
