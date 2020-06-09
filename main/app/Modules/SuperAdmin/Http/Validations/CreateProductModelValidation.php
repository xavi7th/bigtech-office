<?php

namespace App\Modules\SuperAdmin\Http\Validations;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use App\Modules\AppUser\Exceptions\AxiosValidationExceptionBuilder;

class CreateProductModelValidation extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'product_brand_id' => $this->isMethod('PUT') ?  'exists:product_brands,id' : 'required|exists:product_brands,id',
      'name' => $this->isMethod('PUT') ? ['filled',  Rule::unique('product_models')->ignore($this->route('model')->name)] : 'required|unique:product_models,name',
      'product_category_id' => $this->isMethod('PUT') ?  'exists:product_categories,id' : 'required|exists:product_categories,id',
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
    return true;
  }

  /**
   * Configure the error messages for the defined validation rules.
   *
   * @return array
   */
  public function messages()
  {
    return [
      'name.unique' => 'A product model with that name already exists'
    ];
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
