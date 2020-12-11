<?php

namespace App\Modules\SuperAdmin\Http\Validations;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use App\Modules\PublicPages\Exceptions\AxiosValidationExceptionBuilder;
use App\Modules\SuperAdmin\Models\SwapDeal;

class CreateSwapDealValidation extends FormRequest
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
        'description' => 'nullable|string',
        'selling_price' => 'nullable|numeric',
        'comment' => 'required|string',
      ];
    } else {
      return [
        'app_user_id' => 'nullable|exists:app_users,id',
        'description' => 'required|string',
        'owner_details' => 'required|string',
        'id_card' => 'bail|required|file|image',
        'receipt' => 'bail|required|file|image',
        'imei' => 'required_without_all:model_no,serial_no|alpha_num|unique:swap_deals,imei',
        'serial_no' =>  'required_without_all:imei,model_no|alpha_dash|unique:swap_deals,serial_no',
        'model_no' =>  'required_without_all:imei,serial_no|alpha_dash|unique:swap_deals,model_no',
        'swap_value' => 'required|numeric',
        'selling_price' => 'nullable|numeric',
        'sold_at' => 'nullable|date',
        'swapped_with' => 'nullable|exists:products,id',
    ];
    }
  }

  public function authorize()
  {
    return true;
  }

  public function messages()
  {
    return [
      'imei.required_without_all' => 'A product must have either an IMEI, a Serial Number or a Model Number',
      'serial_no.required_without_all' => 'A product must have either an IMEI, a Serial Number or a Model Number',
      'model_no.required_without_all' => 'A product must have either an IMEI, a Serial Number or a Model Number',
      'comment.required' => 'A comment detailing why this update is necessary is required'
    ];
  }

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
