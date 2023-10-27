# Portfolio Laravel

## 🍀 About Portfolio Laravel

Porfolio Laravelはポートフォリオ用のLaravelプロジェクトです。
このプロジェクトは Laravel + Inertia.js + Vue.js によるモノリス且つモノレポ構成となっています。

## 📄 Design Doc

未制作

## 🛠️ 使用技術

### 環境

- サーバーサイド(PHP8, Laravel10)
- フロントエンド(JavaScript, Laravel Jetstream, jQuery, Laravel Inertia, ziggy)
- ダッシュボードフレームワーク(Tailwind UI)
- 開発開発(Docker, Laravel Sail)
- 本番環境インフラ(AWS)
- 本番環境ファイルストレージ(AWS S3)
- データベース(MySQL)
- キャッシュ(redis, genealabs/laravel-model-caching)
- エラー検知(Sentry)
- キューモニタリング（Laravel Horizon）
- 全文検索（MySQL FULLTEXT INDEX + protonemedia/laravel-cross-eloquent-search）

### テスト・解析

- 静的解析(Laravel Pint, phpcs, PHPMD, php intelephense, PHPStan(Larastan), tightenco/duster)
- バックエンド単体・統合テスト(Pest)
- フロントエンド単体・統合テスト(Pest)
- ブラウザテスト(Selenium, Laravel Dusk, Pest)
- CI/CD(GitHub Actions)
- API スキーマ定義(OpenAPI, Swagger, Laravel API Documentation Generator, Scribe)
- UI 検証(StoryBook & Chromatic - StoryBookホスティングサービス)
- 負荷テスト(Taurus)
- プロファイリング（Laravel XHProf）
- N+1チェック（Laravel preventLazyLoading function）
- ログビューワ（opcodesio/log-viewer）
- 開発用デバッグツール（Laravel Telescope, Clockwork）

### UX/UI

- CSSフレームワーク(Tailwind CSS, Tailwind UI)
- デザインツール(Figma, draw.io, PlantUML)
- SVGアイコン(tailwindlabs/heroicons)
- コンポーネント(daisyUI)
- Webアニメーション(Lottie.js, GSAP)
- フロントエンドコンポーネント管理(Storybook)
- ステートマシン（状態遷移）管理(asantibanez/laravel-eloquent-state-machines)

### SEO

- XMLサイトマップ（spatie/laravel-sitemap）

### Vue.js Library

- VueUse
- notiwind
- tailwindlabs/heroicons
- Sopamo/laravel-filepond
- Vue 3 Multiselect - vueform/multiselect

### Laravel Packages

- Laravel Sail
- Laravel Jetstream
- Laravel Inertia
- Laravel Telescope
- ziggy
- Clockwork
- DataTables
- bensampo/laravel-enum
- spatie/laravel-permission（ロールベースアクセス制御(RBAC)）
- lazychaser/laravel-nestedset（入れ子集合モデル）
- asantibanez/laravel-eloquent-state-machines（ステートマシン（状態遷移）管理）
- GeneaLabs/laravel-model-caching (Cache)

### その他ツール

- モジュールバンドラー(Vite)
- バージョン管理(Git/GitHub)
- タスク管理(ClickUp or redmine)
- コードエディタ(VSCode)
- 画面遷移図(guiflow, PlantUML)
- DB設計書・ER図(SchemaSpy, PlantUML)
- 商品お気に入り登録(Laravel Markable)
- ソーシャルログイン(Laravel Socialite)
- 入れ子集合モデル（lazychaser/laravel-nestedset）
- ロールベースアクセス制御(RBAC)（laravel-permission）
- APIドキュメント（knuckleswtf/scribe）

### Documents

- 画面遷移図: /documents/screen-transition-diagram.plantuml
- ER図: /documents/er-diagram.plantuml and http://localhost:8080 (SchemaSpy) （自動生成）
- API仕様書: http://localhost:8002 (SwaggerAPI) or http://localhost/docs (Scribe)（自動生成）、dedoc/scramble
- インフラ構成図: /documents/infra.plantuml

## 📐 ソフトウェア設計指針

### コーディング規約

- PHP - PSR-4、PSR-12に準拠

### アーキテクチャ

- DDDやクリーンアーキテクチャを参考に、UseCase層のみを用いた構成
(UserCase層については、app\Actionsディレクトリに格納)

#### 参考

- [5年間 Laravel を使って辿り着いた，全然頑張らない「なんちゃってクリーンアーキテクチャ」という落としどころ](https://zenn.dev/mpyw/articles/ce7d09eb6d8117)
- [LaravelのActionと使い方](https://www.fourier.jp/techblog/articles/how-to-use-laravel-action/)

## 🖥️ 環境構築

### gitの設定について

改行コードの自動変更はOFFにしておくこと

・改行コード変更コマンド
```
$ git config --global core.autocrlf false
```
・変更後の確認
```
$ git config --global -l
```

### git clone後

[Laravel Sailで作成したプロジェクトをGitHubリポジトリにpushして利用する](https://qiita.com/kai_kou/items/bfea0281689b3d376812)

### 起動
```
$ sail up -d
$ sail npm run dev
$ sail npm run storybook
```

### テスト用DB

```
$ cp .env .env.testing
```

.env.testing
```
- DB_HOST=mysql
+ DB_HOST=mysql.test
```

APP_KEYを生成する
```
$ sail artisan key:generate --env=testing
```

### 各種URL

- http://localhost
- http://localhost:8001 (Swagger Editor)
- http://localhost:8002 (SwaggerAPI)
- http://localhost:8025 (mailhog)
- http://localhost:8080 (SchemaSpy)
- http://localhost:9001 (Storybook)
- http://localhost/clockwork (Clockwork)
- http://localhost/telescope (Telescope)
- http://localhost/horizon (Horizon)
- http://localhost/log-viewer (log-viewer)
- http://localhost/docs (Scribe)

## 🍺 その他コマンド

基本は Makefile.example を参考に Makefile を作成してください。
Makefileはあくまでメモ程度にお考えください。

### Makefileとは

[【初心者向け】Makefile入門](https://qiita.com/mizcii/items/cfbd2aa17f6b7517c37f)

### Scribe
仕様書を生成（public/docs下に仕様書等が作成される）
```
$ ./vendor/bin/sail artisan scribe:generate
```

### SchemaSpy
DB設計書・RE図を生成（./schemaspy下に仕様書等が作成される）
```
$ ./vendor/bin/sail up schemaspy
```

#### 参考
- [【React/Vue.js】コンポーネント設計の（個人的）ベストプラクティス | Offers Tech Blog](https://zenn.dev/offers/articles/20220523-component-design-best-practice)
- [フロントエンドのコンポーネント設計において参考になる記事まとめ](https://zenn.dev/toshiyuki/articles/ea9fabc073ea0c)

### Laravel TypeScript

TypeScriptインターフェイスを生成します。
```
$ sail artisan typescript:generate
```

### 静的解析（Larastan(PHPStan)）
```
$ docker exec -it 20230622_curva-laravel.app-1 ./vendor/bin/phpstan analyse

or

$ make phpstan
```

#### 参考

[Laravelを使ったプロジェクトを始めるならLarastanくらいは導入しようよ](https://zenn.dev/bs_kansai/articles/4a476c4b28f1d6)

### Unitテスト
```
$ ./vendor/bin/sail artisan test
```

### ブラウザテスト

注意: Duskを実行する前にViteは停止してください。

```
$ ./vendor/bin/sail dusk
```
