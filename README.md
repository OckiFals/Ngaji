# Ngaji Foundation 2.0.1

Requirement:

+ PHP 5.5 <=
+ AllowOverride All in apache.conf
+ short_open_tag=On in php.ini

## Manual penggunaan:

### 1. Definisikan web-app path(optional)**


   contoh: asumsikan url path untuk project adalah http://ockifals.dev/bisangaji
   maka ubah definisi app root pada index.php menjadi:
   
   
   ` define('HOSTNAME', '/bisangaji'); `
   
   
   Untuk versi ini, telah digunakan fungsi untuk mendapatkan nama master folder untuk project yang bersangkutan.
   Oleh karenanya mendefinisikan web-app path tidak lagi menjadi suatu keharusan(optional).
   
   
### 2. Ubah dan sesuaikan konfigurasi pada app/setting.php

File tersebut merupakan konfigurasi fundamental yang dimuat ketika aplikasi web dijalankan.

Konfigurasi database
-------------------------

```php
'db' => [
    'name' => 'nama_database',
    'host' => 'host db server, default: localhost',
    'user' => 'username akun',
    'pass' => 'password akun'
],
```

Daftarkan contoller atau user defined clas(optional)**
--------------------------------------------------------

Perlu diketahui bahwa class di daftarkan dengan full path

```php
'class' => [
    'Ngaji/Routing/Route.php',
    'app/Controllers/UstadzController.php'
    ...
```

Daftarkan model(optional)**
--------------------------

Model didaftarkan tanpa full path, tambahkan hanya nama filenya saja.

Misal terdapat model Ustadz di `/app/models/Ustadz.php`.
Untuk mendaftarkannya, tidak perlu menuliskan `'/app/models/Ustadz.php'` cukup hanya `'Ustadz'`

```
'models' => [
    'Ustadz',
    ...
```

Ketika model digunakan pada contoller, jangan lupa untuk memanggil model tersebut pada App namespace.

contoh:
pada baris controller paling atas tambahkan

```php
use app\models\Ustadz;
```

Sehingga:

```php
<?php namespace app\contoller;
use app\models\Ustadz;

class ControllerName extends Controller {

    ....

}
```
	
	
### 3. Sesuaikan route
   Ngaji/Routing/Route.php merupakan class yang bertugas mengarahkan request dari client. 
   Request tersebut akan ditentukan jalurnya dengan memanggil controller yang sesuai.


   Routing Path Format
   ---------------------

    Route statik:

        /post

    Route PCRE:

        /post/:id                  => cocok dengan /post/33

    Route PCRE dengan optional-pattern:

        /post/:id(/:title)         => cocok dengan /post/33, /post/33/post%20title
        /post/:id(\.:format)       => cocok dengan /post/33, /post/33.json .. /post/33.xml


   Menambahkan path route
   -----------------------

   Bentuk umum:

   `$mux->add('uri', ['Controller', 'action']/'Controller:action', [option]);`

   Berdasarkan HTTP method:

   + $mux->post('uri', ...)             => hanya menerima method POST
   + $mux->get('uri', ...)              => hanya menerima method GET
   + $mux->put('uri', ...)              => hanya menerima method PUT
   + $mux->delete('uri', ...)           => hanya menerima method DELETE
   + $mux->any('uri', ...)              => menerima semua method


   option:

   1. require digunakan untuk memverifikasi pola URI yang dibutuhkan

   `'require' => ['parameter' => 'pola preg_match']`

   2. default mendefinisikan nilai default dari parameter, jika parameter tidak didefinisikan

   `'default' => ['parameter' => nilai]`

   Contoh:

```php
$mux->add("/", ['app\controllers\ApplicationController', 'index']);
$mux->add("/test/:id", 'app\controllers\ApplicationController:test'], [
    'require' => ['id' => '\d+'],
    'default' => ['id' => 1]
]);
```

   NB:
   1. Jangan gunakan $_GET[] untuk mendapatkan data pada parameter prefix.
   Parameter tersebut secara otomatis dilemparkan ke action router yang bersangkutan.
      
      Contoh prefix `id` dengan filter '\d+'(integer)

