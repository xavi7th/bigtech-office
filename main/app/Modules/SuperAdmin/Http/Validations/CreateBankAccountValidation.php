<?php

namespace App\Modules\SuperAdmin\Http\Validations;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use App\Modules\PublicPages\Exceptions\AxiosValidationExceptionBuilder;

class CreateBankAccountValidation extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    if ($this->isMethod('PUT')) {
      return [
        'bank' =>   'required|string',
        'account_name' =>  'required|string',
        'account_number' =>  ['required', 'numeric', Rule::unique('company_bank_accounts')->ignore($this->route('companyBankAccount')->account_number, 'account_number')],
        'account_type' => 'string',
        'account_description' => 'nullable|string',
        'img' => 'image|mimes:jpeg,png,jpg,gif,svg',
      ];
    } elseif ($this->isMethod('POST')) {
      return [
        'bank' =>  'required|string',
        'account_name' =>  'required|string',
        'account_number' => 'required|numeric|unique:company_bank_accounts,account_number',
        'account_type' => 'required|string',
        'account_description' => 'nullable|string',
        'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
      ];
    }
  }

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return auth('super_admin')->check();
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
