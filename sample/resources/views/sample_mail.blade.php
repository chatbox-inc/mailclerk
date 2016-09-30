これはメールテスト送信用に送付されているメッセージです。

サンプルとして、Connpass から直近の勉強会情報をお知らせします。

<ul>
    @foreach($events as $event)
        <li>
            <a href="{{$event["event_url"]}}">{{$event["title"]}}</a>
        </li>
    @endforeach
</ul>
