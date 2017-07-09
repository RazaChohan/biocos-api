<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Models\Token;

class BaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

	public $_tokey_key = 'X-AUTH-TOKEN';
	public $input;
    /**
     * Array to ignore token check from routes
     * @var array
     */
    public $ignoreTokenCheck = [
        'login',
        'register'
    ];
    public $ignoreTokenCheckOnPath = [
    ];

    /***
     * BaseController constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
		$path = $request->path();
		$params = explode('/', $path);
		$action = $params[count($params)-1];
		$token = $this->_getHeaderToken($request);
		if(!in_array($action, $this->ignoreTokenCheck) && !in_array($path, $this->ignoreTokenCheckOnPath)) {
			if ( empty( $token ) ) {
				throw new BadRequestHttpException( 'Not Authorized.' );
			} else if ( !$this->_varifyToken ( $token ) ) {
				throw new BadRequestHttpException( 'Authorization Expired.' );
			} else {
				$this->_increaseLeaseTime ( $token );
				$this->_trackRequest ( $token );
			}
		}

		$this->input = (array)json_decode($request->getContent());

    }

	public function _getHeaderToken($request){
		return $request->header($this->_tokey_key);
	}

	private function _varifyToken($token){
		$status = false;
		$rec = Token::where('token', '=', $token)->where('status', '=', 'active')->first();

		if(!empty($rec->id)){
			$status = true;
		}
		return $status;
	}

	private function _increaseLeaseTime(){

	}

	private function _trackRequest(){

	}

	public function gen_uuid()
	{
		return sprintf ( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			// 32 bits for "time_low"
			mt_rand ( 0, 0xffff ), mt_rand ( 0, 0xffff ),

			// 16 bits for "time_mid"
			mt_rand ( 0, 0xffff ),

			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand ( 0, 0x0fff ) | 0x4000,

			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand ( 0, 0x3fff ) | 0x8000,

			// 48 bits for "node"
			mt_rand ( 0, 0xffff ), mt_rand ( 0, 0xffff ), mt_rand ( 0, 0xffff )
		);
	}

	public function getParam($key){
		return isset($this->input[$key])?$this->input[$key]:NULL;
	}

    /***
     * Get user id from token
     *
     * @param $request
     * @param bool $isWholeUserObjectNeeded
     * @return null
     */
	public function getUserIdFromToken($request, $isWholeUserObjectNeeded=false){
		$data = null;

	    $token = $this->_getHeaderToken($request);
		$token = Token::where('token', '=', $token)->where('status', '=', 'active')->first();

		if($isWholeUserObjectNeeded) {
		    $data = $token->user()->first();
        } else {
            if($token) {
                $data = $token->user_id;
            }
        }

		return $data;
	}

}
