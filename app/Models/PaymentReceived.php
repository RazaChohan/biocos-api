<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PaymentReceived extends Model
{
    /**
     * The table name
     *
     * @var string
     */
    protected $table = 'payment_received';
    /***
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $guarded = ['id'];
    /***
     * Timestamp false
     *
     * @var bool
     */
    public $timestamps = false;
}