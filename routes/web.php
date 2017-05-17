<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
	return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/reservation', 'ReservationController@create');
Route::post('/reservation', 'ReservationController@store');

//search
Route::get('/search', 'AgendaController@search');

// agenda
Route::get('/agenda', 'AgendaController@index');
Route::get('/agenda/slots', 'AgendaController@getSlotsByDay');

//Route::get('/specific-reservation', 'SpecificReservationController@create');
//Route::get('/specific-reservation/slots', 'SpecificReservationController@getSlotsByDay');
//Route::post('/specific-reservation', 'SpecificReservationController@store');

Route::get('/registration', 'RegistrationController@create');
Route::get('/registration/slots', 'RegistrationController@getSlotsByDay');
Route::post('/registration', 'RegistrationController@store');

// route voor bezoekers om hun onderhandeling te bevestigen (komt van email link)
Route::get('/negotiation', 'NegotiationController@negotiate');

// organisator omgeving
Route::get('/open-registrations', 'OpenRegistrationsController@index');
Route::get('/open-registrations/{registrationId}', 'OpenRegistrationsController@show');
Route::get('/open-registrations/{registrationId}/accept/{accept}', 'OpenRegistrationsController@accept');
Route::get('/open-registrations/{registrationId}/negotiate', 'OpenRegistrationsController@negotiate');
Route::post('/open-registrations/{registrationId}/negotiate', 'OpenRegistrationsController@negotiateStore');

Route::get('/tags', 'TagsController@index');
Route::get('/tags/{slotId}', 'TagsController@changeTags');
Route::post('/tags/{slotId}', 'TagsController@changeTagsStore');
Route::get('/tags/{slotId}/delete', 'TagsController@changeTagsDelete');

Route::get('/ticket-reservations', 'TicketReservationsController@index');
Route::get('/conference-email', 'ConferenceEmailController@index');
Route::post('/conference-email', 'ConferenceEmailController@sendMail');

Route::post('/budget', 'OpenRegistrationsController@budgetUpdate');