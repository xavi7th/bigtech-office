<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\User;

class StaffTransformer
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

  public function transformBasic(User $user)
  {
    return [
      'id' => (int)$user->id,
      'full_name' => (string)$user->full_name,
    ];
  }
  public function transformForSuperAdminViewSalesReps(User $staff)
  {
    return [
      'id' => (int)$staff->id,
      'full_name' => (string)$staff->full_name,
      'email' => (string)$staff->email,
      'is_suspended' => (bool) !$staff->is_active,
      'is_deleted' => (bool) $staff->deleted_at,
      'is_online_sales_rep' => (bool) $staff->isOnlineSalesRep(),
      'office_branch' => $staff->office_branch->city
    ];
  }
}
