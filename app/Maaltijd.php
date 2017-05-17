<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Maaltijd
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $reservatie
 * @property integer $maaltijd_type
 * @property string $token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Maaltijd whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Maaltijd whereReservatie($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Maaltijd whereMaaltijdType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Maaltijd whereToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Maaltijd whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Maaltijd whereUpdatedAt($value)
 */
class Maaltijd extends Model
{
	protected $table = 'maaltijden';

	protected $fillable = [
		'reservatie',
		'maaltijd_type',
		'token',
	];
}
