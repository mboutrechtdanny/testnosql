<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Jenssegers\Mongodb\Eloquent\Model;

class Reservation extends Model
{
    use HybridRelations;

    protected $guarded = ['id'];

    protected $collection = 'orders';

    protected $connection = 'mongodb';
}
