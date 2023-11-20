# Portfolio Laravel

## 🍀 About Portfolio Laravel

Porfolio Laravelはポートフォリオ用のLaravelプロジェクトです。<br>
このプロジェクトは Laravel + Inertia.js + Vue.js によるモノリス且つモノレポ構成となっています。

## 📄 Design Doc

- 🏁 [概要](/docs/design-docs/overview.md)
- 📐 [ソフトウェア設計指針](/docs/design-docs/design-guidelines.md)
- 🖥️ [環境構築](/docs/design-docs/installation.md)
- 🏷️ [テスト](/docs/design-docs/test.md)
- 🚚 [CI/CD](/docs/design-docs/cicd.md)

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

- 静的解析(Laravel Pint, phpcs, PHPMD, php intelephense, PHPStan(Larastan), tightenco/duster, ESLint, Prettier)
- バックエンド単体・統合テスト(Pest)
- フロントエンド単体・統合テスト(Pest)
- ブラウザテスト(Selenium, Laravel Dusk, Pest)
- CI/CD(Git hooks, GitHub Actions)
- API スキーマ定義(OpenAPI, Swagger, Laravel API Documentation Generator, Scribe)
- UI 検証(StoryBook & Chromatic - StoryBookホスティングサービス)
- 負荷テスト(Taurus, Stressless(Pest Plugin))
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
- APIドキュメント（knuckleswtf/scribe, dedoc/scramble）

### Documents

- 画面遷移図: /docs/screen-transition-diagram.plantuml
- ER図: /docs/er-diagram.plantuml and http://localhost:8080 (SchemaSpy) （自動生成）
- API仕様書: http://localhost:8002 (SwaggerAPI) or http://localhost/docs (Scribe, dedoc/scramble)（自動生成）
- インフラ構成図: /docs/infra.plantuml
