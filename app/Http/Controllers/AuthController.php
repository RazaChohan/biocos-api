<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Token;
use Dingo\Api\Facade\API;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    /***
     * Login User
     *
     * @return mixed
     */
    public function login()
    {
        $username = $this->getParam('username');
        $password = $this->getParam('password');
        if (empty($username) || empty($password)) {
            return API::response()->array(['success' => false, 'message' => 'Required parameters username or password missing!', 'error' => 'Login Failed, Please try again later!'], 400);
        }
        $user = User::with('regions')
                    ->where('username', '=', $username)
                    ->first();
        if (!empty($user)) {
            $flag = (Hash::check($password, $user->password));

            if ($flag) {
                if (!empty($user->tokens) && $user->tokens->count() > 0) {
                    $token = $user->tokens[0]->token;
                } else {
                    $token = $this->gen_uuid();
                    $obj = new Token();

                    $obj->token = $token;
                    $obj->user_id = $user->id;
                    $obj->status = 'active';
                    $obj->issue_date = Carbon::now();
                    $obj->save();

                }
                unset($user->password);
                unset($user->remember_token);
                unset($user->tokens);

                return API::response()->array(['success' => true, 'data' => ['token' => $token, 'user' => $user]], 200);

            }
            return API::response()->array(['success' => false, 'message' => 'Invalid Credentials', 'error' => 'Login Failed, Please try again later!'], 400);
        } else {
            return API::response()->array(['success' => false, 'message' => 'User Not Registered', 'error' => 'Login Failed, Please try again later!'], 400);
        }
    }
    /**
     * Register a User
     *
     */
    public function register(Request $request){

        $validator = \Validator::make($this->input, User::validationRules());

        if ($validator->fails()) {
            return API::response()->array(['success' => false,'error' => 'Required parameters are missing or incorrect!','message' => $validator->errors()->first()], 400);
        }else{
            $user = new User();
            $result = $user->registerUser($this->input);

            if($result){
                $token = $this->gen_uuid ();
                $obj = new Token();

                $obj->token = $token;
                $obj->user_id = $result->id;
                $obj->status = 'active';
                $obj->issue_date = Carbon::now ();
                $obj->save ();
                unset( $user->password );
                unset( $user->remember_token );
                unset( $user->tokens );

                $returnUser = User::where('id', $user->id)->first(['id','username','firstname',
                                                                    'lastname', 'email',
                                                                   'profile_image', 'reset_token']);

                return API::response ()->array ( [ 'success' => true, 'data' => [ 'token' => $token, 'user' => $returnUser ] ], 200 );
            }else{
                return API::response()->array(['success' => false,'message' => 'User registration failed!','error' => ['1010' => 'User registration failed!']], 400);
            }
        }
    }
}