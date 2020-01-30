# 佈署步驟

## 機器所需環境

* PHP >= 7.2.0
* BCMath PHP Extension
* Ctype PHP Extension
* JSON PHP Extension
* Mbstring PHP Extension
* OpenSSL PHP Extension
* PDO PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* Node >= 13.6.0
* Npm >= 6.13.4
* Yarn >= 1.21.1

---

## 複製設定檔範例並設定正確設定檔資訊

```
cp .env.example .env
vim .env
```

---

## 安裝 Composer

```
composer install
```

---

## 產生專案key

```
php artisan key:generate
```

---

## 產生資料表&系統初始資料

```
php artisan migrate
composer dump-autoload
php artisan db:seed
```


---

## 安裝 Npm 套件並Build

```
yarn install
yarn run production
```

---

## 設定排程

```
crontab -e
// 將下面設定寫入至排程內存檔離開
* * * * * cd /path-to-your-project/bao && php artisan schedule:run >> /dev/null 2>&1
```
