<?php

namespace App\Http\Controllers\Auth;

use JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Http\Exception\HttpResponseException;

class AuthController extends Controller
{
    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        /*
        Primero verificamos si el email esta dentro de los parametros y si ha enviado una contraseña
        */
        try {
            $this->validate($request, [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ]);
        } catch (HttpResponseException $e) {
            return response()->json([
                'error' => [
                    'message' => 'parametros_invalidos',
                    'status_code' => IlluminateResponse::HTTP_BAD_REQUEST,
                ],
            ], IlluminateResponse::HTTP_BAD_REQUEST);
        }
        /*
        Despues obtenemos solamente los aprametros de email y de password (para evitar que injecten otros parametros)
        */
        $credentials = $this->getCredentials($request); 

        try {
            // Si el token que regresa attemp esta vacio quiere decir que no encontro un usuario valido
            //Entonces retorna credenciales invalidas
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => [
                        'message' => 'credenciales_invalidas',
                    ],
                ], IlluminateResponse::HTTP_UNAUTHORIZED);
            }
        } catch (JWTException $e) {
            //Si existe algun error interno externo arroja error 500
            return response()->json([
                'error' => [
                    'message' => 'no_se_pudo_crear_token',
                ],
            ], IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        // si el login y el token es valido los retorno  :)
        return response()->json([
            'success' => [
                'message' => 'token_generado',
                'token' => $token,
            ]
        ]);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    /**
     * Invalidamos el token
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteInvalidate()
    {
        $token = JWTAuth::parseToken();

        $token->invalidate();

        return ['success' => 'token_invalidado'];
    }

    /**
     * Refrescamos el token.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRefresh()
    {
        $token = JWTAuth::parseToken();

        $newToken = $token->refresh();

        return ['success' => 'token_refrescado', 'token' => $newToken];
    }
}
