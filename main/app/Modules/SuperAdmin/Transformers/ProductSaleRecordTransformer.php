<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\SuperAdmin\Transformers\ProductTransformer;
use App\Modules\SuperAdmin\Transformers\SwapDealTransformer;
use App\Modules\SuperAdmin\Transformers\UserCommentTransformer;
use App\Modules\SuperAdmin\Transformers\CompanyBankAccountTransformer;

class ProductSaleRecordTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(ProductSaleRecord $sale_record): array
  {
    return [
      'id' => (int)$sale_record->id,
      'product_model' => (string)$sale_record->product->product_model->name,
      'product_supplier' => (string)$sale_record->product->product_supplier->name,
      'primary_identifier' => (string)$sale_record->product->primary_identifier(),
      'cost_price' => (float)$sale_record->product->product_price->cost_price,
      'proposed_selling_price' => (float)$sale_record->product->product_price->proposed_selling_price,
      'selling_price' => (float)$sale_record->selling_price,
      'total_bank_payments_amount' => (float)$sale_record->total_bank_payments_amount,
      'is_payment_complete' => (bool)$sale_record->is_payment_complete,
      'is_swap_transaction' => (bool)$sale_record->is_swap_transaction,
      'sales_channel' => (string)$sale_record->sales_channel->channel_name,
      'sales_rep' => (string)$sale_record->sales_rep->full_name . '(' . $sale_record->sales_rep->email . ')',
      'online_rep' => (string)$sale_record->online_rep->full_name . '(' . $sale_record->online_rep->email . ')',
      'sale_confirmer' => $sale_record->sale_confirmer ? (string)$sale_record->sale_confirmer->full_name . '(' . $sale_record->sale_confirmer->email . ')' : null,
      'is_confirmed' => (bool)$sale_record->sale_confirmer,
      'product_uuid' => (string)$sale_record->product->product_uuid,
    ];
  }

  public function basicSwapTransaction(ProductSaleRecord $sale_record): array
  {
    return [
      'id' => (int)$sale_record->id,
      'product_model' => (string)$sale_record->product->description,
      'product_supplier' => (string)'Swap Deal',
      'primary_identifier' => (string)$sale_record->product->primary_identifier(),
      'cost_price' => (float)$sale_record->product->cost_price,
      'proposed_selling_price' => (float)$sale_record->product->selling_price,
      'selling_price' => (float)$sale_record->selling_price,
      'total_bank_payments_amount' => (float)$sale_record->total_bank_payments_amount,
      'is_payment_complete' => (bool)$sale_record->is_payment_complete,
      'is_swap_transaction' => (bool)$sale_record->is_swap_transaction,
      'is_swap_deal' => (bool)true,
      'sales_channel' => (string)$sale_record->sales_channel->channel_name,
      'sales_rep' => (string)$sale_record->sales_rep->full_name . '(' . $sale_record->sales_rep->email . ')',
      'online_rep' => (string)$sale_record->online_rep->full_name . '(' . $sale_record->online_rep->email . ')',
      'sale_confirmer' => $sale_record->sale_confirmer ? (string)$sale_record->sale_confirmer->full_name . '(' . $sale_record->sale_confirmer->email . ')' : null,
      'is_confirmed' => (bool)$sale_record->sale_confirmer,
      'product_uuid' => (string)$sale_record->product->product_uuid,
    ];
  }

  public function transformWithComment(ProductSaleRecord $sale_record)
  {
    return [
      'id' => (int)$sale_record->id,
      'batch_number' => $sale_record->batch_number,
      'order_date' => $sale_record->order_date,
      'comments' => (new UserCommentTransformer)->collectionTransformer($sale_record->comments, 'commentDetails'),
    ];
  }

  public function transformWithBankPayments(ProductSaleRecord $sale_record)
  {
    return [
      'id' => (int)$sale_record->id,
      'selling_price' => $sale_record->selling_price,
      'total_bank_payments_amount' => $sale_record->total_bank_payments_amount,
      'is_payment_complete' => $sale_record->is_payment_complete,
      'product' => (new ProductTransformer)->basic($sale_record->product),
      'transactions' => (new CompanyBankAccountTransformer)->collectionTransformer($sale_record->bank_account_payments, 'transformWithPaymentRecord'),
    ];
  }

  public function transformWithSwapDeal(ProductSaleRecord $sale_record)
  {
    return [
      'id' => (int)$sale_record->id,
      'product_model' => (string)$sale_record->product->product_model->name,
      'primary_identifier' => (string)$sale_record->product->primary_identifier(),
      'cost_price' => (float)$sale_record->product->product_price->cost_price,
      'proposed_selling_price' => (float)$sale_record->product->product_price->proposed_selling_price,
      'selling_price' => (float)$sale_record->selling_price,
      'total_bank_payments_amount' => (float)$sale_record->total_bank_payments_amount,
      'is_payment_complete' => (bool)$sale_record->is_payment_complete,
      'is_swap_transaction' => (bool)$sale_record->is_swap_transaction,
      'sales_channel' => (string)$sale_record->sales_channel->channel_name,
      'sales_rep' => (string)$sale_record->sales_rep->full_name . '(' . $sale_record->sales_rep->email . ')',
      'online_rep' => (string)$sale_record->online_rep->full_name . '(' . $sale_record->online_rep->email . ')',
      'sale_confirmer' => $sale_record->sale_confirmer ? (string)$sale_record->sale_confirmer->full_name . '(' . $sale_record->sale_confirmer->email . ')' : null,
      'is_confirmed' => (bool)$sale_record->sale_confirmer,
      'swap_deal' => (new SwapDealTransformer)->detailed($sale_record->swap_deal)
    ];
  }
}
