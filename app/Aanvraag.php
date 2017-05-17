<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Aanvraag
 *
 * @property integer $id
 * @property integer $spreker_id
 * @property \Carbon\Carbon $deadline
 * @property string $status
 * @property string $onderwerp
 * @property string $beschrijving
 * @property string $wensen
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Aanvraag whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Aanvraag whereSprekerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Aanvraag whereDeadline($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Aanvraag whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Aanvraag whereOnderwerp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Aanvraag whereBeschrijving($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Aanvraag whereWensen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Aanvraag whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Aanvraag whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property integer $slot_id
 * @method static \Illuminate\Database\Query\Builder|\App\Aanvraag whereSlotId($value)
 * @property float $kosten
 * @method static \Illuminate\Database\Query\Builder|\App\Aanvraag whereKosten($value)
 */
class Aanvraag extends Model {

	protected $table = 'aanvragen';

	protected $dates = ['deadline'];

	protected $fillable = [
		'spreker_id',
		'slot_id',
		'deadline',
		'kosten',
		'status',
		'onderwerp',
		'beschrijving',
		'wensen',
	];

}
