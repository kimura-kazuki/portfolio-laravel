# 🖥️ 環境構築 - Installation

## git clone後

[Laravel Sailで作成したプロジェクトをGitHubリポジトリにpushして利用する](https://qiita.com/kai_kou/items/bfea0281689b3d376812)

## 起動
```
$ sail up -d
$ sail npm run dev
$ sail npm run storybook
```

## テスト用DB

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

## gitの設定について

改行コードの自動変更はOFFにしておくこと

・改行コード変更コマンド
```
$ git config --global core.autocrlf false
```
・変更後の確認
```
$ git config --global -l
```

## チームで共通のGit hookを使う

参考： https://www.farend.co.jp/blog/2020/04/git-hook/

.githooksディレクトリをHooksのコアディレクトリに指定
```
$ git config --local core.hooksPath .githooks
```

## コミットメッセージ

コミットメッセージには、「見出し」「チケット番号」「作業時間」を記入してください。<br>
例） Add: :construction_worker: git hooksスクリプトを追加 #1 @0.1h<br>
詳しくは .githooks/commit-msg を参照

## 各種URL

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

Makefileを参考にしてください。
Makefileはあくまでメモ程度にお考えください。

### Makefileとは

[【初心者向け】Makefile入門](https://qiita.com/mizcii/items/cfbd2aa17f6b7517c37f)

## Scribe
仕様書を生成（public/docs下に仕様書等が作成される）
```
$ ./vendor/bin/sail artisan scribe:generate
```

## SchemaSpy
DB設計書・RE図を生成（./schemaspy下に仕様書等が作成される）
```
$ ./vendor/bin/sail up schemaspy
```

## Laravel TypeScript

TypeScriptインターフェイスを生成します。
```
$ sail artisan typescript:generate
```
