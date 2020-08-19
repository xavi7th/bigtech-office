<?php

namespace App\Modules\SuperAdmin\Http\Validations;

use Illuminate\Validation\Rule;
use App\Modules\Admin\Models\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use App\Modules\PublicPages\Exceptions\AxiosValidationExceptionBuilder;

class MarkProductAsSoldValidation extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'selling_price' => 'required|numeric',
      'first_name' => 'required|string',
      'last_name' => 'nullable|string',
      'phone' => 'required|regex:/^[\+]?[0-9\Q()\E\s-]+$/i|unique:app_users,phone',
      'email' => 'required|email',
      'address' => 'required|string',
      'city' => 'required|string',
      'sales_channel_id' => 'required|exists:sales_channels,id',
      'ig_handle' => 'nullable|string',
      'online_rep_id' => 'nullable|exists:sales_reps,id',
      'is_swap_deal' => 'nullable',
      'description' => 'required_if:is_swap_deal,true|string',
      'owner_details' => 'required_if:is_swap_deal,true|string',
      'id_card' => 'required_if:is_swap_deal,true|file|mimes:jpeg,bmp,png',
      'receipt' => 'required_if:is_swap_deal,true|file|mimes:jpeg,bmp,png',
      'swap_value' => 'required_if:is_swap_deal,true|numeric',
      'imei' => 'nullable|alpha_num|unique:swap_deals,imei',
      'serial_no' =>  'nullable|alpha_dash|unique:swap_deals,serial_no',
      'model_no' =>  'nullable|alpha_dash|unique:swap_deals,model_no'
    ];
  }

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    /**
     * Only sales reps can mark products as sold
     */
    return auth()->check();
  }



  /**
   * Configure the error messages for the defined validation rules.
   *
   * @return array
   */
  public function messages()
  {
    return [
      'sales_channel_id.required' => 'Tell us where the customer started this sale from',
      'sales_channel_id.exists' => 'Invalid sales channel selected',
      'online_rep_id.exists' => 'Invalid sales rep selected',
      'required_if' => 'The :attribute is required if it is a swap deal'
    ];
  }

  /**
   * Configure the validator instance.
   *
   * @param  \Illuminate\Validation\Validator  $validator
   * @return void
   */
  public function withValidator($validator)
  {
    $validator->after(function ($validator) {

      /**
       * Check if the product has been sold already or confirmed
       */
      if ($this->route('product')->is_sold()) {
        $validator->errors()->add('Invalid transaction', 'This product has been sold already');
        return;
      }

      /**
       * Check if the product has been QA tested and put in tock
       */
      if (!$this->route('product')->in_stock()) {
        $validator->errors()->add('Invalid transaction', 'This product has not being tested');
        return;
      }

      /**
       * Check if the is_swap_deal field is a boolean
       */
      if ($this->is_swap_deal && !is_bool(filter_var($this->is_swap_deal, FILTER_VALIDATE_BOOLEAN))) {
        $validator->errors()->add('Err', 'The is swap deal field must be a boolean');
        return;
      }



      if (filter_var($this->is_swap_deal, FILTER_VALIDATE_BOOLEAN) && (!$this->imei && !$this->serial_no && !$this->model_no)) {
        $validator->errors()->add('Err', 'The imei or serial no or model no field is required when it is a swap deal');
        return;
      }
    });
  }


  public function validated()
  {
    /**
     * Remove the img key from the validated options so that it does not cause errors with the edit route
     */

    return array_merge(collect(parent::validated())->all(), [
      'swapped_with' => $this->route('product')->id
    ]);
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
