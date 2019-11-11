<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'UserController@index')->name('user.index');

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin'], function () {
    Route::get('login', 'AdminController@loginPage')->name('admin.loginPage');
    Route::post('login', 'AdminController@login')->name('admin.login');

    Route::get('dashboard', 'AdminController@dashboard')->name('admin.dashboard');

    Route::get('category', 'AdminController@categoryPage')->name('admin.category');
    Route::get('city', 'AdminController@cityPage')->name('admin.city');
    Route::get('events', 'AdminController@eventPage')->name('admin.event');
    Route::get('logout', 'AdminController@logout')->name('admin.logout');
});

Route::group(['prefix' => 'event'], function() {
    Route::get('create', 'EventController@create')->name('event.create');
    Route::post('store', 'EventController@store')->name('event.store');
    Route::delete('{id}/delete', 'EventController@delete')->name('event.delete');
    Route::get('{id}/edit', 'EventController@edit')->name('event.edit');
    Route::patch('{id}/update', 'EventController@update')->name('event.update');
    Route::get('/{title}/buy-ticket', 'EventController@ticketDetail')->name('event.ticket');
    Route::get('/{title}', 'EventController@detail')->name('event.detail');
    
    Route::get('{id}/ticket', 'TicketController@info')->name('ticket.info');
    Route::get('{id}/create-ticket', 'TicketController@create')->name('ticket.create');
    Route::post('{id}/create-ticket', 'TicketController@store')->name('ticket.store');
    Route::delete('{id}/delete-ticket', 'TicketController@delete')->name('ticket.delete');

    Route::post('{id}/book', 'EventController@book')->name('event.book');

    Route::get('{id}/guests', 'EventController@guests')->name('event.guests');
    Route::get('{id}/guestsData', 'EventController@getGuestsData')->name('event.guestsData');

    Route::get('{id}/redeem', 'EventController@redeemPage')->name('event.redeem');
});

Route::group(['prefix' => 'redeem'], function() {
    Route::post('/store', 'RedeemController@store')->name('redeem.store');
});

Route::post('attend', 'EventController@attend')->name('event.attend');

Route::group(['prefix' => 'ticket'], function() {
    Route::get('{id}/detail', 'TicketController@detail')->name('ticket.detail');
    Route::get('{id}/edit', 'TicketController@edit')->name('ticket.edit');
    Route::put('{id}/update', 'TicketController@update')->name('ticket.update');
});

Route::group(['prefix' => 'contact'], function() {
    Route::post('store', 'ContactController@store')->name('contact.store');
    Route::delete('{id}/delete', 'ContactController@delete')->name('contact.delete');
});

Route::group(['prefix' => 'category'], function() {
    Route::post('store', 'CategoryController@store')->name('category.store');
    Route::delete('{id}/delete', 'CategoryController@delete')->name('category.delete');
});

Route::group(['prefix' => 'payment'], function() {
    Route::get('create', 'PaymentController@create')->name('payment.create');
    Route::post('store', 'PaymentController@store')->name('payment.store');
    Route::delete('{id}/delete', 'PaymentController@delete')->name('payment.delete');
});

Route::group(['prefix' => 'city'], function() {
    Route::post('store', 'CityController@store')->name('city.store');
    Route::delete('{id}/delete', 'CityController@delete')->name('city.delete');
});

Route::get('/login/{redirectTo?}', 'UserController@loginPage')->name('user.loginPage');
Route::post('/login', 'UserController@login')->name('user.login');
Route::get('/register', 'UserController@registerPage')->name('user.registerPage');
Route::post('/register', 'UserController@register')->name('user.register');
Route::get('/logout', 'UserController@logout')->name('user.logout');

Route::get('/dashboard', 'UserController@dashboard')->name('user.dashboard')->middleware('User');
Route::get('/events', 'UserController@eventsPage')->name('user.events')->middleware('User');
Route::get('/settings', 'UserController@settingsPage')->name('user.settings')->middleware('User');
Route::get('/payments', 'UserController@paymentsPage')->name('user.payments')->middleware('User');
Route::get('/tickets', 'UserController@ticketsPage')->name('user.tickets')->middleware('User');

Route::get('/artisan/{toDo}', function($toDo) {
    Artisan::call($toDo);
    return "ok";
});

Route::get('/qr/scan', function() {
    return view('qrscanner');
})->name('scan');
Route::get('/qr/generate', function() {
    return view('qrgenerator');
});
