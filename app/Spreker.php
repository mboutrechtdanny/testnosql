<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Spreker
 *
 * @property integer $id
 * @property string $naam
 * @property string $email
 * @property string $adres
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Spreker whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Spreker whereNaam($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Spreker whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Spreker whereAdres($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Spreker whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Spreker whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Spreker extends Model {

	protected $fillable = [
		'naam',
		'email',
		'adres',
	];

}
