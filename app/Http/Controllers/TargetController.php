<?php
/**
 * Created by PhpStorm.
 * User: raza
 * Date: 10/22/17
 * Time: 4:37 PM
 */

namespace App\Http\Controllers;


use App\Models\UserPoint;
use Carbon\Carbon;
use Dingo\Api\Facade\API;
use League\Flysystem\Exception;
use Illuminate\Http\Request;

class TargetController extends BaseController
{
    /***
     * @var UserPoint
     */
    private $_userPointsModel;

    /***
     * Constructor
     *
     * @param $request
     * @param UserPoint $userPointsModel
     */
    public function __construct(Request $request, UserPoint $userPointsModel)
    {
        parent::__construct($request);
        $this->_userPointsModel = $userPointsModel;
    }

    /***
     *Get User points
     *
     * @param $request
     * @return mixed
     */
    public function getUserPoints(Request $request)
    {
        try {
            $userId = $request->get('user_id');
            $startDate = $request->get('start_date');
            $endDate   = $request->get('end_date');
            if(!is_null($startDate)) {
                //$startDate = Carbon::parse($startDate)->toDateString();
                //$endDate = Carbon::parse($endDate)->toDateString();
            }
            if(IsNullOrEmptyString($userId)) {
                $userId = $this->getUserIdFromToken($request);
            }
            $points = $this->_userPointsModel->getUserPoints($userId, $startDate, $endDate);
        }
        catch(Exception $e)
        {
            return API::response()->array(['success' => false,
                'message' => $e->getTraceAsString()], 400);
        }
        return API::response()->array(['success' => true, 'message' => 'User points',
            'data' => $points], 200);
    }
}