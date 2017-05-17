<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Slot
 *
 * @property integer $id
 * @property integer $zaal
 * @property integer $dag
 * @property string $tijdstart
 * @property string $tijdeind
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Slot whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Slot whereZaal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Slot whereDag($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Slot whereTijdstart($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Slot whereTijdeind($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Slot whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Slot whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Slot whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property integer $spreker
 * @method static \Illuminate\Database\Query\Builder|\App\Slot whereSpreker($value)
 */
class Slot extends Model {

	protected $fillable = [
		'zaal',
		'dag',
		'tijdstart',
		'tijdeind',
		'status',
	];

}