### Methods

    - `Mux->add( {path}, {callback array or callable object}, { route options })`
    - `Mux->post( {path}, {callback array or callable object}, { route options })`
    - `Mux->get( {path}, {callback array or callable object}, { route options })`
    - `Mux->put( {path}, {callback array or callable object}, { route options })`
    - `Mux->any( {path}, {callback array or callable object}, { route options })`
    - `Mux->delete( {path}, {callback array or callable object}, { route options })`
    - `Mux->mount( {path}, {mux object}, { route options })`
    - `Mux->length()` returns length of routes.
    - `Mux->export()` returns Mux constructor via __set_state static method in php code.
    - `Mux->dispatch({path})` dispatch path and return matched route.
    - `Mux->getRoutes()` returns routes array.
    - `Mux::__set_state({object member array})` constructs and returns a Mux object.


### 4. Bekerja dengan Html helpers

   Html::Load()
   ------------
       
   Helper ini digunakan pada view untuk memuat file JS, CSS, dan image secara dinamis
       
   Bentuk umum:
   `<?= Html::load('[jenis-file]', '[path-file]') ?>`
       
   NB: jika file yang dipanggil terdapat pada direkroti default, maka tidak perlu menuliskan path secara lengkap
       
   Adapun direktori default yang diakui:
   + CSS: /assets/css
   + JS: /assets/js
   + IMG: /assets/img
       
       **4.1.1 Load CSS dan JS**
       Contoh 1, terdapat file style.css pada direktori default /assets/css
      	  
       `<?= Html::load('css', 'style.css') ?>`
      	  
       Contoh 2, terdapat file angular.js pada direktori /assets/dist/js.
       Untuk load gunakan full path(setelah assets) untuk file js tersebut
      	  
       `<?= Html::load('js', 'dist/js/angular.js') ?>`
       
       **4.1.2 Load image**

       Contoh 1: tanpa atribut
          
       `<?= Html::load('img', 'avatar.png') ?>`
          
       Kode diatas akan menghasilkan:
          
       `<img src="/[hostname-app]/assets/img/avatar.png"/>`

	    Contoh 2: dengan atribut

   ```php
   <?= Html::load('img', 'avatar.png', [
       'class' => 'user-image',
       'alt' => 'User Image'
   ])
   ?>
   ```
      	  
   Kode diatas akan menghasilkan:

   `<img src="/[hostname-app]/assets/img/avatar.png" class="user-image" alt="User Image"/>`

   Html::anchor()
   ---------------------------

   Helper ini digunakan pada view untuk membuat link anchor( a href )

   Bentuk umum:

   `<?= Html::anchor('/[path]', 'teks', [atribut:optional]) ?>`
      
   Contoh:

   ```php
   <?= Html::anchor('/login', 'Login Disini', [
       'class' => [
           'btn',
           'btn-default',
           'btn-flat'
       ]
   ])
   ?>
   ```

  Kode diatas akan menghasilkan:

  `<a href="/[hostname-app]/login" class="btn btn-default btn-flat">Login Disini</a>`

### 5. Bekerja dengan database

   Model::all()
   ------------

   Mengambil seluruh baris data dari suatu model

   Contoh:

```php
use app\models\Ustadz;
class Example extend Controller{
	public static function test{
		$data = Ustadz::all();
```

   Model::findOne()
   ----------------
   Mengambil satu baris data dengan criteria atau tanpa criteria
	
Mengambil satu data teratas**

```php
$data = Ustadz::findOne();
```
	
Mencari berdasarkan primary key**
	
```php
$data = Ustadz::findOne(2);
```
	
Mencari berdasarkan kriteria nilai tertentu**
	
```php
$data = Ustadz::findOne([
	'username' => 'subali'
]);
```
	
   Model::findAll()
   -----------------

Mengambil seluruh baris data dengan criteria atau tanpa criteria
	
Mencari berdasarkan kriteria nilai tertentu**
	
```php
$data = Ustadz::findAll([
	'type` => 1,
	'active' => 1
]);
```

Setara dengan:
	
```sql
SELECT ... FROM ... WHERE `type`=1 AND `active`=1
```
	
```php
$data = Ustadz::findAll([
	'type` => 1,
	'active' => [
		'!=` => 1
	]
]);
```

Setara dengan:

```sql
SELECT ... FROM ... WHERE `type`=1 AND `active`!=1
```

Mencari berdasarkan kriteria nilai tertentu**
```php
$data = Ustadz::findOne([
	'username' => 'subali'
]);
```

Menyimpan record baru
----------------------
	
