<?php

namespace App\Modules\SuperAdmin\Http\Validations;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use App\Modules\PublicPages\Exceptions\AxiosValidationExceptionBuilder;

class CreateResellerValidation extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {

    return [
      'business_name' => $this->isMethod("PUT") ? Rule::unique('resellers')->ignore($this->route('reseller')->business_name, 'business_name') : 'required|unique:resellers,business_name',
      'ceo_name' => $this->isMethod("PUT") ? 'string|max:50' : 'required|string|max:50',
      'address' =>  $this->isMethod("PUT") ? 'string'  : 'required|string',
      'img' =>  'nullable|file|image',
      'phone' =>  $this->isMethod("PUT") ? 'regex:/^[\+]?[0-9\Q()\E\s-]+$/i' : 'required|regex:/^[\+]?[0-9\Q()\E\s-]+$/i',
    ];
  }

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  public function validated()
  {
    /**
     * Remove the img key from the validated options so that it does not cause errors with the edit route
     */
    if ($this->img) {
      return array_merge((collect(parent::validated())->except('img'))->all(), [
        'img_url' => $this->img
      ]);
    } else {
      return parent::validated();
    }
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
    throw new AuthorizationException('You are yet to get a credit card. Order one first');
  }
}
