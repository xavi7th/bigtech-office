<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\User;
use App\Modules\SuperAdmin\Transformers\AuditorActivityLogTransformer;

class SuperAdminAppUserTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    // return $collection;
    // return [
    // 	'total' => $collection->count(),
    // 	'current_page' => $collection->currentPage(),
    // 	'path' => $collection->resolveCurrentPath(),
    // 	$collection->hasMorePages(),
    // 	'to' => $collection->lastItem(),
    // 	'from' => $collection->firstItem(),
    // 	'last_page' => $collection->lastPage(),
    // 	'next_page_url' => $collection->nextPageUrl(),
    // 	'per_page' => $collection->perPage(),
    // 	'prev_page_url' => $collection->previousPageUrl(),
    // 	'total' => $collection->total(),
    // 	'first_page_url' => $collection->url($collection->firstItem()),
    // 	'last_page_url' => $collection->url($collection->lastPage()),
    // 	$collection->items(),
    // ];
    return $collection->map(function ($v) use ($transformerMethod) {
      return $this->$transformerMethod($v);
    });
    // [
    // 'total' => $collection->count(),
    // 'current_page' => $collection->currentPage(),
    // 'path' => $collection->resolveCurrentPath(),
    // 'to' => $collection->lastItem(),
    // 'from' => $collection->firstItem(),
    // 'last_page' => $collection->lastPage(),
    // 'next_page_url' => $collection->nextPageUrl(),
    // 'per_page' => $collection->perPage(),
    // 'prev_page_url' => $collection->previousPageUrl(),
    // 'total' => $collection->total(),
    // 'first_page_url' => $collection->url($collection->firstItem()),
    // 'last_page_url' => $collection->url($collection->lastPage()),
    // 	'users' => $collection->map(function ($v) use ($transformerMethod) {
    // 		return $this->$transformerMethod($v);
    // 	})
    // ];
  }

  public function basic($user)
  {
    return [
      'id' => $user->id,
      'first_name' => $user->first_name,
      'last_name' => $user->last_name,
      'email' => $user->email,
    ];
  }

  public function transformWithActivity(User $user)
  {
    return [
      'id' => $user->id,
      'full_name' => $user->full_name,
      'email' => $user->email,
      'activities' => (new AuditorActivityLogTransformer)->collectionTransformer($user->activities, 'basicTransform')['activities']
    ];
  }

  public function transformForAdminViewUsers(User $user)
  {
    return [
      'id' => (int)$user->id,
      'full_name' => (string)$user->full_name,
      'email' => (string)$user->email,
      'phone' => (string)$user->phone,
      'avatar' => (string)$user->avatar,
      'gender' => (string)$user->gender,
      'acc_type' => (string)$user->acc_type,
      'acc_num' => (string)$user->acc_num,
      'address' => (string)$user->address,
      'is_verified' => (bool)$user->is_verified(),
      'is_processed' => (bool)$user->is_processed,
    ];
  }
}
