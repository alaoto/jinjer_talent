## 環境構築

### 構成
Docker<br/>
サーバーNginx<br/>
PHPバージョン8.1.27<br/>
Laravelバージョン 10.48.4<br/>
Mysqlバージョン8.0.36<br/>

### ライブラリ
エクセルを操作できる<br/>
composer require maatwebsite/excel<br/>
API<br/>
composer require darkaonline/l5-swagger<br/>

### 環境構築
プロジェクトのrootで下記を実行（dockerをバッググラウンドで起動）<br/>
docker-compose up -d<br/>

### URL
http://localhost:80/<br/>

### mysqlにデータベースの追加を行う
docker exec -it jinjer_talent-db-1 bash<br/>
mysql -h 127.0.0.1 -P 3306 -u root -p<br/>
pass<br/>
create database jinjer_talent;<br/>

### マイグレーションの適用
docker exec -it jinjer_talent-app-1 bash<br/>
php artisan migrate<br/>
