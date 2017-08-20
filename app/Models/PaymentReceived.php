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
            'remarks'         => 'required',
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
     * @param $orderId
     * @return Model|null|static
     */
    public function addOrUpdatePaymentReceived($paymentReceived, $orderId)
    {
        $paymentReceivedObj = new $this();
        if($orderId > 0) {
            $paymentReceivedObj = $this->where('order_id', $orderId)
                                       ->first();
            //Payment Received not found
            if(is_null($paymentReceivedObj)) {
                return $paymentReceivedObj;
            }
        } else {
            $paymentReceivedObj->user_id     = $paymentReceived['user_id'];
        }
        $paymentReceivedObj->uuid           = $paymentReceived['uuid'];
        $paymentReceivedObj->customer_id    = $paymentReceived['customer_id'];
        $paymentReceivedObj->order_id       = $paymentReceived['order_id'];
        $paymentReceivedObj->remarks        = $paymentReceived['remarks'];
        $paymentReceivedObj->payment_type   = $paymentReceived['payment_type'];
        $paymentReceivedObj->amount         = $paymentReceived['amount'];
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
        $paymentReceivedObj->save();
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
        return $this->where('id', $id)
                    ->first();
    }
}