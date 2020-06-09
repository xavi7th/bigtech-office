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
      'date' => (string)$comment->created_at
    ];
  }

  public function commentDetails(UserComment $comment)
  {
    return [
      'comment' => (string)$comment->comment,
      'user' => (string)$comment->user->email,
      'date' => (string)$comment->created_at
    ];
  }
}
