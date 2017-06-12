<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'user_tokens';

    protected $fillable = [
        'token', 'user_id', 'expiry', 'issue_date', 'device', 'status'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function getActiveTokenForUser($userId = NULL){
        $result = array();
        if(!empty($userId)){
            $result = $this->where('user_id', '=', $userId)->where('status', '=', 'active')->orderBy('created_at', 'desc')->first();
        }

        return $result;
    }

    public function getUserFromToken( $token = NULL ){
        $result = array();
        if(!empty($token)){
            $rec = $this->where('token', '=', $token)->where('status', '=', 'active')->orderBy('created_at', 'desc')->first();
            if($rec->count() > 0){
                $result = $rec->user;
            }
        }

        return $result;
    }

}
