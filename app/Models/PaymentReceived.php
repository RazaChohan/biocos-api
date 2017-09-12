<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class PaymentReceived extends Model
{
    /**
     * The table name
     *
     * @var string
     */
    protected $table = 'payment_received';
    /***
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $guarded = ['id'];
    /***
     * Timestamp false
     *
     * @var bool
     */
    public $timestamps = false;

    /***
     * Validation Rules
     *
     * @param null $attributes
     * @return array
     */
    public function validationRules($attributes = null)
    {
        $rules = [
            'uuid'            => 'required',
            'customer_id'     => 'required',
            'payment_type'    => ['required', Rule::in(['Promise','Cheque','Cash']) ],
            'amount'          => 'required',
            'cheque_type'     => [Rule::in(['Bearer Cheque','Order Cheque','Crossed Cheque',
                                            'Account Payee Cheque','Company Crossed Cheque',
                                            'Stale Cheque','Post Dated Cheque','Anti Dated Cheque' ])]
        ];

        // no list is provided
        if(!$attributes)
            return $rules;

        // a single attribute is provided
        if(!is_array($attributes))
            return [ $attributes => $rules[$attributes] ];

        // a list of attributes is provided
        $newRules = [];
        foreach ( $attributes as $attr )
            $newRules[$attr] = $rules[$attr];
        return $newRules;
    }

    /***
     * Add or Update Payment Received
     *
     * @param $paymentReceived
     * @return Model|null|static
     */
    public function addOrUpdatePaymentReceived($paymentReceived)
    {
        $paymentReceivedObj = new $this();
        if(IsNullOrEmptyString($paymentReceived['uuid'])) {
            $paymentReceivedObj = $this->where('uuid', $paymentReceived['uuid'])
                                       ->first();
            //Payment Received not found
            if(is_null($paymentReceivedObj)) {
                $paymentReceivedObj = new   $this();
                $paymentReceivedObj->user_id     = $paymentReceived['user_id'];
            }
        } else {
            $paymentReceivedObj->user_id     = $paymentReceived['user_id'];
        }
        $paymentReceivedObj->uuid           = $paymentReceived['uuid'];
        $paymentReceivedObj->customer_id    = $paymentReceived['customer_id'];
        $paymentReceivedObj->payment_type   = $paymentReceived['payment_type'];
        $paymentReceivedObj->amount         = $paymentReceived['amount'];
        //Remarks on payment received
        if(array_key_exists('remarks', $paymentReceived)) {
            $paymentReceivedObj->remarks = $paymentReceived['remarks'];
        }
        // Promise Cheque Date
        if(array_key_exists('promise_cheque_date', $paymentReceived)) {
            $paymentReceivedObj->promise_cheque_date = $paymentReceived['promise_cheque_date'];
        }
        // Cheque Type
        if(array_key_exists('cheque_type', $paymentReceived)) {
            $paymentReceivedObj->cheque_type = $paymentReceived['cheque_type'];
        }
        // Cheque Number
        if(array_key_exists('cheque_no', $paymentReceived)) {
            $paymentReceivedObj->cheque_no = $paymentReceived['cheque_no'];
        }
        // IS Success
        if(array_key_exists('is_success', $paymentReceived)) {
            $paymentReceivedObj->is_success = $paymentReceived['is_success'];
        }
        $paymentReceivedObj->save();
        //Image upload
        if(array_key_exists('images', $paymentReceived)) {
            $images = [];
            foreach($paymentReceived['images'] as $image) {
                $image = upload_base64_image($image, 'uploads/payment/',
                    'paymentimage-');
                $paymentImage = new PaymentImage();
                $paymentImage->image = $image;
                $images[] = $paymentImage;
            }
            if(count($images) > 0) {
                $paymentReceivedObj->images()->saveMany($images);
            }
        }
        //Remove Image
        if(array_key_exists('remove_images', $paymentReceived)) {
            $paymentReceivedObj->images()->whereIn('image', $paymentReceived['remove_images'])
                ->delete();
            foreach($paymentReceived['remove_images'] as $image) {
                $fileToUnlink = public_path() . '/uploads/payment/' .
                    get_filename_url($image);
                if (file_exists($fileToUnlink)) {
                    unlink($fileToUnlink);
                }
            }
        }

        return $this->getPaymentReceivedDetails($paymentReceivedObj->id);
    }

    /***
     * Get Payment Received Details
     *
     * @param $id
     * @return mixed
     */
    public function getPaymentReceivedDetails($id)
    {
        return $this->with('images')
                    ->where('id', $id)
                    ->first();
    }

    /***
     * Get Total amount paid by customer
     * @param $customerId
     * @return mixed
     */
    public function getTotalPaidAmountByCustomer($customerId)
    {
        return $this->where('customer_id', $customerId)
                    ->where('is_success', true)
                    ->sum('amount');
    }
    /***
     * Images of customer/shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany('App\Models\PaymentImage', 'payment_id');
    }

    /***
     * Get payment received records
     *
     * @param $userId
     * @param int $customerId
     * @param bool $avoidPagination
     * @param int $page
     * @return mixed
     */
    public function getPaymentReceived($userId, $customerId = 0, $page = 1, $avoidPagination)
    {
        $model = $this->where('user_id', $userId);
        if($customerId > 0) {
            $model->where('customer_id', $customerId);
        }
        if($page > 0 && !$avoidPagination) {
            $offset = calculate_offset($page);
            $model->skip($offset)
                ->take(10);
        }
        return $model->get();
    }
}