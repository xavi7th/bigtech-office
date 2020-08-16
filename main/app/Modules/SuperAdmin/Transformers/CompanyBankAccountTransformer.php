<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\CompanyBankAccount;

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
      'amount' => (string)$account->payment_record->amount,
    ];
  }
}
