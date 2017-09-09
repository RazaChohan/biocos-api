<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Job;
use App\Models\Order;
use App\Models\PaymentReceived;
use App\Models\Region;
use App\Models\User;
use App\Models\UserRegion;
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
        $customers   = $request->get('customers');
        $orders      = $request->get('orders');
        $regions     = $request->get('regions');
        $payments    = $request->get('payments');
        $userRegions = $request->get('user_regions');
        $regionsResponses = [];
        $customersResponses  = [];
        $ordersResponses = [];
        $paymentResponses = [];
        $userRegionsResponses = [];
        $user = $this->getUserIdFromToken($request, true);
        try {
            $validationErrors = $this->checkValidation($customers, $orders, $regions,$paymentResponses);
            if(count($validationErrors) > 0) {
                return API::response()->array(['success' => false, 'error' => 'Required parameters are missing or incorrect!',
                    'message' => $validationErrors], 400);
            } else {
                //Insert Regions
                $regionModel = new Region();
                if(!is_null($regions) && count($regions) > 0) {
                    foreach($regions as $region) {
                        $region['user_id'] = $user->id;
                        $region['agency_id'] = $user->agency_id;
                        $regionId = array_key_exists('region_id', $region)
                                            ? $region['region_id'] : 0;
                        if($regionId == 0) {
                            $regionId = $regionModel->getRegionId($region['uuid']);
                        }
                        $regionsResponses[] = $regionModel->addOrUpdateRegion($region, $regionId);
                    }
                }
                //Insert Customers
                $customerModel = new Customer();
                if(!is_null($customers) && count($customers) > 0) {
                    foreach($customers as $customer) {
                        $customer['user_id']     = $user->id;
                        $customer['agency_id']   = $user->agency_id;
                        $customerId              = array_key_exists('customer_id', $customer)
                                                            ? $customer['customer_id'] : 0;
                        if($customerId == 0) {
                            $customerId = $customerModel->getCustomerId($customer);
                        }
                        $newUpdatedCustomer = $customerModel->addOrUpdateCustomer($customer, $customerId, true);
                        if($customerId == 0) {
                            $jobModel = new Job();
                            $job = $jobModel->addJobForNewCustomer($newUpdatedCustomer);
                            $newUpdatedCustomer->job = $job;
                        }
                        $customersResponses [] = $newUpdatedCustomer;
                    }
                }
                //Insert Orders
                $orderModel = new Order();
                if(!is_null($orders) && count($orders) > 0) {
                    foreach($orders as $order) {
                        $order['user_id']   = $user->id;
                        $order['agency_id'] = $user->agency_id;
                        $orderId            = array_key_exists('order_id', $order)
                                                ? $order['order_id'] : 0;
                        if($orderId == 0) {
                            $orderId = $orderModel->getOrderId($order['uuid']);
                        }
                        $ordersResponses[] = $orderModel->addOrUpdateOrder($order, $orderId);
                    }
                }

                //Insert Payments
                if(!is_null($payments) && count($payments) > 0) {
                    $paymentModel = new PaymentReceived();
                    foreach($payments as $payment) {
                        $payment['user_id']   = $user->id;
                        if(array_key_exists('order_uuid', $payment)) {
                            $payment['order_id'] = $orderModel->getOrderId($payment['customer_uuid']);
                        }
                        if(array_key_exists('customer_uuid', $payment)) {
                            $customerArr['uuid'] = $payment['customer_uuid'];
                            $payment['customer_id'] = $customerModel->getCustomerId($customerArr);
                        }
                        $paymentResponses[] = $paymentModel->addOrUpdatePaymentReceived($payment);
                    }
                }
                //Insert/Update user Regions
                if(!is_null($userRegions) && count($userRegions) > 0) {
                    // Delete Regions
                    $deleteRegions = $userRegions['delete_assign_region_model_list'];
                    $userRegionModel = new UserRegion();
                    foreach($deleteRegions as $deleteRegion) {
                        if(array_key_exists('delete', $deleteRegion) && $deleteRegion['delete'] == "true") {
                            $userRegionModel->deleteUserRegion($deleteRegion['id']);
                        }
                    }
                    // Update Regions
                    $userRegions = $userRegions['update_region_model_list'];
                    $userModel = new User();
                    foreach($userRegions as $key => $userRegion) {
                        $userRegions[$key]['user_id']   = $user->id;
                        $userRegions[$key]['agency_id'] = $user->agency_id;
                        if(array_key_exists('region_uuid', $userRegion)) {
                            $userRegions[$key]['region_id'] = $regionModel->getRegionId($userRegion['region_uuid']);
                        }
                    }
                    $userRegionsResponses[] = $userModel->assignOrUpdateRegions($userRegions, $user->id);
                }

                $data = new \stdClass();
                $data->customers = $customersResponses;
                $data->orders = $ordersResponses;
                $data->regions = $regionsResponses;
                $data->payments = $paymentResponses;
                $data->user_regions = $userRegionsResponses;
                return API::response()->array(['success' => true,
                    'message' => 'Records Created/Updated',
                    'data' => $data], 200);
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
     * @param $payments
     * @return array
     */
    public function checkValidation($customers, $orders, $regions, $payments)
    {
        $customerModel = new Customer();
        $orderModel    = new Order();
        $regionModel   = new Region();
        $paymentReceivedModel = new PaymentReceived();
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
        // Validate Payment Received
        if(!is_null($payments) && count($payments) > 0) {
            foreach ($payments as $payment) {
                $validator = \Validator::make($payment, $paymentReceivedModel->validationRules());
                if ($validator->fails()) {
                    $validationErrors['payments'][] = $validator->errors();
                }
            }
        }
        return $validationErrors;
    }
}
