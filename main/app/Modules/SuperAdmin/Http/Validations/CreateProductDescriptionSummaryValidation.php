<?php

namespace App\Modules\SuperAdmin\Http\Validations;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use App\Modules\AppUser\Exceptions\AxiosValidationExceptionBuilder;

class CreateProductDescriptionSummaryValidation extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'product_model_id' => $this->isMethod('PUT') ? 'exists:product_models,id' : 'required|unique:product_description_summaries,product_model_id|exists:product_models,id',
      'description_summary' => $this->isMethod('PUT') ? 'required_without:product_model_id|string' : 'required|string',
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
      'product_model_id.unique' => 'This model already has a description. Edit that instead',
      'description_summary.required_without' => 'You must change either the summary or the model',
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
