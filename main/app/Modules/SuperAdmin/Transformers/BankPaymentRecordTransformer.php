<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\SalesRecordBankAccount;

class BankPaymentRecordTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(SalesRecordBankAccount $account)
  {
    return [
      'id' => (int)$account->id,
      'account_name' => (string)$account->account_name,
      'account_number' => (string)$account->account_number,
      'bank' => (string)$account->bank,
      'is_suspended' => (bool) $account->deleted_at
    ];
  }

  public function fullDetails(SalesRecordBankAccount $record)
  {
    // dd($record->toArray());
    return [
      'id' => $record->id,
      'account_name' => $record->company_bank_account->account_name,
      'account_number' => $record->company_bank_account->account_number,
      'bank' => $record->company_bank_account->bank,
      'amount_paid' => (float)$record->amount,
      'is_swap_transaction' => (bool)$record->product_sale_record->is_swap_transaction,
      'product_price' => (float)$record->product_sale_record->product->product_price->proposed_selling_price,
      'sale_price' => (float)$record->product_sale_record->selling_price,
      'product' =>  (string)$record->product_sale_record->product->product_model->name,
      'primary_identifier' =>  (string)$record->product_sale_record->product->primary_identifier(),
      'created_at' => $record->created_at
    ];
  }

  public function transformForSummary(SalesRecordBankAccount $record)
  {
    // dd($record->toArray());
    return [
      'id' => $record->id,
      'account_name' => $record->company_bank_account->account_name,
      'account_number' => $record->company_bank_account->account_number,
      'bank' => $record->company_bank_account->bank,
      'amount_paid' => (float)$record->amount,
      'is_swap_transaction' => (bool)$record->product_sale_record->is_swap_transaction,
      'product_price' => (float)$record->product_sale_record->product->product_price->proposed_selling_price,
      'sale_price' => (float)$record->product_sale_record->selling_price,
      'product' =>  (string)$record->product_sale_record->product->product_model->name,
      'primary_identifier' =>  (string)$record->product_sale_record->product->primary_identifier(),
      'created_at' => $record->created_at->toDateString()
    ];
  }

  public function transformBankAccountPaymentRecord(SalesRecordBankAccount $record)
  {
    return [
      'id' => $record->id,
      'amount_paid' => (float)$record->amount,
      'is_swap_transaction' => (bool)$record->product_sale_record->is_swap_transaction,
      'product_price' => (float)$record->product_sale_record->product->product_price->proposed_selling_price,
      'sale_price' => (float)$record->product_sale_record->selling_price,
      'product' =>  (string)$record->product_sale_record->product->product_model->name,
      'primary_identifier' =>  (string)$record->product_sale_record->product->primary_identifier(),
      'created_at' => $record->created_at
    ];
  }
}
