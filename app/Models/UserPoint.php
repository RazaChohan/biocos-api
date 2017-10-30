<?php
/**
 * Created by PhpStorm.
 * User: raza
 * Date: 10/21/17
 * Time: 11:33 PM
 */

namespace App\Models;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user_points';
    /***
     * @var array
     */
    protected $guarded = ['id'];
    /***
     * Timestamps does not exists
     *
     * @var bool
     */
    public $timestamps = false;

    /***
     * Get user points b/w dates
     *
     * @param $userId
     * @param $startDate
     * @param $endDate
     * @param $sendDateWise
     *
     * @return integer $points
     */
    public function getUserPoints($userId, $startDate, $endDate, $sendDateWise)
    {
        $query = $this->where('user_id', $userId);
        $result = null;
        if(is_null($sendDateWise)) {
            if (!is_null($startDate) && !is_null($endDate)) {
                $query->whereBetween(DB::raw('DATE(date)'), [$startDate, $endDate]);
            } else if (!is_null($startDate)) {
                $query->where(DB::raw('DATE(date)'), '>=', $startDate);
            } else if (!is_null($endDate)) {
                $query->where(DB::raw('DATE(date)'), '<=', $endDate);
            }
            $result = $query->sum('points');
        } else {
            $result = DB::select("SELECT  date, (@totalPoints :=  points  + @totalPoints) AS points
                                    FROM user_points, (SELECT @totalPoints:=0) c WHERE user_points.user_id = $userId;");
        }
        return !is_null($result) ? $result : 0;
    }

    /***
     * @param $userId
     * @param $type
     */
    public function insertUserPoints($userId, $type)
    {
        $targetPointsModel = new TargetPoint();
        $points = $targetPointsModel->getTypePoints($type);
        if($points > 0) {
            $this->insert(['user_id' => $userId, 'points' => $points, 'date' => Carbon::now()]);
        }
    }
}