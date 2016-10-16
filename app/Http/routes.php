<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
//este es el endpoint de autentificacion
$app->post('/auth/login', 'Auth\AuthController@postLogin');
//este es un endpoint sin auth
$app->get('/hola', function (){
    return "hola";
});
//Y aqui adentro agrupamos los endpoints que necesitan estar autentificados

$app->group(['middleware' => 'jwt.auth','prefix' => 'api/v1','namespace' => 'App\Http\Controllers'], function ($app) {

    //Listar todos los productos
    $app->get('producto','ProductoController@index');
    //Listar un producto
    $app->get('producto/{id}','ProductoController@obtProducto');
    //Crear un producto
    $app->post('producto','ProductoController@crearProducto');
    //Actualizar un Producto
    $app->put('producto/{id}','ProductoController@actualizarProducto');
    //borrar un producto
    $app->delete('producto/{id}','ProductoController@borrarProducto');

    /*
    Refrescar el token
    */
    $app->get('/auth/refresh', 'App\Http\Controllers\Auth\AuthController@getRefresh');
    /*
    Invalidar el token el token
    */
    $app->delete('/auth/invalidate', 'App\Http\Controllers\Auth\AuthController@deleteInvalidate');
});





