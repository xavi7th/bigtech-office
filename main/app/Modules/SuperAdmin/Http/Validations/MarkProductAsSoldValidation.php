<?php

namespace App\Modules\SuperAdmin\Http\Validations;

use Illuminate\Validation\Rule;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\Admin\Models\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use App\Modules\PublicPages\Exceptions\AxiosValidationExceptionBuilder;

class MarkProductAsSoldValidation extends FormRequest
{
  /**
   * The product to mark as sold
   *
   * @var Product
   */
  private $product;
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
      'phone' => 'required|regex:/^[\+]?[0-9\Q()\E\s-]+$/i',
      'email' => 'required|email',
      'address' => 'required|string',
      'city' => 'required|string',
      'sales_channel_id' => 'required|exists:sales_channels,id',
      'ig_handle' => 'nullable|string',
      'online_rep_id' => 'nullable|exists:sales_reps,id',
      'is_swap_transaction' => 'nullable',
      'description' => 'required_if:is_swap_transaction,true|nullable|string',
      'owner_details' => 'required_if:is_swap_transaction,true|nullable|string',
      'id_card' => 'required_if:is_swap_transaction,true|nullable|image|mimes:jpeg,png,jpg,gif,svg',
      'receipt' => 'required_if:is_swap_transaction,true|nullable|image|mimes:jpeg,png,jpg,gif,svg',
      'swap_value' => 'required_if:is_swap_transaction,true|nullable|numeric',
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
    $this->product = $this->route('product') ?? $this->route('swapDeal');
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
      // dd($this->product->is_sold());

      /**
       * Check if the product has been sold already or confirmed
       */
      if ($this->product->is_sold()) {
        $validator->errors()->add('Invalid transaction', 'This product has been sold already');
        return;
      }

      /**
       * Check if the product has been QA tested and put in tock
       */
      if (!($this->product->in_stock() || $this->product->out_for_delivery())) {
        $validator->errors()->add('Invalid transaction', 'This product has not being tested');
        return;
      }

      /**
       * Check if the is_swap_transaction field is a boolean
       */
      if ($this->is_swap_transaction && !is_bool(filter_var($this->is_swap_transaction, FILTER_VALIDATE_BOOLEAN))) {
        $validator->errors()->add('Err', 'The is swap deal field must be a boolean');
        return;
      }



      if (filter_var($this->is_swap_transaction, FILTER_VALIDATE_BOOLEAN) && (!$this->imei && !$this->serial_no && !$this->model_no)) {
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
      'swapped_with_id' => $this->product->id,
      'swapped_with_type' => get_class($this->product),
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
