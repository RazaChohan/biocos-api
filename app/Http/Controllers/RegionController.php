<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\User;
use App\Models\UserRegion;
use Dingo\Api\Facade\API;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

class RegionController extends BaseController
{
    /***
     * @var Region
     */
    private $_regionModel;

    /***
     * Constructor
     *
     * @param $request
     * @param Region $regionModel
     */
    public function __construct(Request $request, Region $regionModel)
    {
        parent::__construct($request);
        $this->_regionModel = $regionModel;
    }

    /***
     *List regions
     *
     * @param $request
     * @return mixed
     */
    public function listRegions(Request $request)
    {
        try {
            $userId = $request->get('user_id');
            $regionId = $request->get('region_id');
            $subRegion = $request->get('sub_region');
            $avoidPagination = $request->get('avoid_pagination', false);
            $page      = $request->get('page', 1);
            if(IsNullOrEmptyString($userId)) {
                $userId = $this->getUserIdFromToken($request);
            }
            $regions = $this->_regionModel->getUserRegions($userId, $regionId, $subRegion,
                                                           $avoidPagination , $page);
        }
        catch(Exception $e)
        {
            return API::response()->array(['success' => false,
                                           'message' => $e->getTraceAsString()], 400);
        }
        return API::response()->array(['success' => true,
                                       'message' => 'Regions found',
                                       'data' => $regions], 200);
    }

    /***
     * Add or Update region
     *
     * @param Request $request
     * @param int $regionId
     * @return mixed
     */
    public function addOrUpdateRegion(Request $request, $regionId = 0)
    {
        try {
            $validator = \Validator::make($request->all(), $this->_regionModel->validationRules());

            if ($validator->fails()) {
                return API::response()->array(['success' => false, 'error' => 'Required parameters are missing or incorrect!',
                    'message' => $validator->errors()], 400);
            } else {
                $region = $request->all();
                $user = $this->getUserIdFromToken($request, true);
                $region['user_id'] = $user->id;
                $region['agency_id'] = $user->agency_id;
                $region = $this->_regionModel->addOrUpdateRegion($region, $regionId);
                if (is_null($region)) {
                    return API::response()->array(['success' => false,
                        'error' => 'Region Not Found'], 400);
                }
            }
            return API::response()->array(['success' => true,
                'message' => 'Region ' . (($regionId > 0) ? 'Updated' : 'Created'),
                'data' => $region], 200);
        } catch(Exception $e) {
            return API::response()->array(['success' => false,
                'message' => $e->getTraceAsString()], 400);
        }
    }

    /***
     * Assign Or Update Regions
     *
     * @param Request $request
     * @return mixed
     */
    public function assignOrUpdateRegions(Request $request)
    {
        try {
            $addOrUpdateRegions = $request->get('update_region_model_list');
            $deleteUserRegions  = $request->get('delete_assign_region_model_list');
            $userModel = new User();
            $user = $this->getUserIdFromToken($request, true);
            //Delete User Regions
            if(!is_null($deleteUserRegions) && count($deleteUserRegions) > 0) {
                $userRegionModel = new UserRegion();
                foreach ($deleteUserRegions as $deleteUserRegion) {
                    if(array_key_exists('delete', $deleteUserRegion) && $deleteUserRegion['delete'] == "true") {
                        $userRegionModel->deleteUserRegion($deleteUserRegion['id']);
                    }
                }
            }
            //Assign or update regions
            $userRegions = $userModel->assignOrUpdateRegions($addOrUpdateRegions, $user->id);
            if (count($userRegions) == 0) {
                return API::response()->array(['success' => false,
                    'error' => 'Region Not Found'], 400);
            }
            return API::response()->array(['success' => true,
                'message' => 'User Regions Updated',
                'data' => $userRegions], 200);
        } catch(Exception $e) {
            return API::response()->array(['success' => false,
                'message' => $e->getTraceAsString()], 400);
        }
    }
    /***
     * List user regions
     *
     * @param $request
     * @return mixed
     */
    public function listUserRegions(Request $request)
    {
        try {
            $userId = $this->getUserIdFromToken($request, false);
            $userModel = new User();
            $regions = $userModel->getUserRegionsWithPivot($userId);
        }
        catch(Exception $e)
        {
            return API::response()->array(['success' => false,
                'message' => $e->getTraceAsString()], 400);
        }
        return API::response()->array(['success' => true,
            'message' => 'User Regions found',
            'data' => $regions], 200);
    }

}