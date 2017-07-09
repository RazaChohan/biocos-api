<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Customer extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'shops';

    protected $guarded = ['id'];

    /***
     * Images of customer/shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany('App\Models\CustomerImage', 'shop_id');
    }
    /***
     * Get customers based on filters
     *
     * @param $userId
     * @param $regionId
     * @param $subRegion
     * @return mixed
     */
    public function getCustomers($userId, $regionId, $subRegion)
    {
        $regionIds = [];
        $regionModel = new Region();
        if(IsNullOrEmptyString($regionId)) {
            $regionIds = $regionModel->getUserRegionIds($userId);
        } else {
            $regionIds [] = $regionId;
        }
        if($subRegion == 'true') {
            $regionIds = array_merge($regionIds, $regionModel->getSubRegions($regionIds, true));
        }
        $shops = $this->with('images')
                      ->whereIn('region_id', $regionIds)
                      ->get();
        return $shops;
    }

    /***
     * Validation Rules
     *
     * @param null $attributes
     * @return array
     */
    public function validationRules( $attributes = null )
    {
        $rules = [
            'name'            => 'required',
            'location'        => 'required',
            'phone_1'         => 'required',
            'latitude'        => 'required|numeric',
            'longitude'       => 'required|numeric',
            'email'           => 'email',
            'type'            => ['required', Rule::in(['wholesaler','Retail Saler'])],
            'industry'        => ['required', Rule::in(['Super store','General store','Cosmetic Shops','Mobiler'])],
            'discount_percentage' => ['required', Rule::in(['wholesaler','retail saler'])],
            'status'          => ['required', Rule::in(['approved','pending','rejected'])],
            'category'        => ['required', Rule::in(['A+','A','B','C','D'])],
            'biocos_ratting'  => 'numeric',
            'region_id'       => 'numeric'
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
     * Add or update Customer
     *
     * @param $customer
     * @param int $customerId
     * @return mixed
     */
    public function addOrUpdateCustomer($customer, $customerId = 0)
    {
        $customerObj = new $this();
        if($customerId > 0) {
            $customerObj = $this->where('id', $customerId)
                                ->first();
            //Customer not found
            if(is_null($customerObj)) {
                return $customerObj;
            }
            $customerObj->updated_by = $customer['user_id'];
        } else {
            $customerObj->created_by = $customer['user_id'];
            $customerObj->agency_id  = $customer['agency_id'];
        }
        $customerObj->name         = $customer['name'];
        $customerObj->status       = $customer['status'];
        $customerObj->location     = $customer['location'];
        $customerObj->latitude     = $customer['latitude'];
        $customerObj->longitude    = $customer['longitude'];
        $customerObj->phone_1      = $customer['phone_1'];
        $customerObj->type         = $customer['type'];
        $customerObj->industry     = $customer['industry'];
        $customerObj->status       = $customer['status'];
        $customerObj->Category     = $customer['category'];
        $customerObj->discount_percentage = $customer['discount_percentage'];

        //Proprietor ID
        if(array_key_exists('proprietor_id', $customer)) {
            $customerObj->proprietor_id = $customer['proprietor_id'];
        }
        //Contact Person ID
        if(array_key_exists('contact_person_id', $customer)) {
            $customerObj->contact_person_id = $customer['contact_person_id'];
        }
        //Phone 2
        if(array_key_exists('phone_2', $customer)) {
            $customerObj->phone_2 = $customer['phone_2'];
        }
        //Email
        if(array_key_exists('email', $customer)) {
            $customerObj->email = $customer['email'];
        }
        //Biocos Rating
        if(array_key_exists('biocos_ratting', $customer)) {
            $customerObj->biocos_ratting = $customer['biocos_ratting'];
        }
        //Region ID
        if(array_key_exists('region_id', $customer)) {
            $customerObj->region_id = $customer['region_id'];
        }
        $customerObj->save();
        return $this->getCustomerDetail($customerObj->id);
    }

    /***
     * Get Customer Detail
     *
     * @param $id
     * @return mixed
     */
    public function getCustomerDetail($id)
    {
        $customer = $this->where('id', $id)
                         ->first();
        return $customer;
    }
}