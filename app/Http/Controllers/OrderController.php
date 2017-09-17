<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentReceived;
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
        try {
            $validator = \Validator::make($request->all(), $this->_orderModel->validationRules());

            if ($validator->fails()) {
                return API::response()->array(['success' => false,
                    'error'   => 'Required parameters are missing or incorrect!',
                    'message' => $validator->errors()], 400);
            } else {
                $order = $request->all();
                $user = $this->getUserIdFromToken($request, true);
                $order['user_id'] = $user->id;
                $order['agency_id'] = $user->agency_id;
                $order = $this->_orderModel->addOrUpdateOrder($order, $orderId);
                $order->remaining_amount = $this->getRemainingAmount($orderId, $order->price);
                if (is_null($order)) {
                    return API::response()->array(['success' => false,
                        'error' => 'Order Not Found'], 400);
                }
            }
            return API::response()->array(['success' => true,
                'message' => 'Order ' . (($orderId > 0) ? 'Updated' : 'Created'),
                'data'    => $order], 200);
        } catch(Exception $e) {
            return API::response()->array(['success' => false,
                                           'message' => $e->getTraceAsString()], 400);
        }
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
            $order->remaining_amount = $this->getRemainingAmount($order->customer_id, $order->price);
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

    /***
     * List orders
     *
     * @param Request $request
     * @return mixed
     */
    public function listOrders(Request $request)
    {
        try {
            $orderRemainingAmounts = [];
            $userId = $request->get('user_id');
            $page = $request->get('page', 1);
            $avoidPagination = $request->get('avoid_pagination', false);
            if(IsNullOrEmptyString($userId)) {
                $userId = $this->getUserIdFromToken($request);
            }
            $orders = $this->_orderModel->getOrders($userId, $avoidPagination, $page);
            //Calculating remaining amounts
            foreach($orders as $key => $order) {
                if(!array_key_exists($order->id, $orderRemainingAmounts)) {
                    $orderRemainingAmounts[$order->id] = $this->getRemainingAmount($order->id, $order->price);
                }
                $order->remaining_amount = $orderRemainingAmounts[$order->id];
            }
        }
        catch(Exception $e)
        {
            return API::response()->array(['success' => false,
                'message' => $e->getTraceAsString()], 400);
        }
        return API::response()->array(['success' => true, 'message' => 'Orders found',
            'data' => $orders], 200);
    }

    /***
     * Add or update Payment Received
     *
     * @param Request $request
     */
    public function addOrUpdatePaymentReceived(Request $request)
    {
        try {
            $newOrUpdatePayments = [];
            $payments = $request->all();
            $user = $this->getUserIdFromToken($request, true);
            foreach ($payments as $payment) {
                $paymentReceivedModel = new PaymentReceived();
                $validator = \Validator::make($payment, $paymentReceivedModel->validationRules());

                if ($validator->fails()) {
                    return API::response()->array(['success' => false,
                        'error' => 'Required parameters are missing or incorrect!',
                        'message' => $validator->errors()], 400);
                } else {
                    $payment['user_id'] = $user->id;
                    $payment['agency_id'] = $user->agency_id;
                    $payment = $paymentReceivedModel->addOrUpdatePaymentReceived($payment);
                    if (is_null($payment)) {
                        return API::response()->array(['success' => false,
                            'error' => 'Payment Not Found'], 400);
                    }
                    $newOrUpdatePayments[] = $payment;
                }
            }
        } catch (Exception $e) {
            return API::response()->array(['success' => false,
                'message' => $e->getTraceAsString()], 400);
        }
        return API::response()->array(['success' => true, 'message' => 'Payment Received Updated/Created',
            'data' => $newOrUpdatePayments], 200);
    }

    /***
     * Get remaining amount
     *
     * @param $orderId
     * @param $orderAmount
     *
     * @return int|mixed
     */
    public function getRemainingAmount($orderId, $orderAmount)
    {
        $paymentReceivedModel = new PaymentReceived();
        $totalPaymentAgainstOrder = $paymentReceivedModel->getTotalPaymentAgainstOrder($orderId);
        return (($orderAmount - $totalPaymentAgainstOrder) < 0) ? 0 : ($orderAmount - $totalPaymentAgainstOrder);
    }

    /***
     * List payment received API
     *
     * @param Request $request
     * @return mixed
     */
    public function listPaymentReceived(Request $request)
    {
        try {
            $paymentReceivedModel = new PaymentReceived();
            $userId = $request->get('user_id');
            $customerId = $request->get('customer_id', 0);
            $page = $request->get('page', 1);
            $avoidPagination = $request->get('avoid_pagination', false);
            if(IsNullOrEmptyString($userId)) {
                $userId = $this->getUserIdFromToken($request);
            }
            $payments = $paymentReceivedModel->getPaymentReceived($userId, $customerId,
                                                                  $page, $avoidPagination);
        }
        catch(Exception $e)
        {
            return API::response()->array(['success' => false,
                'message' => $e->getTraceAsString()], 400);
        }
        return API::response()->array(['success' => true, 'message' => 'Payments found',
            'data' => $payments], 200);
    }

    /***
     * Update order Status method
     *
     * @param Request $request
     * @return mixed
     */
    public function updateOrderStatus(Request $request)
    {
        try {
            $orderId = $request->get('order_id');
            $userId  = $request->get('user_id');
            $status  = $request->get('status');
            $remarks = $request->get('remarks');
            if(IsNullOrEmptyString($userId)) {
                $userId = $this->getUserIdFromToken($request);
            }
            $order = $this->_orderModel->updateOrderStatus($orderId, $userId, $status, $remarks);
        }
        catch(Exception $e)
        {
            return API::response()->array(['success' => false,
                'message' => $e->getTraceAsString()], 400);
        }
        return API::response()->array(['success' => true, 'message' => 'Order Status Updated',
                                       'data' => $order], 200);
    }
}