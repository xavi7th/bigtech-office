<?php

namespace App\Modules\SalesRep\Transformers;

use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\SalesRep\Models\Transaction;

class SalesRepTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    // try {
    //   return [
    //     'total' => $collection->count(),
    //     'current_page' => $collection->currentPage(),
    //     'path' => $collection->resolveCurrentPath(),
    //     'to' => $collection->lastItem(),
    //     'from' => $collection->firstItem(),
    //     'last_page' => $collection->lastPage(),
    //     'next_page_url' => $collection->nextPageUrl(),
    //     'per_page' => $collection->perPage(),
    //     'prev_page_url' => $collection->previousPageUrl(),
    //     'total' => $collection->total(),
    //     'first_page_url' => $collection->url($collection->firstItem()),
    //     'last_page_url' => $collection->url($collection->lastPage()),
    //     'data' => $collection->map(function ($v) use ($transformerMethod) {
    //       return $this->$transformerMethod($v);
    //     })
    //   ];
    // } catch (\Throwable $e) {
    return $collection->map(function ($v) use ($transformerMethod) {
      return $this->$transformerMethod($v);
    });
    // }
  }

  public function transform(SalesRep $user)
  {
    return [
      'first_name' => (string)$user->first_name,
      'last_name' => (string)$user->last_name,
      'email' => (string)$user->email,
      'phone' => (string)$user->phone,
      'address' => (string)$user->address,
      'city' => (string)$user->city,
      'num_of_days_active' => (int)$user->activeDays(),
      'is_otp_verified' => (bool)$user->is_otp_verified()

    ];
  }

  public function transformBasic(SalesRep $user)
  {
    return [
      'id' => (int)$user->id,
      'full_name' => (string)$user->full_name,
    ];
  }

  public function transformForSalesRep(SalesRep $user)
  {
    $curr = (function () use ($user) {
      switch ($user->currency) {
        case 'USD':
          return '$';
          break;
        case 'GBP':
          return '£';
          break;
        case 'EUR':
          return '€';
          break;

        default:
          return $user->currency;
          break;
      }
    })();
    return [
      'id' => (int)$user->id,
      'name' => (string)$user->name,
      'email' => (string)$user->email,
      'country' => (string)$user->country,
      'currency' => (string)$curr,
      'phone' => (string)$user->phone,
      'id_card' => (string)$user->id_card,
      // 'is_verified' => (bool)$user->is_verified(),
      'total_deposit' => (float)$user->total_deposit_amount(),
      'total_withdrawal' => (float)$user->total_withdrawal_amount(),
      'total_profit' => (float)$user->total_profit_amount(),
      'target_profit' => (float)$user->expected_withdrawal_amount(),
      'total_withdrawable' => (float)number_format($user->total_withdrawalable_amount(), 2, '.', '')
    ];
  }

  public function transformForAdminViewSalesReps(SalesRep $salesRep)
  {
    return [
      'id' => (int)$salesRep->id,
      'name' => (string)$salesRep->full_name,
      'total_deposit' => (float)$salesRep->monthly_sales_count(),
      'total_withdrawal' => (float)$salesRep->total_withdrawal_amount(),
      'total_profit' => (float)$salesRep->total_profit_amount(),
      'target_profit' => (float)$salesRep->expected_withdrawal_amount(),
      'total_withdrawable' => (float)number_format($salesRep->total_withdrawalable_amount(), 2, '.', '')
    ];
  }

  public function transformForSuperAdminViewSalesReps(SalesRep $salesRep)
  {
    return [
      'id' => (int)$salesRep->id,
      'full_name' => (string)$salesRep->full_name,
      'email' => (string)$salesRep->email,
      'is_suspended' => (bool) $salesRep->deleted_at,
      'is_online_sales_rep' => (bool) $salesRep->isOnlineSalesRep(),
      'statistics' => [
        'total_online_sales_count' => (float)$salesRep->online_sales_records_count,
        'total_walk_in_sales_count' => (float)$salesRep->walk_in_sales_records_count,
        'total_online_sales_amount' => (float)$salesRep->total_online_sales_amount,
        'total_walk_in_sales_amount' => (float)$salesRep->total_walk_in_sales_amount,
        'total_online_sales_bonus_amount' => (float)$salesRep->total_online_sales_bonus_amount,
        'total_walk_in_sales_bonus_amount' => (float)$salesRep->total_walk_in_sales_bonus_amount,
        'monthly_online_sales_count' => (float)$salesRep->monthly_online_sales_records_count,
        'monthly_walk_in_sales_count' => (float)$salesRep->monthly_walk_in_sales_records_count,
        'monthly_online_sales_amount' => (float)$salesRep->monthly_total_online_sales_amount,
        'monthly_walk_in_sales_amount' => (float)$salesRep->monthly_total_walk_in_sales_amount,
        'monthly_online_sales_bonus_amount' => (float)$salesRep->monthly_total_online_sales_bonus_amount,
        'monthly_walk_in_sales_bonus_amount' => (float)$salesRep->monthly_total_walk_in_sales_bonus_amount,
        'today_online_sales_count' => (float)$salesRep->today_online_sales_count,
        'today_walk_in_sales_count' => (float)$salesRep->today_walk_in_sales_count,
        'today_online_sales_amount' => (float)$salesRep->today_online_sales_amount,
        'today_walk_in_sales_amount' => (float)$salesRep->today_walk_in_sales_amount,
        'today_online_sales_bonus_amount' => (float)$salesRep->today_online_sales_bonus_amount,
        'today_walk_in_sales_bonus_amount' => (float)$salesRep->today_walk_in_sales_bonus_amount,
      ]
    ];
  }

  public function transformForSalesRepsDashboard(SalesRep $salesRep)
  {
    return [

      'total_online_sales_count' => (float)$salesRep->online_sales_records_count,
      'total_walk_in_sales_count' => (float)$salesRep->walk_in_sales_records_count,
      'total_online_sales_amount' => (float) $salesRep->total_online_sales_amount,
      'total_walk_in_sales_amount' => (float) $salesRep->total_walk_in_sales_amount,
      'monthly_online_sales_amount' => (float) $salesRep->monthly_online_sales_amount,
      'monthly_walk_in_sales_amount' => (float) $salesRep->monthly_walk_in_sales_amount,
      'monthly_online_sales_bonus_amount' => (float) $salesRep->monthly_online_sales_bonus_amount,
      'monthly_walk_in_sales_bonus_amount' => (float) $salesRep->monthly_walk_in_sales_bonus_amount,
      'monthly_online_sales_count' => (float) $salesRep->monthly_online_sales_count,
      'monthly_walk_in_sales_count' => (float) $salesRep->monthly_walk_in_sales_count,
      'today_online_sales_count' => (float) $salesRep->today_online_sales_count,
      'today_walk_in_sales_count' => (float) $salesRep->today_walk_in_sales_count,
      'today_online_sales_amount' => (float) $salesRep->today_online_sales_amount,
      'today_walk_in_sales_amount' => (float) $salesRep->today_walk_in_sales_amount,
      'today_online_sales_bonus_amount' => (float) $salesRep->today_online_sales_bonus_amount,
      'today_walk_in_sales_bonus_amount' => (float) $salesRep->today_walk_in_sales_bonus_amount,

    ];
  }
}
