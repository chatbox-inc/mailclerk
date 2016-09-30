これはメールテスト送信用に送付されているメッセージです。

サンプルとして、Connpass から直近の勉強会情報をお知らせします。

<ul>
    @foreach($events as $event)
        <li>
            <a href="{{$evnet["event_url"]}}">{{$evnet["title"]}}</a>
        </li>
    @endforeach
</ul>
