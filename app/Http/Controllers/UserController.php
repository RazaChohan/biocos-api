<?php

namespace App\Http\Controllers;

use Dingo\Api\Facade\API;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use App\Models\Product;
use App\Models\User;


class UserController extends BaseController
{
    /***
     * @var User
     */
    private $_userModel;

    /***
     * Constructor
     *
     * @param $request
     * @param User $userModel
     */
    public function __construct(Request $request, User $userModel)
    {
        parent::__construct($request);
        $this->_userModel = $userModel;
    }
    public function userInfo($userId = 0, Request $request)
    {
        try {
            if($userId == 0) {
                $userId = $this->getUserIdFromToken($request);
            }
            $userInfo = $this->_userModel->getUserInfoWithRegions(['id' => $userId ]);
        }
        catch(Exception $e)
        {
            return API::response()->array(['success' => false, 'message' => 'Exception',
                'message' => $e->getTraceAsString()], 400);
        }
        return API::response()->array(['success' => true, 'message' => is_null($userInfo) ? 'User not found' : 'User found',
            'data' => $userInfo], 200);
    }
}