<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Dingo\Api\Facade\API;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

class OrderController extends BaseController
{
    /***
     * @var Order
     */
    private $_orderModel;

    /***
     * Constructor
     *
     * @param $request
     * @param Order $orderModel
     */
    public function __construct(Request $request, Order $orderModel)
    {
        parent::__construct($request);
        $this->_orderModel = $orderModel;
    }

    /***
     * Book or update orders
     *
     * @param $orderId
     * @param $request
     *
     * @return mixed
     */
    public function bookOrUpdateOrder(Request $request, $orderId = 0)
    {
        $validator = \Validator::make($request->all(), Order::validationRules());

        if ($validator->fails()) {
            return API::response()->array(['success' => false,'error' => 'Required parameters are missing or incorrect!',
                                           'message' => $validator->errors()], 400);
        }else{
            $order = $request->all();
            $user = $this->getUserIdFromToken($request, true);
            $order['user_id']   = $user->id;
            $order['agency_id'] = $user->agency_id;
            $order = $this->_orderModel->addOrUpdateOrder($order, $orderId);
            if(is_null($order)) {
                return API::response()->array(['success' => false,
                    'error' => 'Order Not Found'], 400);
            }
        }
        return API::response()->array(['success' => true,
            'message' => 'Order ' . (($orderId > 0) ? 'Updated' : 'Created'),
            'data' => $order], 200);
    }

    /***
     * Get Order Details
     *
     * @param $orderId
     * @return mixed
     */
    public function getOrderDetails($orderId)
    {
        try {
            $order = $this->_orderModel->getOrderDetails($orderId);
        }
        catch(Exception $e)
        {
            return API::response()->array(['success' => false,
                                           'message' => $e->getTraceAsString()], 400);
        }
        return API::response()->array(['success' => true,
                                       'message' => is_null($order) ? 'Order not found' : 'Order found',
                                       'data' => $order], 200);
    }
}