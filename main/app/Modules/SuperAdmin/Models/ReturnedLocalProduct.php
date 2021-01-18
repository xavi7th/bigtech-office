<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ProductSupplier;

class ReturnedLocalProduct extends Model
{
  use SoftDeletes;
  protected $fillable = ['product_supplier_id', 'product_description'];

  protected $casts = ['product_supplier_id' => 'int'];

  public function productSupplier()
  {
    return $this->belongsTo(ProductSupplier::class);
  }

  static function findProduct(string $imei): self
  {
    return self::where('product_description', 'LIKE', '%' . $imei . '%')->first();
  }
}
