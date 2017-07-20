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
            $page      = $request->get('page', 1);

            if(IsNullOrEmptyString($userId)) {
                $userId = $this->getUserIdFromToken($request);
            }
            $jobs = $this->_jobModel->getUserJobs($userId, $date, $regionId,
                                                  $status, $subRegion, $page);
        }
        catch(Exception $e)
        {
            return API::response()->array(['success' => false,
                                           'message' => $e->getTraceAsString()], 400);
        }
        return API::response()->array(['success' => true, 'message' => 'Jobs found',
                                       'data' => $jobs], 200);
    }

    /***
     * Update jobs order
     *
     * @param Request $request
     * @return mixed
     */
    public function updateJobsOrder(Request $request)
    {
        try {
            $jobsToUpdate  = $request->all();
            if(count($jobsToUpdate) == 0) {
                return API::response()->array(['success' => false,
                    'error' => 'Required parameters are missing or incorrect!',
                    'message' => 'Data is missing!'], 400);
            }
            $userId = $this->getUserIdFromToken($request);
            $jobsUpdated = $this->_jobModel->updateJobOrder($jobsToUpdate, $userId);
            if($jobsUpdated) {
                return API::response()->array(['success' => true,
                    'message' => 'Jobs order Updated'], 200);
            } else {
                return API::response()->array(['success' => false,
                    'message' => 'Jobs not found or invalid request'], 400);
            }
        }
        catch(Exception $e) {
            return API::response()->array(['success' => false,
                'message' => $e->getTraceAsString()], 400);
        }
    }
}