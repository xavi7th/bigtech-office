<?php

namespace App\Modules\SuperAdmin\Traits;

use App\Modules\SuperAdmin\Models\UserComment;
use App\Modules\SuperAdmin\Transformers\UserCommentTransformer;

/**
 * A trait to make a model commentable
 */
trait Commentable
{
  public function comments()
  {
    return $this->morphMany(UserComment::class, 'subject')->latest();
  }

  public function commentWithDetails()
  {
    return (new UserCommentTransformer)->collectionTransformer($this->comments, 'commentDetails');
  }

  public function commentWithBasicDetails()
  {
    return (new UserCommentTransformer)->collectionTransformer($this->comments, 'basic');
  }

  public function commentWithFullDetails()
  {
    return (new UserCommentTransformer)->collectionTransformer($this->comments, 'detailed');
  }
}
