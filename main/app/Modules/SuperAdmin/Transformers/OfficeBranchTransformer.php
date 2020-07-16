<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\OfficeBranch;
use App\Modules\SuperAdmin\Transformers\ProductTransformer;
use App\Modules\SuperAdmin\Transformers\ProductExpenseTransformer;
use App\Modules\SuperAdmin\Transformers\ProductHistoryTransformer;
use App\Modules\SuperAdmin\Transformers\ResellerHistoryTransformer;
use App\Modules\SuperAdmin\Transformers\ProductSaleRecordTransformer;


class OfficeBranchTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(OfficeBranch $office_branch): array
  {
    return [
      'id' => (int)$office_branch->id,
      'city' => (string)$office_branch->city,
      'country' => (string)$office_branch->country,
    ];
  }

  public function transformWithProducts(OfficeBranch $office_branch)
  {
    return [
      'city' => (string)$office_branch->city,
      'country' => (string)$office_branch->country,
      'products' => (new ProductTransformer)->collectionTransformer($office_branch->products, 'basic')->groupBy('model'),
    ];
  }

  public function transformWithProductExpenses(OfficeBranch $office_branch)
  {
    return [
      'city' => (string)$office_branch->city,
      // 'country' => (string)$office_branch->country,
      'product_expenses' => (new ProductExpenseTransformer)->collectionTransformer($office_branch->product_expenses, 'basic')->groupBy('product.model'),
    ];
  }

  public function transformWithProductHistories(OfficeBranch $office_branch)
  {
    return [
      'branch' => (string)$office_branch->city,
      'product_histories' => (new ProductHistoryTransformer)->collectionTransformer($office_branch->product_histories, 'basic')->groupBy('product'),
    ];
  }

  public function transformWithResellerHistories(OfficeBranch $office_branch)
  {
    return [
      'branch' => (string)$office_branch->city,
      'product_histories' => (new ResellerHistoryTransformer)->collectionTransformer($office_branch->reseller_histories, 'basic')->groupBy('product_uuid'),
    ];
  }

  public function transformWithResellerAndProducts(OfficeBranch $office_branch)
  {
    return [
      'branch' => (string)$office_branch->city,
      'product_with_resellers' => (new ProductTransformer)->collectionTransformer($office_branch->products, 'transformWithResellerDetails')->groupBy('reseller'),
    ];
  }

  public function transformWithSalesRecords(OfficeBranch $office_branch)
  {
    return [
      'branch' => (string)$office_branch->city,
      'total_sales' => $office_branch->sales_records->count(),
      'total_confirmed_sales' => $office_branch->sales_records->where('is_confirmed', true)->count(),
      'total_selling_price' => $office_branch->sales_records->sum('selling_price'),
      'total_bank_payments' => $office_branch->sales_records->sum('total_bank_payments_amount'),
      'total_swap_deals' => $office_branch->sales_records->where('is_swap_deal', true)->count(),
      'channels_statistics' => $office_branch->sales_records->countBy(function ($record) {
        return $record->sales_channel->channel_name;
      }),
      'sales_rep_statistics' => $office_branch->sales_records->countBy(function ($record) {
        return $record->sales_rep->full_name;
      }),
      'online_rep_statistics' => $office_branch->sales_records->countBy(function ($record) {
        return $record->online_rep->full_name;
      }),
      'sales_records' => (new ProductSaleRecordTransformer)->collectionTransformer($office_branch->sales_records, 'basic'),
    ];
  }
}
