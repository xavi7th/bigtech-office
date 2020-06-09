<?php

namespace App\Modules\SuperAdmin\Http\Validations;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use App\Modules\AppUser\Exceptions\AxiosValidationExceptionBuilder;

class CreateBankAccountValidation extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'bank' => $this->isMethod('PUT') ?  'string' : 'required|string',
      'account_name' => $this->isMethod('PUT') ?  'string' : 'required|string',
      'account_number' => $this->isMethod('PUT') ?  Rule::unique('company_bank_accounts')->ignore($this->route('company_bank_account')->account_number) : 'required|unique:company_bank_accounts,account_number',
      'account_type' => $this->isMethod('PUT') ? 'string' : 'required|string',
      'account_description' => 'nullable|string',
      'img_url' => 'bail|nullable|file|mimes:jpeg,bmp,png',
    ];
  }

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return auth('admin_api')->check();
  }

  /**
   * Overwrite the validator response so we can customise it per the structure requested from the fronend
   *
   * @param \Illuminate\Contracts\Validation\Validator $validator
   * @return void
   */
  protected function failedValidation(Validator $validator)
  {
    /**
     * * And handle there. That will help for reuse. Handling here for compactness purposes
     * ? Who knows they might ask for a different format for the enxt validation
     */
    throw new AxiosValidationExceptionBuilder($validator);
  }

  protected function failedAuthorization()
  {
    // throw new AuthorizationException('You are yet to get a credit card. Order one first');
  }
}
