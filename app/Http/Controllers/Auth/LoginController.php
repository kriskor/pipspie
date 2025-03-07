<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Vitacora;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function username()
    {
        return 'username';
    }

    public function logout(Request $request)
    {
      $this->user = \Auth::user();
      if($this->user){
        $this->vitacora("Salio del sistema",'logout');
        $this->guard()->logout();
        $request->session()->invalidate();
      }
      return redirect('/');
    }
    public function login(Request $request) {

          $this->validateLogin($request);

          // If the class is using the ThrottlesLogins trait, we can automatically throttle
          // the login attempts for this application. We'll key this by the username and
          // the IP address of the client making these requests into this application.
          if ($this->hasTooManyLoginAttempts($request)) {
              $this->fireLockoutEvent($request);

              return $this->sendLockoutResponse($request);
          }

          if ($this->attemptLogin($request)) {
              $this->vitacora("Ingreso al sistema",'login');
              return $this->sendLoginResponse($request);
          }

          // If the login attempt was unsuccessful we will increment the number of attempts
          // to login and redirect the user back to the login form. Of course, when this
          // user surpasses their maximum number of attempts they will get locked out.
          $this->incrementLoginAttempts($request);


          return $this->sendFailedLoginResponse($request);
    }

    public function vitacora($accion,$tipo)
    {
        $this->user = \Auth::user();
        //dd(\Auth::user());
        $vitacora = new Vitacora();
        $vitacora->id_entidad = $this->user->id_institucion;
        $vitacora->id_usuario = $this->user->id;
        $vitacora->fecha_hora = date('Y-m-d H:i:s');
        $vitacora->accion_realizada = "<b>".$this->user->username."</b>:(".$this->user->name.")".$accion;
        $vitacora->ip_usuario = \Request::ip();
        $vitacora->tipo_accion = $tipo;
        $vitacora->save();
    }

}
