<?php

namespace App\Modules\SuperAdmin\Http\Validations;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use App\Modules\AppUser\Exceptions\AxiosValidationExceptionBuilder;

class CreateLocalSupplierProductValidation extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'processor_speed_id' => $this->isMethod('PUT') ? 'exists:processor_speeds,id' : 'required|exists:processor_speeds,id',
      'product_category_id' => $this->isMethod('PUT') ? 'exists:product_categories,id' : 'required|exists:product_categories,id',
      'product_color_id' => $this->isMethod('PUT') ? 'exists:product_colors,id' : 'required|exists:product_colors,id',
      'storage_type_id' => $this->isMethod('PUT') ? 'exists:storage_types,id' : 'required_with:serial_no|exists:storage_types,id',
      'storage_size_id' => $this->isMethod('PUT') ? 'exists:storage_sizes,id' : 'required_with:imei,model_no|exists:storage_sizes,id',
      'ram_size_id' => $this->isMethod('PUT') ? 'exists:storage_sizes,id' : 'nullable|exists:storage_sizes,id',
      'product_grade_id' => $this->isMethod('PUT') ? 'exists:product_grades,id' : 'required|exists:product_grades,id',
      'product_supplier_id' => $this->isMethod('PUT') ? 'exists:product_suppliers,id' : 'required|exists:product_suppliers,id',
      'product_brand_id' => $this->isMethod('PUT') ? 'exists:product_brands,id' : 'required|exists:product_brands,id',
      'product_model_id' => $this->isMethod('PUT') ? 'exists:product_models,id' : 'required|exists:product_models,id',
      'imei' => $this->isMethod('PUT') ? ['alpha_num',  Rule::unique('products')->ignore($this->route('product')->imei)] : 'required_without_all:model_no,serial_no|alpha_num|unique:products,imei',
      'serial_no' => $this->isMethod('PUT') ? ['alpha_dash',  Rule::unique('products')->ignore($this->route('product')->serial_no)] : 'required_without_all:imei,model_no|alpha_dash|unique:products,serial_no',
      'model_no' => $this->isMethod('PUT') ? ['alpha_dash',  Rule::unique('products')->ignore($this->route('product')->model_no)] : 'required_without_all:imei,serial_no|alpha_dash|unique:products,model_no',
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
      'imei.required_without_all' => 'A product must have either an IMEI, a Serial Number or a Model Number',
      'serial_no.required_without_all' => 'A product must have either an IMEI, a Serial Number or a Model Number',
      'model_no.required_without_all' => 'A product must have either an IMEI, a Serial Number or a Model Number',
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
