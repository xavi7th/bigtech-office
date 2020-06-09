<?php

namespace App\Modules\AppUser\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\AppUser\Models\Message
 *
 * @property int $id
 * @property string $phone
 * @property string $email
 * @property string $subject
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Message whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Message wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Message whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Message whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Message extends Model
{
  protected $fillable = ['phone', 'email', 'subject'];
}
