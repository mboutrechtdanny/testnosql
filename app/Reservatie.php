<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Reservatie
 *
 * @property integer $id
 * @property string $payment
 * @property integer $bezoeker
 * @property float $prijs
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Reservatie whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reservatie wherePayment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reservatie whereBezoeker($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reservatie wherePrijs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reservatie whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reservatie whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Reservatie extends Model {
	protected $fillable = [
		'bezoeker',
		'payment',
		'prijs',
	];
}
