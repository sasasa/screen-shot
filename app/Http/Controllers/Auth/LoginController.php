<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

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

    protected function redirectTo()
    {
        return route('system_admin.sites.index');
    }

    public function authenticate(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $validator = Validator::make($request->all(), [
          'email' => 'required',
          'password' => 'required',
        ]);

        if ($validator->fails()){
          return redirect()->back()->withErrors('Email・パスワードを入力してください'. $this->add_message);
        }
        $admin = Admin::where('email', $email)->first();
        if(is_null($admin)) {
          //ID正しくない
          return redirect()->back()->withErrors('Emailもしくはパスワードが違うためログインできません');
        }
        if($admin->fail_count >= 3){
          return redirect()->back()->withErrors('ログインエラー:ロックされています');
        }
        if(!Hash::check($password, $admin->password)) {
          $this->fail_count_up($admin);
          return redirect()->back()->withErrors('Emailもしくはパスワードが違うためログインできません'. $this->add_message);
        }
        Auth::loginUsingId($admin->id);
        $admin->fail_count = 0;
        $admin->save();

        if(Auth::guard('admin')->attempt([
            'email' => $email,
            'password' => $password,
        ])) {
          $admin->fail_count = 0;
          $admin->save();

          return $this->sendLoginResponse($request);
          // return redirect()->route('system_admin.index');
      } else {
          return abort(404);
      }
    }

    public function login(Request $request)
    {
        return view('system_admin.login');
    }

    public function logout()
    {
        if(Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        return redirect()->route('system_admin.login');
    }

    private string $add_message = '';
    private function fail_count_up(Admin $user)
    {
      if(is_null($user)){
      } else {
          $user->fail_count = $user->fail_count + 1;
          if($user->fail_count >= 3){
            $this->add_message = ':ロックしました';
          }
          $user->save();
      }
    }
}
