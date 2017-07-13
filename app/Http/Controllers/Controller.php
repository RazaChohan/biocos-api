<?php

namespace App\Http\Controllers;

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
}
