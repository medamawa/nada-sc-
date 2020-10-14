<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;
use App\Models\Post;

class PostController extends Controller
{
    public function index(Request $request, Club $club, Post $post)
    {
        // クラブIDを取得
        $name = $request->name;
        $club_id = $club->getId($name);

        // 投稿一覧を取得
        $posts = $post->getPosts($club_id);

        return view('club.n.post.index', ['name' => $name, 'posts' => $posts]);
    }

    public function create(Request $request)
    {
        return view('club.n.post.create', ['name' => $request->name]);
    }

    public function store(Request $request, Club $club, Post $post)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'body' => ['string'],
        ]);

        // ユーザーID、クラブ名を取得
        $user_id = auth()->user()->id;
        $name = $request->name;

        // クラブidを取得
        $club_id = $club->getId($name);

        // DBに登録
        $post->post($club_id, $user_id, $request->title, $request->body);

        return redirect(route('club.n.index', ['name' => $name]));
    }

    public function show($id)
    {
        //
    }
}
