<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Support\Facades\Hash;
use DB;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password'
    ];
    /***
     * Hidden attributes of array
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at', 'pivot', 'password'
    ];

    public function registerUser($input)
    {
        $this->firstname = $input['firstname'];
        $this->lastname = $input['lastname'];
        $this->email = $input['email'];
        $this->password = Hash::make($input['password']);
        if(array_key_exists('user_type', $input)) {
            $this->user_type = $input['user_type'];
        }
        $this->username = $input['username'];
        $this->save();
        return $this;
    }
     /***
     * Get email against faceebook id
     *
     * @param $fbId
     * @return mixed
     */
    public function fetchEmail($fbId){
        return $this->where('fb_id','=',$fbId)
                    ->select('email')->first();
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
            'username'  => 'required|unique:users,username',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'user_type' => 'required'

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
     * Validation rules for update profile
     *
     * @param $userId
     * @param null $attributes
     * @return array
     */
    public function validationRulesUpdateProfile($userId, $attributes = null)
    {
        $rules = [
            'username'  => 'unique:users,username,'.$userId,
            'firstname' => 'string|max:255',
            'lastname'  => 'string|max:255',
            'email'     => 'unique:users,email,'.$userId

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
    public function regions() {
        return $this->belongsToMany('App\Models\Region', 'user_regions', 'user_id', 'region_id');
    }

    /***
     * Get agency id of user
     * @param $userId
     * @return integer
     */
    public function getUserAgencyId($userId) {
        $user = $this->where('id', '=', $userId)
                     ->first(['agency_id']);
        return !is_null($user) ? $user->agency_id : 0;
    }

    /***
     * Get User Info With Regions
     *
     * @param $filtersWithValues
     * @return Model|null|static
     */
    public function getUserInfoWithRegions($filtersWithValues)
    {
        $query = $this->with('regions');
        foreach($filtersWithValues as $filter => $value) {
            $query->where($filter, '=', $value);
        }
        return $query->first();
    }
    public function getConstants()
    {
        $constants = [];
        //Jobs Status
        $constants['job_status'] = getEnumValues('jobs', 'status');
        //Jobs Visit Type
        $constants['job_visit_type'] = getEnumValues('jobs', 'visit_type');
        //Order Status
        $constants['order_status'] = getEnumValues('orders', 'status');
        //Order Type
        $constants['order_type'] = getEnumValues('orders', 'type');
        //Product Category
        $constants['product_category'] = getEnumValues('products', 'category');
        //Product Type
        $constants['product_type'] = getEnumValues('products', 'type');
        //Customer Type
        $constants['customer_type'] = getEnumValues('shops', 'customer_type');
        //Shop Type
        $constants['shop_type'] = getEnumValues('shops', 'shop_type');
        //Discount Percentage
        $constants['shop_discount_percentage'] = setDiscountPercentageArrayConstants(
                                    getEnumValues('shops', 'discount_percentage'));
        $constants['grades'] = setGradeArrayConstants(
                                    getEnumValues('shops', 'Category'));
        return $constants;
    }

    /***
     * Update user
     *
     * @param $updateUser
     * @param $userId
     * @return User|Model|null
     */
    public function updateUser($updateUser, $userId)
    {
        $response = null;
        $user = $this->where('id', '=', $userId)->first();
        if(!is_null($user)) {
            if(array_key_exists('username', $updateUser)) {
               $user->username = $updateUser['username'];
            }
            if(array_key_exists('firstname', $updateUser)) {
                $user->firstname = $updateUser['firstname'];
            }
            if(array_key_exists('lastname' , $updateUser)) {
                $user->lastname = $updateUser['lastname'];
            }
            if(array_key_exists('email', $updateUser)) {
                $user->email = $updateUser['email'];
            }
            if(array_key_exists('phone_1', $updateUser)) {
                $user->phone_1 = $updateUser['phone_1'];
            }
            if(array_key_exists('phone_2', $updateUser)) {
                $user->phone_2 = $updateUser['phone_2'];
            }
            if (array_key_exists('photo', $updateUser)) {
                $photo = $updateUser['photo'];
                $imageUpload = upload_base64_image($photo, 'uploads/user/', 'profileimage-');
                if(!IsNullOrEmptyString($user->profile_image)) {
                    $fileToUnlink = public_path() . '/uploads/user/' .
                                get_filename_url($user->profile_image);
                    if (file_exists($fileToUnlink)) {
                        unlink($fileToUnlink);
                    }
                }
                $user->profile_image = $imageUpload;
            }
            $user->save();
            $response = $this->getUserInfoWithRegions(['id' => $userId ]);
        }
        return $response;
    }
}
