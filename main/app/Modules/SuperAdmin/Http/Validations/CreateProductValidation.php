<?php

namespace App\Modules\SuperAdmin\Http\Validations;

use App\Modules\AppUser\Models\AppUser;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use App\Modules\PublicPages\Exceptions\AxiosValidationExceptionBuilder;

class CreateProductValidation extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   * @method static \Illuminate\Database\Eloquent\Builder|AppUser user()
   */
  public function rules()
  {
    if ($this->isMethod('PUT')) {
      return [
        'processor_speed_id' => 'required|exists:processor_speeds,id',
        'product_batch_id' => 'required|exists:product_batches,id',
        'product_category_id' => 'required|exists:product_categories,id',
        'product_color_id' => 'required|exists:product_colors,id',
        'storage_type_id' => 'required|exists:storage_types,id',
        'storage_size_id' => 'required|exists:storage_sizes,id',
        'ram_size_id' => 'required|exists:storage_sizes,id',
        'product_grade_id' => 'required|exists:product_grades,id',
        'product_supplier_id' => 'required|exists:product_suppliers,id',
        'office_branch_id' => 'required|exists:office_branches,id',
        'product_brand_id' => 'required|exists:product_brands,id',
        'product_model_id' => 'required|exists:product_models,id',
        'imei' => 'required_without_all:serial_no,model_no|nullable|alpha_num|unique:products,imei,' . $this->imei . ',imei',
        'serial_no' => 'required_without_all:imei,model_no|nullable|alpha_num|unique:products,imei,' . $this->serial_no . ',serial_no',
        'model_no' => 'required_without_all:imei,serial_no|nullable|alpha_num|unique:products,imei,' . $this->model_no . ',model_no',
        'skip_qa' => 'boolean'
      ];
    } else {
      return [
        'processor_speed_id' => 'required|exists:processor_speeds,id',
        'product_batch_id' => 'required|exists:product_batches,id',
        'product_category_id' => 'required|exists:product_categories,id',
        'product_color_id' => 'required|exists:product_colors,id',
        'storage_type_id' => 'required_with:serial_no|exists:storage_types,id',
        'storage_size_id' => 'required_with:imei,model_no|exists:storage_sizes,id',
        'ram_size_id' => 'nullable|exists:storage_sizes,id',
        'product_grade_id' => 'required|exists:product_grades,id',
        'product_supplier_id' => 'required|exists:product_suppliers,id',
        'office_branch_id' => 'required|exists:office_branches,id',
        'product_brand_id' => 'required|exists:product_brands,id',
        'product_model_id' => 'required|exists:product_models,id',
        'imei' => 'required_without_all:model_no,serial_no|alpha_num|unique:products,imei',
        'serial_no' => 'required_without_all:imei,model_no|alpha_dash|unique:products,serial_no',
        'model_no' => 'required_without_all:imei,serial_no|alpha_dash|unique:products,model_no',
        'skip_qa' => 'boolean'
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
      'office_branch_id.required' => 'Select the branch where this product is located',
      'office_branch_id.exists' => 'Invalid office branch selected',
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
