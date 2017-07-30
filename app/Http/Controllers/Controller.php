<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use Dingo\Api\Facade\API;

class Controller extends BaseController
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
     * Get Constants
     */
    public function getConstants()
    {
        try {
            $constants = $this->_userModel->getConstants();
        }
        catch(Exception $e)
        {
            return API::response()->array(['success' => false,
                                           'message' => $e->getTraceAsString()], 400);
        }
        return API::response()->array(['success' => true, 'message' => 'Constants found',
            'data' => $constants], 200);
    }

    /***
     * Sync Data
     *
     * @param Request $request
     * @return mixed
     */
    public function syncData(Request $request)
    {
        $customers = $request->get('customers');
        $orders    = $request->get('orders');
        $regions   = $request->get('regions');
        $user = $this->getUserIdFromToken($request, true);
        try {
            $validationErrors = $this->checkValidation($customers, $orders, $regions);
            if(count($validationErrors) > 0) {
                return API::response()->array(['success' => false, 'error' => 'Required parameters are missing or incorrect!',
                    'message' => $validationErrors], 400);
            } else {
                //Insert Regions
                if(!is_null($regions) && count($regions) > 0) {
                    $regionModel = new Region();
                    foreach($regions as $region) {
                        $region['user_id'] = $user->id;
                        $region['agency_id'] = $user->agency_id;
                        $regionId = array_key_exists('region_id', $region)
                                            ? $region['region_id'] : 0;
                        $regionModel->addOrUpdateRegion($region, $regionId);
                    }
                }
                //Insert Customers
                if(!is_null($customers) && count($customers) > 0) {
                    $customerModel = new Customer();
                    foreach($customers as $customer) {
                        $customer['user_id']     = $user->id;
                        $customer['agency_id']   = $user->agency_id;
                        $customerId              = array_key_exists('customer_id', $customer)
                                                            ? $customer['customer_id'] : 0;
                        if($customerId == 0) {
                            $customerId = $customerModel->getCustomerId($customer);
                        }
                        $customerModel->addOrUpdateCustomer($customer, $customerId);
                    }
                }
                //Insert Orders
                if(!is_null($orders) && count($orders) > 0) {
                    $orderModel = new Order();
                    foreach($orders as $order) {
                        $order['user_id']   = $user->id;
                        $order['agency_id'] = $user->agency_id;
                        $orderId            = array_key_exists('order_id', $order)
                                                ? $order['order_id'] : 0;
                        $orderModel->addOrUpdateOrder($order, $orderId);
                    }
                }
                return API::response()->array(['success' => true,
                    'message' => 'Records Created'], 200);
            }
        } catch(Exception $e) {
            return API::response()->array(['success' => false,
                'message' => $e->getTraceAsString()], 400);
        }
    }

    /***
     * Check Validation
     *
     * @param $customers
     * @param $orders
     * @param $regions
     * @return array
     */
    public function checkValidation($customers, $orders, $regions)
    {
        $customerModel = new Customer();
        $orderModel    = new Order();
        $regionModel   = new Region();
        $validationErrors = [];
        //Validate Customers
        if(!is_null($customers) && count($customers) > 0) {
            //Customers Validation Check
            foreach ($customers as $customer) {
                $validator = \Validator::make($customer, $customerModel->validationRules());
                if ($validator->fails()) {
                    $validationErrors['customers'][] = $validator->errors();
                }
            }
        }
        //Validation Orders
        if(!is_null($orders) && count($orders) > 0) {
            //Order Validation Check
            foreach ($orders as $order) {
                $validator = \Validator::make($order, $orderModel->validationRules());
                if ($validator->fails()) {
                    $validationErrors['orders'][] = $validator->errors();
                }
            }
        }
        //Validate Regions
        if(!is_null($regions) && count($regions) > 0) {
            foreach ($regions as $region) {
                $validator = \Validator::make($region, $regionModel->validationRules());
                if ($validator->fails()) {
                    $validationErrors['regions'][] = $validator->errors();
                }
            }
        }
        return $validationErrors;
    }
}
