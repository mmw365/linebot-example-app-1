## このアプリケーションについて

送った言葉をそのまま送り返すシンプルなチャットボットです。

## 開発環境

以下の開発環境を想定しています。
- Windows
- Docker Desktop
- WSL2
- Ubuntu 22.04.01 LST (Composer, NPM インストール済み)

## 開発環境の設定

Ubuntu環境で下のコマンドの実行
- git clone https://github.com/mmw365/linebot-example-app-1.git
- cd linebot-example-app-1
- composer install
- npm install
- npm run dev

### 開発環境の起動
- ./vendor/bin/sail up -d

### 開発環境の終了
- ./vendor/bin/sail sail down