<?php

namespace App\Modules\SuperAdmin\Http\Validations;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;


class UpdateAppUserDetailsValidation extends FormRequest
{

  public function rules()
  {
    return [
      'email' => 'required|email|max:50|unique:app_users,email,' . $this->appUser->email . ',email',
      'first_name' => 'required|string|max:50',
      'last_name' => 'nullable|string|max:50',
      // 'password' => 'string|min:8',
      // 'bvn' => 'numeric|digits_between:11,16',
      // 'school' => 'string|max:50',
      // 'department' => 'string|max:50',
      // 'level' => 'numeric|digits_between:1,10',
      // 'mat_no' => [
      //   'string',
      //   'max:20',
      //   Rule::unique('app_users')->ignore(auth()->user()),
      // ],
      // 'phone' => [
      //   'regex:/^[\+]?[0-9\Q()\E\s-]+$/i',
      //   Rule::unique('app_users')->ignore(auth()->user()),
      // ],
    ];
  }

  public function authorize()
  {
    return $this->user()->isSuperAdmin();
  }
}
