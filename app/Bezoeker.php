<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Bezoeker
 *
 * @property integer $id
 * @property string $email
 * @property string $naam
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Bezoeker whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bezoeker whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bezoeker whereNaam($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bezoeker whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bezoeker whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Bezoeker extends Model
{
	protected $fillable = [
		'email',
		'naam',
	];
}
