<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class ResellerTransaction extends Model
{
  protected $fillable = ['amount', 'purpose', 'reseller_id', 'trans_type'];
  protected $casts = [
    'amount' => 'float',
    'reseller_id' => 'int',
    'recorder_id' => 'int',
  ];

  public function reseller()
  {
    return $this->belongsTo(Reseller::class);
  }

  public function recorder()
  {
    return $this->morphTo();
  }

  public function getAmountAttribute($value): float
  {
    return $this->trans_type == 'credit' ? $value : $value * -1;
  }

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($resellerTransaction) {
      request()->user() && $resellerTransaction->recorder_id = request()->user()->id;
      request()->user() && $resellerTransaction->recorder_type = get_class(request()->user());
    });

    static::saved(function ($reseller) {
      // Cache::forget('resellers');
    });
  }
}
