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
    return [
      'app_user_id' => 'nullable|exists:app_users,id',
      'description' => $this->isMethod('PUT') ? 'string' : 'required|string',
      'owner_details' => $this->isMethod('PUT') ? 'string' : 'required|string',
      'id_card' => $this->isMethod('PUT') ? 'bail|file|mimes:jpeg,bmp,png' : 'bail|required|file|mimes:jpeg,bmp,png',
      'receipt' => $this->isMethod('PUT') ? 'bail|file|mimes:jpeg,bmp,png' : 'bail|required|file|mimes:jpeg,bmp,png',
      'imei' => $this->isMethod('PUT') ? ['alpha_num',  Rule::unique('swap_deals')->ignore($this->route('swap_deal')->imei)] : 'required_without_all:model_no,serial_no|alpha_num|unique:swap_deals,imei',
      'serial_no' => $this->isMethod('PUT') ? ['alpha_dash',  Rule::unique('swap_deals')->ignore($this->route('swap_deal')->serial_no)] : 'required_without_all:imei,model_no|alpha_dash|unique:swap_deals,serial_no',
      'model_no' => $this->isMethod('PUT') ? ['alpha_dash',  Rule::unique('swap_deals')->ignore($this->route('swap_deal')->model_no)] : 'required_without_all:imei,serial_no|alpha_dash|unique:swap_deals,model_no',
      'swap_value' => $this->isMethod('PUT') ? 'numeric' : 'required|numeric',
      'selling_price' => 'nullable|numeric',
      'sold_at' => 'nullable|date',
      'swapped_with' => 'nullable|exists:products,id',
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
