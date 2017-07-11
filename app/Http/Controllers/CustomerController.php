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
            $page = $request->get('page', 1);
            if(IsNullOrEmptyString($userId)) {
                $userId = $this->getUserIdFromToken($request);
            }
            $customers = $this->_customerModel->getCustomers($userId, $regionId, $subRegion, $page);
        }
        catch(Exception $e)
        {
            return API::response()->array(['success' => false,
                                           'message' => $e->getTraceAsString()], 400);
        }
        return API::response()->array(['success' => true, 'message' => 'Customers found',
            'data' => $customers], 200);
    }

    /***
     * Add or Update Customer
     *
     * @param Request $request
     * @param int $customerId
     * @return mixed
     */
    public function addOrUpdateCustomer(Request $request, $customerId = 0)
    {
        try {
            $validator = \Validator::make($request->all(), $this->_customerModel->validationRules());

            if ($validator->fails()) {
                return API::response()->array(['success' => false, 'error' => 'Required parameters are missing or incorrect!',
                                               'message' => $validator->errors()], 400);
            } else {
                $customer = $request->all();
                $user = $this->getUserIdFromToken($request, true);
                $customer['user_id'] = $user->id;
                $customer['agency_id'] = $user->agency_id;
                $customer = $this->_customerModel->addOrUpdateCustomer($customer, $customerId);
                if (is_null($customer)) {
                    return API::response()->array(['success' => false,
                                                   'error' => 'Customer Not Found'], 400);
                }
            }
            return API::response()->array(['success' => true,
                'message' => 'Customer ' . (($customerId > 0) ? 'Updated' : 'Created'),
                'data' => $customer], 200);
        } catch(Exception $e) {
            return API::response()->array(['success' => false,
                'message' => $e->getTraceAsString()], 400);
        }
    }

    /***
     * Get Customer Details
     *
     * @param $customerId
     * @return mixed
     */
    public function getCustomerDetails($customerId)
    {
        try {
            $customer = $this->_customerModel->getCustomerDetail($customerId);
        } catch(Exception $e) {
            return API::response()->array(['success' => false,
                'message' => $e->getTraceAsString()], 400);
        }
        return API::response()->array(['success' => true,
            'message' => is_null($customer) ? 'Customer not found' : 'Customer found',
            'data' => $customer], 200);
    }
}