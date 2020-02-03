# 儲值利息活動實作

## 說明

`依照平台會員昨日遊戲的點數進行儲值送利息活動。其利息每日凌晨結算，結算完畢後系統自動將儲值金額連同利息歸回至平台會員帳戶中。`

---

## 佈署步驟

### 機器所需環境

* 後端
    * PHP >= 7.2.0
    * BCMath PHP Extension
    * Ctype PHP Extension
    * JSON PHP Extension
    * Mbstring PHP Extension
    * OpenSSL PHP Extension
    * PDO PHP Extension
    * Tokenizer PHP Extension
    * XML PHP Extension
* 前端
    * Node >= 13.6.0
    * Npm >= 6.13.4
    * Yarn >= 1.21.1

---

### 複製設定檔範例並設定正確設定檔資訊(資料庫及Redis)

```
cp .env.example .env
vim .env
```

---

### 安裝後端所需套件

```
composer install
```

---

### 產生專案key

```
php artisan key:generate
```

---

### 產生資料表&系統初始資料

```
php artisan migrate
composer dump-autoload
php artisan db:seed
```


---

### 安裝前端套件並且執行 Build 動作

```
yarn install
yarn run production
```

---

### 需設定排程

```
crontab -e
// 將下面設定寫入至排程內存檔離開
* * * * * cd /path-to-your-project/bao && php artisan schedule:run >> /dev/null 2>&1
```

---

### 佈署完成，可開始網址瀏覽

```
// 網站自動導轉(測試用，正式上線需移除)
http://{網站Domain}/member/redirect?account={會員帳號}&platform={平台id}

// 後台
http://{網站Domain}/ctl/home
```

---

## 註記

* 網站需先`登錄`才能使用。
* 語系目前預設為 `簡中` 語系。
* 時區目前預設為 `UTC`，其畫面會自動將時間轉成 `UTC+8` 顯示。
* 其與平台串接API部分，目前暫時直接回傳資訊。
    * 需先確認與平台之間API合作模式。

