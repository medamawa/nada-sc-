@component('mail::message')

@if (!@empty($user_name))
{{ $user_name }}さん
@endif


** 以下の認証リンクから認証を完了して下さい **
@component('mail::button', ['url' => $url])
メールアドレスを認証する
@endcomponent


@if (!empty($url))
###### 「メールアドレスを認証する」ボタンをクリックできない場合は、下記のURLをコピーしてWebブラウザに貼り付けて認証して下さい。
###### {{ $url }}
@endif

---

※もしこのメールに覚えがない場合は破棄して下さい。

---

Thanks,<br>
{{ config('app.name') }}
@endcomponent
