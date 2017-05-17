<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Ticket
 *
 * @property integer $id
 * @property integer $reservatie
 * @property integer $ticket_type
 * @property string $token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereReservatie($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereTicketType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Ticket extends Model
{
	protected $fillable = [
		'reservatie',
		'ticket_type',
		'token',
	];
}
