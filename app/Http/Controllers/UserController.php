<?php

namespace App\Http\Controllers;

use App\Models\UserLocation;
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

    /***
     * Get user info
     *
     * @param int $userId
     * @param Request $request
     * @return mixed
     */
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
            return API::response()->array(['success' => false,
                                           'message' => $e->getTraceAsString()], 400);
        }
        return API::response()->array(['success' => true,
                                       'message' => is_null($userInfo) ? 'User not found' : 'User found',
                                       'data' => $userInfo], 200);
    }

    /***
     * Update profile
     *
     * @param Request $request
     * @param int $userId
     * @return mixed
     */
    public function updateProfile(Request $request, $userId = 0)
    {
        try {
            $validator = \Validator::make($request->all(), $this->_userModel->validationRulesUpdateProfile($userId));

            if ($validator->fails()) {
                return API::response()->array(['success' => false, 'error' => 'Required parameters are missing or incorrect!',
                    'message' => $validator->errors()], 400);
            } else {
                $user = $request->all();
                $user = $this->_userModel->updateUser($user, $userId);
                if (is_null($user)) {
                    return API::response()->array(['success' => false,
                        'error' => 'User Not Found'], 400);
                }
            }
            return API::response()->array(['success' => true,
                'message' => 'User Updated',
                'data' => $user], 200);
        } catch(Exception $e) {
            return API::response()->array(['success' => false,
                'message' => $e->getTraceAsString()], 400);
        }
    }

    /***
     * Add user locations
     *
     * @param Request $request
     * @return mixed
     */
    public function addUserLocations(Request $request)
    {
        $userLocationModel = new UserLocation();
        try {
            $locations = $request->all();
            $userId = $this->getUserIdFromToken($request);
            foreach($locations as $location)
            {
                $location['user_id'] = $userId;
                $validator = \Validator::make($location, $userLocationModel->validationRules());
                if ($validator->fails()) {
                    return API::response()->array(['success' => false, 'error' => 'Required parameters are missing or incorrect!',
                        'message' => $validator->errors()], 400);
                } else {
                    $userLocationModel->insertUserLocation($location['user_id'], $location['latitude'],
                                                           $location['longitude'], $location['date']);
                }
            }
            return API::response()->array(['success' => true,
                'message' => 'Location updated'], 200);
        } catch(Exception $e) {
            return API::response()->array(['success' => false,
                'message' => $e->getTraceAsString()], 400);
        }
    }
}