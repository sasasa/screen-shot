<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Production;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendProductionMail;
use App\Services\IpService;
use App\Usecases\FindOrCreateUserByCookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ProductionLoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/production/create';
    protected function redirectTo()
    {
        return route('production.create');
    }

    public function login(Request $request, FindOrCreateUserByCookie $findOrCreateUserUseCase)
    {
        if($request->isMethod('get')) {
            $user = $findOrCreateUserUseCase($request->cookie('userid'), IpService::getIp($request), $request->header('User-Agent'));
            return view('production.login', [
                'users_sites' => $user->sites->pluck('id')->toArray(),
            ]);
        }
    }

    public function logout()
    {
        Auth::guard('production')->logout();
        return redirect()->route('sites.index')->with([
            'message' => 'ログアウトしました。',
            'status' => 'success',
        ]);
    }

    public function register(Request $request, FindOrCreateUserByCookie $findOrCreateUserUseCase)
    {
        if($request->isMethod('get')) {
            $user = $findOrCreateUserUseCase($request->cookie('userid'), IpService::getIp($request), $request->header('User-Agent'));
            return view('production.register', [
                'users_sites' => $user->sites->pluck('id')->toArray(),
            ]);
        }
        // POST されたときはバリデーションを行う
        $request->validate([
            'email' => 'required|email:strict,dns,spoof|max:100|unique:productions',
            'password' => 'required|regex:/^[!-~]{8,}+$/',
        ]);
        $production = Production::createWithUrl($request->all());
        Mail::to([
            'email' => $production->email,
        ])->send(new SendProductionMail($production));

        return redirect()->route('production.login')->with([
            'message' => 'ユーザー登録はまだ完了していません。メールアドレスに送信したURLにアクセスしてください。',
            'status' => 'success',
        ]);
    }

    public function confirm(Request $request, string $url)
    {
        $production = Production::where('register_url', $url)->first();
        if($production) {
            $production->confirm_at = now();
            $production->email_verified_at = now();
            $production->save();
            return redirect()->route('production.login')->with([
                'message' => 'ユーザー登録が完了しました。ログインしてください。',
                'status' => 'success',
            ]);
        } else {
            return abort(404);
        }
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
            return redirect()->back()->withErrors('Email・パスワードを入力してください。'. $this->add_message);
        }
        $user = Production::where('email', $email)->first();
        if(is_null($user)) {
            //ID正しくない
            return redirect()->back()->withErrors('Emailもしくはパスワードが違うためログインできません。');
        }
        if($user->fail_count >= 3){
            return redirect()->back()->withErrors('ログインエラー:ロックされています。');
        }
        if(!Hash::check($password, $user->password)) {
            $this->fail_count_up($user);
            return redirect()->back()->withErrors('Emailもしくはパスワードが違うためログインできません。'. $this->add_message);
        }
        if(!$user->confirm_at || !$user->email_verified_at) {
            return redirect()->back()->withErrors('ユーザー登録時に送信したURLにアクセスしてユーザー登録を完了してください。');
        }

        if(Auth::guard('production')->attempt([
            'email' => $email,
            'password' => $password,
        ])) {
            $user->fail_count = 0;
            $user->save();
            return redirect()->intended($this->redirectPath())->with([
                'message' => 'ログインしました。',
                'status' => 'success',
            ]);
        } else {
            return;
        }
    }

    private $add_message;
    private function fail_count_up(Production $user)
    {
        if(is_null($user)){
        } else {
            $user->fail_count = $user->fail_count + 1;
            if($user->fail_count >= 3){
                $user->lock_at = now();
                $this->add_message = ':ロックしました。';
            }
            $user->save();
        }
    }
}
