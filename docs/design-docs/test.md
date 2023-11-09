# 🏷️ テスト - Test

## 静的解析（Larastan(PHPStan)）
```
$ docker exec -it 20230622_curva-laravel.app-1 ./vendor/bin/phpstan analyse

or

$ make phpstan
```

### 参考

[Laravelを使ったプロジェクトを始めるならLarastanくらいは導入しようよ](https://zenn.dev/bs_kansai/articles/4a476c4b28f1d6)

## Unitテスト
```
$ ./vendor/bin/sail artisan test
```

## ブラウザテスト

注意: Duskを実行する前にViteは停止してください。

```
$ ./vendor/bin/sail dusk
```

## JavaScript静的解析 (ESlint)

```
$ ./vendor/bin/sail npm run lint
```

## JavaScriptフォーマッター (Prettier)

```
$ ./vendor/bin/sail npm run format
```
