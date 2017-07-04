<?php

namespace App\Http\Controllers;

use Dingo\Api\Facade\API;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use App\Models\Product;
use App\Models\User;

class ProductController extends BaseController
{
    /***
     * @var Product
     */
    private $_productModel;

    /***
     * Constructor
     *
     * @param $request
     * @param Product $productModel
     */
    public function __construct(Request $request, Product $productModel)
    {
        parent::__construct($request);
        $this->_productModel = $productModel;
    }

    /***
     * List Products
     *
     * @param $request
     * @return mixed
     */
    public function listProducts(Request $request)
    {
        try {
            $userId = $request->get('user_id');
            $agencyId = $request->get('agency_id');

            if(IsNullOrEmptyString($userId)) {
                $userId = $this->getUserIdFromToken($request);
            }
            if(IsNullOrEmptyString($agencyId)) {
                $userModel = new User();
                $agencyId = $userModel->getUserAgencyId($userId);
            }
            $products = $this->_productModel->getProducts($agencyId);
        }
        catch(Exception $e)
        {
            return API::response()->array(['success' => false, 'message' => 'Exception',
                'message' => $e->getTraceAsString()], 400);
        }
        return API::response()->array(['success' => true, 'message' => 'Products found',
            'data' => $products], 200);
    }

    /***
     * Get Product Detail
     *
     * @param $productId
     * @return mixed
     */
    public function productDetail($productId)
    {
        try {
            $product = $this->_productModel->getProductDetail($productId);
        }
        catch(Exception $e)
        {
            return API::response()->array(['success' => false, 'message' => 'Exception',
                'message' => $e->getTraceAsString()], 400);
        }
        return API::response()->array(['success' => true, 'message' => is_null($product) ? 'Product not found' : 'Product found',
            'data' => $product], 200);
    }
}