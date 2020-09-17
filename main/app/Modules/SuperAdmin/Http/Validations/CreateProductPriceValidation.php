<?php

namespace App\Modules\SuperAdmin\Http\Validations;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use App\Modules\PublicPages\Exceptions\AxiosValidationExceptionBuilder;

class CreateProductPriceValidation extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'product_batch_id' => $this->isMethod('PUT') ? 'exists:product_batches,id' : 'required|exists:product_batches,id',
      'product_color_id' => $this->isMethod('PUT') ? 'exists:product_colors,id' : 'required|exists:product_colors,id',
      'storage_size_id' => $this->isMethod('PUT') ? 'exists:storage_sizes,id' : 'required|exists:storage_sizes,id',
      'product_grade_id' => $this->isMethod('PUT') ? 'exists:product_grades,id' : 'required|exists:product_grades,id',
      'product_supplier_id' => $this->isMethod('PUT') ? 'exists:product_suppliers,id' : 'required|exists:product_suppliers,id',
      'product_brand_id' => $this->isMethod('PUT') ? 'exists:product_brands,id' : 'required|exists:product_brands,id',
      'product_model_id' => $this->isMethod('PUT') ? 'exists:product_models,id' : 'required|exists:product_models,id',
      'cost_price' => $this->isMethod('PUT') ? 'numeric' : 'required|numeric',
      'proposed_selling_price' => 'numeric|gte:cost_price'
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
      'proposed_selling_price.gte' => 'The proposed selling price should be greater than or equal to the cost price'
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

}
