# 飲食店予約アプリ　Diningnavi

会員登録なしでも閲覧は可能ですが、飲食店を予約をする場合は会員登録が必要。<br>
氏名、メールアドレス、パスワードを入力、登録し、そのメールアドレスに届く確認メールを開き、<br>
メールアドレスとパスワードを入力しログインします。<br><br>
![ログイン画面](README/images/login.png)<br>
![ホーム画面](README/images/home.png)

## 作成した目的
ごちゃごちゃと煩雑でなく見やすいページ構成で、必要な機能のみで操作も簡単、<br>
そしてもっと手軽に飲食店を予約できるアプリがあればいいな、と思い開発しました。<br>


## アプリケーションURL
http://15.168.189.188(現在閲覧不可)

## 機能一覧
#### 管理画面 : ユーザー、管理者、店舗代表者の3つの権限でそれぞれ異なる機能にアクセス可能。
   - **ユーザー** : [会員登録](http://localhost/user/register)<br>
     ※メール認証を通じて安全なログイン・ログアウト機能を提供。
   - **管理者** : [管理者ログイン](http://localhost/admin/login)
   - **店舗代表者** : [店舗代表者登録](http://localhost/shop_owner/register)<br>
    ※ 管理者が登録する場合と自分自身で登録する場合の2パターンが想定されます。

#### 飲食店情報 : 飲食店の一覧や詳細表示、ログインユーザーはそこからお気に入りへの追加や予約が可能。

#### ユーザー機能 : お気に入りの飲食店や予約情報をマイページにてまとめて表示。
   - 予約日時や人数を簡単に変更できる予約変更機能。
   - 利用したお店を5段階で評価し、コメントを投稿することが可能。
   - レビュー評価とは別に「口コミ」機能を追加、表示中の店舗だけでなく全店舗の口コミを閲覧可能に。

#### 管理者機能 : 管理者は店舗代表者の登録、管理、削除が行え、CSVファイルを使って店舗情報を一度に登録が可能。

##### CSVファイルの記述方法
[CSVインポート](http://localhost/admin/csv_import)<br>
- **name** : 店舗名（最大50字）
- **intro** : 店舗紹介文（最大400字）
- **image_url** : アップロードしたい画像のURL
- **area** : 「東京都」「大阪府」「福岡県」のいずれか
- **genre** : 「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれか を下記２パターンのどちらかの形式で入力する。

- **1.ExcelやGoogle Sheetsで「表形式」に入力し、CSVとして保存**
- **2.テキストエディタ（VSCodeなど）で「カンマ区切り形式」を直接記述して保存**

##### 1.ExcelやGoogle Sheetsで作成した「表データ」の場合
| name      | intro                   | image_url                                   | area      | genre   |
|-----------|-------------------------|---------------------------------------------|-----------|-----------|
| イタリアンC | 美味しいパスタが人気です    | https://localhost/storage/images/Italian.jpg | 福岡県    | イタリアン |
| 居酒屋D    | お酒が豊富です            | https://localhost/storage/images/izakaya.jpg  | 東京都    | 居酒屋    |
| 魚の宝     | 新鮮な魚を提供する寿司店    | http://localhost/storage/images/sushi.jpg     | 東京都    | 寿司      |
| 焼肉大将   | 美味しい焼肉が楽しめるお店   | http://localhost/storage/images/yakiniku.jpg  | 大阪府    | 焼肉     |

##### 2.テキストエディタで「カンマ区切り形式」(手動入力）の場合
name,area,genre,intro,image_url<br>
イタリアンC,福岡県,イタリアン,美味しいパスタが人気です,https://localhost/storage/images/Italian.jpg<br>
居酒屋D,東京都,居酒屋,お酒が豊富です,https://localhost/storage/images/izakaya.jpg<br>
魚の宝,東京都,寿司,新鮮な魚を提供する寿司店,http://localhost/storage/images/sushi.jpg<br>
焼肉大将,大阪府,焼肉,美味しい焼肉が楽しめるお店,http://localhost/storage/images/yakiniku.jpg

##### CSVファイルの保存方法
1. **ExcelやGoogle Sheetsの場合**:
   - 「ファイル」→「名前を付けて保存」→「CSV UTF-8（カンマ区切り）(*.csv)」
   - **Google Sheetsの場合**: 「ファイル」→「ダウンロード」→「カンマ区切りの値（.csv）」
2. **テキストエディタ（VS Codeなど）を使用する場合**:
   - カンマ区切り形式でデータを記述後、**UTF-8エンコード**で保存。

保存したCSVファイル（例:`Book1.csv`）をインポート画面にアップロードすることで、店舗情報を一括で登録が可能。

##### 注意事項
- **エンコード**: CSVファイルは**UTF-8エンコード**で保存。異なるエンコードの場合、インポート時にエラーが発生する可能性があり。
- **画像URL**: 画像URLには、オンラインでアクセス可能な画像のURLを記載すること。

#### 店舗代表者機能 : 店舗情報の作成・更新・削除が可能。予約情報をまとめて表示し、利便性を向上。
   - **ストレージ** : お店の画像をストレージに保存可能。
     [ストレージ機能](http://localhost/shop_owner/shops/image_upload)
   - **メール送信** : 登録顧客にお知らせメールを送信。
     [メール配信機能](http://localhost/emails/user_send_mail.blade.php)
   - **リマインダー** : 予約当日AM9:00にお知らせメールを送信。
     [リマインダー機能](http://localhost/emails/reminder.blade.php)<br>
     ※`php artisan reminder:send`コマンドを実行するとテストが可能です。

- **メール機能のテスト** : MailHogを使用して、ローカル環境でメール送信のテストが可能です。
   - メールの送信内容は、ブラウザで以下のURLから確認できます。
     [MailHogインターフェース](http://localhost:8025)

- **QRコード機能** : 予約成立時に確認メールを送信し、QRコードを貼付。店舗側に見せて照合が可能。

- **決済機能** : Stripeを使用、マイページの予約状況内で「先に決済する」から実行が可能。
   - [Stripe決済](http://localhost/views/create.blade.php)
   ※セキュリティを考慮し、StripeのPUBLIC_KEY、SECRET_KEYは.env.local、.env.prod共に基本設計書下に記載しています。
    また、`.env.prod`ファイル内のAWSの`ID`と`KEY`も同様に記載しています。

- **デザイン** : レスポンシブデザインを導入し、タブレット・スマートフォン向けに768pxで対応。

#### 注意事項
※店舗代表者としてログインしないと、以下の機能にはアクセスできません！
  - ストレージ機能
  - メール配信機能
  - リマインダー機能
  - QRコード機能
  - 決済機能

## 使用技術
  - Laravel Framework :Ver 8.83.27

  - PHP :Ver 8.3.12

  - mysql :Ver 8.0.26

  - HTML、CSS

  - JavaScript

## テーブル設計
![テーブル](README/images/table.png)

## ER図
![ER図](README/images/ER.png)

## 環境構築　
このプロジェクトをDockerを使用し、ローカルで動作させるための手順です。<br>
**Dockerビルド**<br>
1. `git clone git@github.com:Otsumu/Diningnavi.git`<br>
2. DockerDesktopアプリを立ち上げる<br>
3. `docker-compose up -d --build`<br>

**Laravel環境構築**<br>
このプロジェクトをDockerを使用し、ローカルで動作させるための手順です。<br>
　1.　リポジトリのクローン git clone https://github.com/Otsumu/Diningnavi.git<br>
　2.　ディレクトリに移動 cd Diningnavi<br>
　3.　Dockerコンテナのビルドと起動 docker-compose up --build -d<br>
　4.　PHPコンテナ内に入る docker-compose exec php bash<br>
　5.　依存関係のインストール composer install<br>
　6.　環境ファイルの作成 cp .env.example .env<br>
　7.　データーベースの設定 nano .env<br>
　8.　アプリケーションキーの生成 php artisan key:generate<br>
　9.　データーベースのマイグレーション php artisan migrate<br>
　10. シーディングの実行　php artisan db:seed<br>
　11. アプリケーションへのアクセス http://localhost
