<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\UserComment;

class UserCommentTransformer
{
  protected function strstr_after($haystack, $needle, $case_insensitive = false)
  {
    $strpos = ($case_insensitive) ? 'stripos' : 'strpos';
    $pos = $strpos($haystack, $needle);
    if (is_int($pos)) {
      return substr($haystack, $pos + strlen($needle));
    }
    // Most likely false or null
    return $pos;
  }

  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function adminViewAllComments($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      })->groupBy('user')->transform(function ($v) {
        return $v->groupBy('human_date')->merge(
          [
            'meta' => [
              'avatar' => $v[0]['avatar'],
              'full_name' => $v[0]['full_name'],
              'department' => $v[0]['department'],
            ]
          ]
        );
      });
  }

  public function basic(UserComment $comment)
  {
    return [
      'id' => (int)$comment->id,
      'comment' => (string)$comment->comment,
    ];
  }

  public function detailed(UserComment $comment)
  {
    return [
      'id' => (int)$comment->id,
      'comment' => (string)$comment->comment,
      'subject' => (string)substr(strrchr(get_class($comment->subject), '\\'), 1) . ' - ' . $comment->subject->primary_identifier(),
      'user' => (string)$comment->user->email,
      'avatar' => (string)$comment->user->avatar,
      'full_name' => (string)$comment->user->full_name,
      'department' => (string)$comment->user->getType(),
      'date' => (string)$comment->created_at,
      'time' => (string)$comment->created_at->format('H:i'),
      'human_date' => (string)$comment->created_at->diffForHumans(),
    ];
  }

  public function commentDetails(UserComment $comment)
  {
    return [
      'id' => (string)$comment->id,
      'comment' => (string)$comment->comment,
      'user' => (string)$comment->user->full_name,
      'date' => (string)$comment->created_at->diffForHumans()
    ];
  }
}
