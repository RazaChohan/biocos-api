<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Dingo\Api\Facade\API;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

class CustomerController extends BaseController
{
    /***
     * @var Customer
     */
    private $_customerModel;

    /***
     * Constructor
     *
     * @param $request
     * @param Customer $customerModel
     */
    public function __construct(Request $request, Customer $customerModel)
    {
        parent::__construct($request);
        $this->_customerModel = $customerModel;
    }

    /***
     * List customers
     *
     * @param $request
     * @return mixed
     */
    public function listCustomers(Request $request)
    {
        try {
            $userId = $request->get('user_id');
            $regionId = $request->get('region_id');
            $subRegion = $request->get('sub_region');

            if(IsNullOrEmptyString($userId)) {
                $userId = $this->getUserIdFromToken($request);
            }
            $customers = $this->_customerModel->getCustomers($userId, $regionId, $subRegion);
        }
        catch(Exception $e)
        {
            return API::response()->array(['success' => false, 'message' => 'Exception',
                'message' => $e->getTraceAsString()], 400);
        }
        return API::response()->array(['success' => true, 'message' => 'Customers found',
            'data' => $customers], 200);
    }
}