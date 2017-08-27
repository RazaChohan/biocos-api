<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use PhpParser\Builder;

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
     * Images of customer/shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany('App\Models\OrderImage', 'order_id');
    }
    /***
     * Validation rules for add user
     *
     * @param null $attributes
     * @return array
     */
    public function validationRules( $attributes = null )
    {
        $rules = [
            'uuid'            => 'required',
            'customer_id'     => 'integer',
            'status'          => [ 'required', Rule::in(['Booked','Confirmed','Processed','Ready',
                                                         'Delivered','Cleared']) ],
            'date_to_deliver' => 'required|date',
            'price'           => 'required|numeric',
            'discount'        => 'numeric',
            'products'        => 'required',
            'remarks'         => 'required',
            'type'            => [ 'required', Rule::in([ 'Query','Order' ]) ]
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
        //Contact Person ID
        if(array_key_exists('customer_id', $order)) {
            $orderObj->customer_id = $order['customer_id'];
        }
        elseif(array_key_exists('customer', $order)) {
            $customerModel = new Customer();
            $customerId = $customerModel->getCustomerId($order['customer']);
            $order['customer']['user_id'] = $order['user_id'];
            $order['customer_id'] = $customerModel->addOrUpdateCustomer($order['customer'],
                                                                         $customerId);
        }
        $orderObj->customer_id     = $order['customer_id'];
        $orderObj->status          = $order['status'];
        $orderObj->date_to_deliver = $order['date_to_deliver'];
        $orderObj->price           = $order['price'];
        $orderObj->remarks         = $order['remarks'];
        $orderObj->uuid            = $order['uuid'];

        if(array_key_exists('payment', $order)) {
            $orderObj->payment = $order['payment'];
        }

        if(array_key_exists('delivery_time', $order)) {
            $orderObj->delivery_time = $order['delivery_time'];
        }

        if(array_key_exists('remarks', $order)) {
            $orderObj->remarks = $order['remarks'];
        }

        if(array_key_exists('latitude', $order)) {
            $orderObj->latitude = $order['latitude'];
        }

        if(array_key_exists('longitude', $order)) {
            $orderObj->longitude = $order['longitude'];
        }

        if(array_key_exists('discount', $order)) {
            $orderObj->discount = $order['discount'];
        }
        $orderObj->type       = $order['type'];
        $orderObj->save();

        //Image upload
        if(array_key_exists('images', $order)) {
            $images = [];
            foreach($order['images'] as $image) {
                $image = upload_base64_image($image, 'uploads/order/',
                    'orderimage-');
                $orderImage = new OrderImage();
                $orderImage->image = $image;
                $images[] = $orderImage;
            }
            if(count($images) > 0) {
                $orderObj->images()->saveMany($images);
            }
        }
        //Remove Image
        if(array_key_exists('remove_images', $order)) {
            $orderObj->images()->whereIn('image', $order['remove_images'])
                ->delete();
            foreach($order['remove_images'] as $image) {
                $fileToUnlink = public_path() . '/uploads/order/' .
                    get_filename_url($image);
                if (file_exists($fileToUnlink)) {
                    unlink($fileToUnlink);
                }
            }
        }

        if(array_key_exists('products', $order)) {
            $products = [];
            foreach($order['products'] as $product) {
                $products [$product['product_id']] = ['quantity' => $product['quantity']];
            }
          $orderObj->products()->sync($products);
        }
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
     * Customer Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    /***
     * Get Order Details
     *
     * @param $id
     * @return \Illuminate\Database\Query\Builder
     */
    public function getOrderDetails($id)
    {
        return $this->with(['products' => function($query) {
                                    $query->with('images');
                        }, 'images','customer' => function($query){
                                    $query->with('images', 'contactPerson', 'proprietor');
        }])->where('id', $id)
           ->first();
    }

    /***
     * Order list
     * @param $userId
     * @param $avoidPagination
     * @param int $page
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getOrders($userId, $avoidPagination, $page = 1)
    {
        $query = $this->with(['images','products' => function($query) {
                            $query->with('images');
        },      'customer' => function($query){
                        $query->with('images', 'contactPerson', 'proprietor');
        }]);
        if($userId > 0) {
            $query->where('booked_by', $userId);
        }
        if($page > 0 && !$avoidPagination) {
            $offset = calculate_offset($page);
            $query->skip($offset)
                  ->take(10);
        }
        return $query->get();
    }
    /***
     * Get Order ID using uuid
     *
     * @param $uuid
     * @return int
     */
    public function getOrderId($uuid)
    {
        $orderRecord =  $this->where('uuid', $uuid)
            ->first();
        return is_null($orderRecord) ? 0 : $orderRecord->id;
    }

    /***
     * Get total orders amount
     *
     * @param $customerId
     * @return mixed
     */
    public function getTotalOrdersAmount($customerId)
    {
        return $this->where('customer_id', $customerId)
                    ->sum('price');
    }
}