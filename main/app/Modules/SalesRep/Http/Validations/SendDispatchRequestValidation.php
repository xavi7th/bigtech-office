<?php

namespace App\Modules\SalesRep\Http\Validations;

use Illuminate\Validation\Rule;
use App\Modules\Admin\Models\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use App\Modules\PublicPages\Exceptions\AxiosValidationExceptionBuilder;
use App\Modules\SalesRep\Models\ProductDispatchRequest;

class SendDispatchRequestValidation extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'product_description' => 'required|string|max:500',
      'proposed_selling_price' => 'required|numeric',
      'customer_first_name' => 'required|string|max:30',
      'customer_last_name' => 'nullable|string|max:30',
      'customer_phone' => 'required|regex:/^[\+]?[0-9\Q()\E\s-]+$/i',
      'customer_email' => 'required|email',
      'customer_address' => 'required|string|max:100',
      'customer_city' => 'required|string|max:16',
      'sales_channel_id' => 'required|exists:sales_channels,id',
      'customer_ig_handle' => 'nullable|string|max:50',
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
      'sales_channel_id.required' => 'Tell us where the customer started this sale from',
      'sales_channel_id.exists' => 'Invalid sales channel selected',
      'proposed_selling_price.required' => 'The amount concluded with the customer for this transaction is required',
      'proposed_selling_price.numeric' => 'The amount concluded with the customer must be a valid number',
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
      if (ProductDispatchRequest::alreadyExists($this->customer_first_name, $this->customer_last_name, $this->customer_phone, now())) {
        $validator->errors()->add('Duplicate transaction', 'There is a delivery request made for this customer today already. Kindly contact the dispatch unit to confirm');
        return;
      }
    });
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
    throw new AuthorizationException('Only Sales Reps are allowed to schedule a product for delivery');
  }
}
