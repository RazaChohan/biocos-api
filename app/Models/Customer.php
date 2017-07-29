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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proprietor()
    {
        return $this->belongsTo('App\Models\User', 'proprietor_id');
    }

    /***
     * Contact Person Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contactPerson()
    {
        return $this->belongsTo('App\Models\User', 'contact_person_id');
    }
    /***
     * Get customers based on filters
     *
     * @param $userId
     * @param $regionId
     * @param $subRegion
     * @param $page
     * @return mixed
     */
    public function getCustomers($userId, $regionId, $subRegion, $page = 1)
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
        $query = $this->with('images', 'proprietor', 'contactPerson')
                      ->whereIn('region_id', $regionIds);
        if($page > 0){
            $offset = calculate_offset($page);
            $query->skip($offset)
                ->take(10);
        }
        $shops = $query->get();
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
            'customer_type'   => ['required', Rule::in(['Wholesaler','Retail Saler','Distributer'])],
            'shop_type'       => ['required', Rule::in(['Parlor','Doctor','Medical Store','Pan Shop','Super Store',
                                                        'General Store','Cosmetics Shop',
                                                        'Tuk Shop at Fuel Station','Mobiler','Homeopathic Store',
                                                        'Pansar Store','Super Market'])],
            'discount_percentage' => ['required', Rule::in(['Wholesaler','Retail Saler', 'Distributer'])],
            'status'          => ['required', Rule::in(['Approved','Pending','Rejected'])],
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
     * @param bool $returnObj
     * @return mixed
     */
    public function addOrUpdateCustomer($customer, $customerId = 0, $returnObj = false)
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
        $customerObj->customer_type= $customer['customer_type'];
        $customerObj->shop_type    = $customer['shop_type'];
        $customerObj->status       = $customer['status'];
        $customerObj->Category     = $customer['category'];
        $customerObj->discount_percentage = $customer['discount_percentage'];
        //Proprietor ID
        if(array_key_exists('proprietor_id', $customer)) {
            $customerObj->proprietor_id = $customer['proprietor_id'];
        }
        elseif(array_key_exists('proprietor', $customer)) {
            $userModel = new User();
            $customerObj->proprietor_id = $userModel->createOrUpdateUser($customer['proprietor']);
        }
        //Contact Person ID
        if(array_key_exists('contact_person_id', $customer)) {
            $customerObj->contact_person_id = $customer['contact_person_id'];
        }
        elseif(array_key_exists('contact_person', $customer)) {
            $userModel = new User();
            $customerObj->contact_person_id = $userModel->createOrUpdateUser($customer['contact_person']);
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
        //Image upload
        if(array_key_exists('images', $customer)) {
            $images = [];
            foreach($customer['images'] as $image) {
                $image = upload_base64_image($image, 'uploads/customer/',
                    'customerimage-');
                $customerImage = new CustomerImage();
                $customerImage->image = $image;
                $images[] = $customerImage;
            }
            if(count($images) > 0) {
                $customerObj->images()->saveMany($images);
            }
        }
        //Remove Image
        if(array_key_exists('remove_images', $customer)) {
            $customerObj->images()->whereIn('image', $customer['remove_images'])
                        ->delete();
            foreach($customer['remove_images'] as $image) {
                $fileToUnlink = public_path() . '/uploads/customer/' .
                    get_filename_url($image);
                if (file_exists($fileToUnlink)) {
                    unlink($fileToUnlink);
                }
            }
        }

        return ($returnObj) ? $this->getCustomerDetail($customerObj->id) : $customerObj->id;
    }

    /***
     * Get Customer Detail
     *
     * @param $id
     * @return mixed
     */
    public function getCustomerDetail($id)
    {
        $customer = $this->with('images', 'contactPerson', 'proprietor')
                         ->where('id', $id)
                         ->first();
        return $customer;
    }

    /***
     * Get Customer ID using different params
     *
     * @param $customerArray
     * @return int
     */
    public function getCustomerId($customerArray)
    {
        $customerRecord =  $this->where('name', $customerArray['name'])
                                ->where('location', $customerArray['location'])
                                ->where('customer_type', $customerArray['customer_type'])
                                ->where('shop_type', $customerArray['shop_type'])
                                ->first();
        return is_null($customerRecord) ? 0 : $customerRecord->id;
    }
}