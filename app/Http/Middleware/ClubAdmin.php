<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\Club;
use App\Models\Member;

class ClubAdmin
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

        // クラブ名を取得後、idを取得
        $club = new Club;
        $name = $request->route()->parameter('name');
        $club_id = $club->getId($name);

        // クラブの管理者(admin)がどうか確認、管理者であれば通す
        if (Member::where('club_id', $club_id)->where('user_id', $user_id)->value('isAdmin')) {
            return $next($request);
        }
            
        // 管理者(admin)でない場合はエラーコード403(認可エラー)を返す
        return abort(403);
    }
}
