<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Hashing\BcryptHasher;
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
        $this->save();
        return $this;
    }
     /***
     * Get email against faceebook id
     *
     * @param Request $request
     * @return mixed
     */
    public function fetchEmail($fbId){
        return $this->where('fb_id','=',$fbId)
                    ->select('email')->first();
    }
    public static function validationRules( $attributes = null ){

        $rules = [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|unique:users,email',
            'password' => 'required',

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

}
