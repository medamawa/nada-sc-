<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ActivationCreated;
use App\Models\AccessKey;
use App\Models\Activation;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Ramsey\Uuid\Uuid;

class RegisterController extends Controller
{
    private $now;
    protected $accessKey;

    public function __construct(AccessKey $accessKey)
    {
        $this->middleware('guest');
        $this->now = Carbon::now()->format('Y-m-d H:i:s');
        $this->accessKey = $accessKey;
    }

    /**
     * 登録リクエストを受付
     *
     * @param  Request
     * @return void
     */
    public function register(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', Rule::unique('users')],
            'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
        ]);

        $this->createActivation($request);

        return response()->json(['msg' => 'success']);
    }

    /**
     * アクティベーションコードを生成して認証コードをメールで送信
     *
     * @param  Request
     * @return void
     */
    private function createActivation(Request $request)
    {
        $activation = new Activation;
        $activation->student_code = $request->student_code;
        $activation->user_name = $request->name;
        $activation->class = $request->class;
        $activation->email = $request->email;
        $activation->password = bcrypt($request->password);
        $activation->code = Uuid::uuid4();
        $activation->save();

        Mail::to($activation->email)->send(new ActivationCreated($activation));
    }

    /**
     * メール認証コードを検証してユーザー情報の登録
     *
     * @param  Request
     * @return string
     */
    public function verify(Request $request)
    {
        $code = $request->code;

        // 認証確認
        if (!$this->checkCode($code)) {

            return response()->json(['msg' => 'failed']);
        } else {
            // ユーザー情報の登録
            DB::beginTransaction();
            try {
                $activation = Activation::where('code', $code)->first();
                
                $user = new User();
                $user->student_code = $activation->student_code;
                $user->user_name = $activation->user_name;
                $user->class = $activation->class;
                $user->email = $activation->email;
                $user->password = $activation->password;
                $user->save();
                Activation::where('code', $code)->update(['email_verified_at' => Carbon::now()]);

                DB::commit();
                return response()->json(['msg' => 'success']);
            } catch (\Exception $e) {
                DB::rollBack();

                return response()->json(['msg' => 'failed!', 'error' => $e]);
            }
        }
    }

    /**
     * メール認証コードの検証
     *
     * 1. 与えられた認証コードがActivations.codeに存在するか？
     * 2. users.emailが存在し、ユーザー登録が既に完了しているメールアドレスかどうか？
     * 3. 認証コード発行後1日以内に発行された認証コードであるか？
     * 
     * @param  string $code - メール認証のURLパラメータから取得する認証コード
     * @return boolean
     */
    private function checkCode($code)
    {
        $activation = Activation::where('code', $code)->first();
        if (!$activation) {
            return false;
        }

        $activation_email = $activation->email;
        $latest = Activation::where('email', $activation_email)->orderBy('created_at', 'desc')->first();
        $user = User::where('email', $activation_email)->first();
        $activation_created_at = Carbon::parse($activation->created_at);
        $expire_at = $activation_created_at->addDay(1);
        $now = Carbon::now();

        return $code == $latest->code && !$user && $now->lt($expire_at);
    }
}
