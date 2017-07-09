<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Dingo\Api\Facade\API;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

class JobController extends BaseController
{
    /***
     * @var Job
     */
    private $_jobModel;

    /***
     * Constructor
     *
     * @param $request
     * @param Job $jobModel
     */
    public function __construct(Request $request, Job $jobModel)
    {
        parent::__construct($request);
        $this->_jobModel = $jobModel;
    }

    /***
     *List jobs
     *
     * @param $request
     * @return mixed
     */
    public function listJobs(Request $request)
    {
        try {
            $userId = $request->get('user_id');
            $date = $request->get('date');
            $regionId = $request->get('region_id');
            $status = $request->get('status');
            $subRegion = $request->get('sub_region');

            if(IsNullOrEmptyString($userId)) {
                $userId = $this->getUserIdFromToken($request);
            }
            $jobs = $this->_jobModel->getUserJobs($userId, $date, $regionId,
                                                  $status, $subRegion);
        }
        catch(Exception $e)
        {
            return API::response()->array(['success' => false,
                                           'message' => $e->getTraceAsString()], 400);
        }
        return API::response()->array(['success' => true, 'message' => 'Jobs found',
                                       'data' => $jobs], 200);
    }
}