<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\Club;
use App\Models\Member;

class CheckClubIsOk
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // ログインユーザーのidを取得
        $user_id = auth()->user()->id;
        
        // クラブ名を取得
        $name = $request->route()->parameter('name');
        
        // クラブが存在するかどうか確認
        if (Club::where('name', $name)->exists()) {

            // クラブidを取得
            $club = new Club;
            $club_id = $club->getId($name);

            // クラブに所属しているかどうか確認、所属していれば通す
            if (Member::where('club_id', $club_id)->where('user_id', $user_id)->exists()) {
                return $next($request);
            }

            // クラブに所属していない場合はエラーコード403(認可エラー)を返す
            // TODO: エラーコードで詳細がわかるように改善
            return abort(403);
        }

        // クラブが存在しなければエラーコード404を返す
        // TODO: 分かりやすいように変更する
        return abort(404);
    }
}
