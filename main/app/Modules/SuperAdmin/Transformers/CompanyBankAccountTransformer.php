<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\CompanyBankAccount;
use App\Modules\SuperAdmin\Models\SalesRecordBankAccount;

class CompanyBankAccountTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(CompanyBankAccount $account)
  {
    return [
      'id' => (int)$account->id,
      'account_name' => (string)$account->account_name,
      'account_number' => (string)$account->account_number,
      'bank' => (string)$account->bank,
      'is_suspended' => (bool) $account->deleted_at
    ];
  }



  public function fullDetails(CompanyBankAccount $account)
  {
    return [
      'id' => (int)$account->id,
      'account_name' => (string)$account->account_name,
      'account_number' => (string)$account->account_number,
      'bank' => (string)$account->bank,
      'account_description' => (string)$account->account_description,
      'account_type' => (string)$account->account_type,
      'img_url' => (string)$account->img_url,
      'is_suspended' => (bool)$account->deleted_at
    ];
  }



  public function transformWithPaymentRecord(CompanyBankAccount $account)
  {
    return [
      'id' => (int)$account->id,
      'account_name' => (string)$account->account_name,
      'account_number' => (string)$account->account_number,
      'bank' => (string)$account->bank,
      'is_suspended' => (bool) $account->deleted_at,
      'amount' => (float)$account->payment_record->amount,
    ];
  }

  public function transformWithPaymentRecordSum(CompanyBankAccount $account)
  {
    return [
      'id' => (int)$account->id,
      'account_name' => (string)$account->account_name,
      'account_number' => (string)$account->account_number,
      'bank' => (string)$account->bank,
      'is_suspended' => (bool) $account->deleted_at,
      'total_payments_received' => (float)$account->payment_records->sum('amount'),
    ];
  }


  public function transformWithPaymentRecords(CompanyBankAccount $account)
  {
    return [
      'id' => (int)$account->id,
      'account_name' => (string)$account->account_name,
      'account_number' => (string)$account->account_number,
      'bank' => (string)$account->bank,
      'is_suspended' => (bool) $account->deleted_at,
      'payment_records' => (new BankPaymentRecordTransformer)->collectionTransformer($account->payment_records, 'transformBankAccountPaymentRecord')
    ];
  }

}
