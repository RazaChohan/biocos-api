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
            return API::response()->array(['success' => false, 'message' => 'Exception',
                'message' => $e->getTraceAsString()], 400);
        }
        return API::response()->array(['success' => false, 'message' => 'Regions found',
            'data' => $regions], 200);
    }
}