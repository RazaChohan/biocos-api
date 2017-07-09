<?php

namespace App\Http\Controllers;

use App\Models\Region;
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
            if(IsNullOrEmptyString($userId)) {
                $userId = $this->getUserIdFromToken($request);
            }
            $regions = $this->_regionModel->getUserRegions($userId, $regionId, $subRegion);
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
}