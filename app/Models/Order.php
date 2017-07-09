<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Order extends Model
{
    use SoftDeletes;
    /***
     * Table name
     *
     * @var string
     */
    protected $table = 'orders';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    /***
     * Validation rules for add user
     *
     * @param null $attributes
     * @return array
     */
    public static function validationRules( $attributes = null ){

        $rules = [
            'customer_id'  => 'required|integer',
            'status'          => [ 'required', Rule::in(['booked','confirmed','processed','ready','delivered','cleared']) ],
            'date_to_deliver' => 'required|date',
            'price'           => 'required|numeric',
            'discount'        => 'numeric',
            'products'        => 'required',
            'type'            => [ 'required', Rule::in([ 'query','order' ]) ]
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
     * Add or Update Order
     *
     * @param $order
     * @param int $orderId
     *
     * @return mixed
     */
    public function addOrUpdateOrder($order, $orderId = 0)
    {
        $orderObj = new $this();
        if($orderId > 0) {
            $orderObj = $this->with('products')
                             ->where('id', $orderId)
                             ->first();
            //Order not found
            if(is_null($orderObj)) {
                return $orderObj;
            }
            $orderObj->updated_by = $order['user_id'];
        } else {
            $orderObj->booked_by  = $order['user_id'];
            $orderObj->created_by = $order['user_id'];
            $orderObj->agency_id  = $order['agency_id'];
        }
        $orderObj->customer_id     = $order['customer_id'];
        $orderObj->status          = $order['status'];
        $orderObj->date_to_deliver = $order['date_to_deliver'];
        $orderObj->price           = $order['price'];
        if(array_key_exists('discount', $order)) {
            $orderObj->discount = $order['discount'];
        }
        $orderObj->type         = $order['type'];
        $orderObj->save();
        if(array_key_exists('products', $order)) {
            $products = [];
            foreach($order['products'] as $product) {
                $products [$product['product_id']] = ['quantity' => $product['quantity']];
            }
          $orderObj->products()->sync($products);
        }
        $orderObj->save();
        return $this->getOrderDetails($orderObj->id);
    }

    /***
     * Relationship with products
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'order_products',
                                    'order_id', 'product_id')
                    ->withPivot('quantity');
    }

    /***
     * Get Order Details
     *
     * @param $id
     * @return Model|null|static
     */
    public function getOrderDetails($id)
    {
        return $this->with('products')
                    ->where('id', $id)
                    ->first();
    }
}