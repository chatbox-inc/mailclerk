# メール送信周りの諸処理

Laravel 5.3 対応

Sendableに対する対応を追加。

- MailClerk によるキュー自動切り替えのサポート
- Transportの追加

## Usage

サービス・プロバイダとして登録

````
$app->register(\Chatbox\MailClerk\MailClerkServiceProvider::class);
````

内部で`mail`設定を読み込み。  
`MailServiceProvider`の自動セットアップに加え、`MailClerk`クラスをコンテナに登録。

さらに拡張Transportとして、以下のDriverを追加

- array: テスト用の揮発性配列メーラ
- sendgrid: Sendgridによる送信サービス
- slack: Slackへのメール投稿

### MailClerk

`publish`メソドでメールを配信。

内部のprotected関数を操作しキューの利用を切り替える事ができる。
