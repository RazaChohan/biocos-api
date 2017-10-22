<?php
use App\Models\TargetPoint;
/**
 * Created by PhpStorm.
 * User: raza
 * Date: 10/21/17
 * Time: 11:52 PM
 */
class TargetPointsSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $targetPoints = [
                        'place_order'   => 2,
                        'confirm_order' => 2,
                        'add_customer'  => 5,
                        'complete_job'  => 2,
                        'order_confirm' => 2,
                        'payment_added' => 5
            ];
        foreach($targetPoints as $targetType => $targetPoint) {
            $targetPointModel = new TargetPoint();
            $targetPointModel = $targetPointModel->where('type', $targetType)->first();
            if(is_null($targetPointModel)) {
                $targetPointModel = new TargetPoint();
            }
            $targetPointModel->type = $targetType;
            $targetPointModel->points = $targetPoint;
            $targetPointModel->save();
        }
    }
}