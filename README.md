<h1 align="center">Gudang Film Web App</h1>
<p align="center">
  <img alt="Coding" width="400" src="public/gudangfilm-logo.png">
</p>
<h2 id="description">Description </h2>

Gudang Film adalah aplikasi web di mana pengguna dapat membeli dan menonton film favorit mereka. Aplikasi ini menawarkan daftar film yang tersedia untuk dibeli, dengan berbagai genre, termasuk Aksi, Horor, Romansa, dan banyak lainnya. Aplikasi ini juga berfungsi sebagai platform streaming, memungkinkan pengguna untuk menonton film segera setelah membelinya.

Aplikasi web ini dilengkapi dengan fitur otentikasi yang menggunakan otentikasi berbasis token dengan token JWT. Selain itu, terdapat fitur WishList bagi pengguna yang ingin menandai film untuk pembelian atau penayangan di masa depan, fitur penilaian agar pengguna dapat menilai kualitas film berdasarkan pendapat publik, dan fitur komentar yang memungkinkan pengguna untuk berdiskusi tentang film satu sama lain.

<h2 id="table-of-contents">Table of Contents</h2>
- <a href="#description">Description</a><br/>
- <a href="#table-of-contents">Table of Contents</a><br/>
- <a href="#tech-stack">Tech Stack</a><br/>
- <a href="#how-to-run">How To Run</a><br/>
- <a href="#design-pattern">Design Patterns</a><br/>
- <a href="#endpoints">Endpoints</a><br/>
- <a href="#bonus">Bonus</a><br/>
- <a href="#author">Author</a><br/>

<h2 id="tech-stack">Tech Stack</h2>

- Laravel Framework 11.20.0
- Vite @5.4.0
- Tailwind CSS @3.4.9
- SQLite

<h2 id="how-to-run">How To Run</h2>

1. <b>With Docker</b>
- Clone this repository
```
git clone https://github.com/chankiel/Tucil3_13522029
```

- Go to the directory where you cloned this repository
```
cd path/to/this/repo
```

- Copy the '.env.example' file to '.env' if it exists
```
cp .env.example .env
```

- Create the database.sqlite file
```
New-Item -Path "database/database.sqlite" -ItemType "File"
```

- Build and start Docker Containers
```
docker-compose up --build
```

- Generate application key
```
docker-compose exec app php artisan key:generate
```

- Run database migrations  
```
docker-compose exec app php artisan migrate
```

- Seed the database
```
docker-compose exec app php artisan db:seed
```

- Install Node.js Dependencies and Run Vite assets
```
docker-compose exec app npm install
docker-compose exec app npm run dev
```

- Access the Application at http://localhost:8000 or http://127.0.0.1:8000

<hr>
2. <b>With Artisan and npm</b>  

- Clone this repository
```
git clone https://github.com/chankiel/Tucil3_13522029
```

- Go to the directory where you cloned this repository
```
cd path/to/this/repo
```

- Run this command to create the database.sqlite file
```
New-Item -Path "database/database.sqlite" -ItemType "File"
```

- Install dependencies with Composer and npm
```
npm install
composer install
```

- Run migration and seeding for the database
```
php artisan migrate:fresh  
php artisan db:seed
```

- Run vite build command to build the frontend assets
```
npm run build
```

- Run php command to run the web app
```
php artisan serve
```

- Your web app should be running at your localhost. Visit localhost:8000 or 127.0.0.1:8000
```
http://127.0.0.1:8000  
or  
http://localhost:8000
```

<h2 id="design-pattern">Design Patterns</h2>

1. <h3>Creational Patterns</h3>  

   - Factory Pattern (UserFactory Class)    
   Class UserFactory, yang mewarisi kelas Factory Laravel untuk menghasilkan instance model. Model dibuat di kelas Factory, tetapi User Factory yang merupakan subclass, mengubah tipe objek yang dibuat, yang dalam hal ini adalah User. 
      ```php
      /**
       * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
      */
      class UserFactory extends Factory
      ```

   - Builder Pattern (Query Builder)  
Pola query builder Laravel memungkinkan konstruksi query SQL dengan cara yang lancar dan fleksibel. Ini menyediakan cara untuk membangun query kompleks dengan interface yang sederhana.
      ```php
      $query = $request->input('search');
      if ($query) {
         $query = strtolower($query);
         $filmQuery->whereRaw('LOWER(title) LIKE ?', ["%{$query}%"])
               ->orWhereRaw('LOWER(director) LIKE ?', ["%{$query}%"]);
      }
      return $filmQuery->paginate($qtyFilm);
      ```

2. <h3>Structural Patterns </h3> 

   - MVC (Model-View-Controller)     
   Pola MVC adalah pola struktural, yang mengorganisir aplikasi menjadi tiga komponen yang saling terhubung (Model, View, Controller) untuk separation concerns dan mengelola kompleksitas.

## Endpoints
### Monolith
#### Frontend Web App Route
|Endpoint|Deskripsi|Body|Param|Query|
|---|---|---|---|---|
|GET ```/```|Tampilan home, berisi list films dengan pagination|-|-|-|
|GET ```/login```|Mendapatkan page login|-|-|-|
|GET ```/register```|Mendapatkan page register|-|-|-|
|GET ```/myfilms```|Mendapatkan page daftar film yang sudah dibeli|-|-|-|
|GET ```/wishlist```|-|-|-|-|
|GET ```/films/:slug```|Film detail page|-|```slug```|-|

#### Backend Web App Route
|Endpoint|Deskripsi|Body|Param|Query|
|---|---|---|---|---|
|POST ```/add-user```|Menambah pengguna baru|-|-|-|
|POST ```/login-be```|Menghandle request login dari pengguna|-|-|-|
|POST ```/logout-be```|Menghandle request logout dari pengguna|-|-|-|
|POST ```/buy-film/:id```| Menghandle request pembelian film pengguna dari pengguna|-|```id film```|-|
|POST ```/wish-film/:id```| Menghandle request penambahan film ke wishlist pengguna-|```id film```|-|
|DELETE ```/unwish-film/:id```| Menghandle request penghapusan film dari wishlist pengguna|-|```id film```|-|
|POST ```/rate-film/:id/:rating```|Menghandle request pemberian rating film dari pengguna|-|```id film```,```rating```|-|
|POST ```/comment-film/:id```|Menghandle request pemberian komentar film dari pengguna|```comment```|```id film```|-|

#### API
|Endpoint|Deskripsi|Body|Param|Query|
|---|---|---|---|---|
|GET ```/films```|Mendapatkan list semua films|-|-|Sesuai spesifikasi|
|POST ```/films```|Menambahkan film baru|Sesuai spesifikasi|-|-|
|GET ```/films/:id```|Mendapatkan film berdasarkan id film|-|```id film```|-|
|PUT ```/films/:id```|Update film sesuai id|Sesuai spesifikasi|```id film```|-|
|DELETE ```/films/:id```|Hapus film sesuai id|Sesuai spesifikasi|```id film```|-|
|GET ```/users```|Mendapatkan semua user|-|-|-|
|GET ```/users/:id```|Mendapatkan user sesuai id|-|```id user```|-|
|POST ```/users:id/balance```|Update balance user|```increment```|```id user```|-|
|DELETE ```/users/:id```|Menghapus user sesuai id|-|```id user```|-|
|POST ```login```|Melakukan login untuk admin|```username```, ```email```|-|-|
|GET ```/api/self```|Mendapatkan data admin|-|-|-|

## Bonus

### B06 - Responsive Layout
Aplikasi ini sudah dibuat responsive sesuai dengan ukuran layar perangkat pengguna

### B08 - SOLID
Aplikasi ini menggunakan konsep SOLID dalam pembuatan design class. Beberapa class pada project ini adalah sebagai berikut.

#### 1. Helper  
   Helper Class adalah class yang berisi metode-metode pembantu yang dibutuhkan pada class-class lain
#### 2. Controlers  
   Class Controlers bertanggung jawab untuk menerima request, memproses request tersebut dengan bantuan Model ataupun kelas lain, dan mengembalikan response yang sesuai  
#### 3. Middleware  
   Class Middleware bertanggung jawab sebagai 'filter' untuk request sebelum mencapai logic dari aplikasi. Disini dilakukan penyaringan request berdasarkan Authentication dan Authorization dari pengirim request dan request itu sendiri.
#### 4. Request
   Class Request berfungsi untuk melakukan penyaringan request setelah melalui middleware. Penyaringan disini bersifat spesifik terhadap resource yang ingin dilakukan operasi, seperti rules terhadap request body, dll.
#### 5. Resources
   Class Resources berfungsi untuk mengatur bentuk response JSON yang dikembalikan oleh API  
#### 6. Models
   Class Models mewakili entity atau row pada table database. Class Models berisi definisi dari suatu model dan business logic dari model tersebut.  
#### 7. Rules
   Class Rules berisi rule spesifik terhadap suatu attribut request yang kemudian akan digunakan pada Class Request. Penggunaan class ini agar dapat lebih leluasa dan fleksibel terhadap pemeriksaan attribut dan request dan pesan error yang dikembalikan
#### 8. Migrations
   Class Migrations berisi definisi tabel pada database, yang kemudian dijalankan untuk membangun definisi tersebut pada database.
#### 9. Factories
   Class Factory digunakan untuk membentuk suatu instance pada Model (umumnya instance dummy untuk seeding), yang dimana pada class ini dapat didefinisikan tiap-tiap attribut user yang akan dibentuk. Umumnya class ini digunakan pada Seeder.
#### 10. Seeder
   Class Seeder digunakan untuk melakukan operasi seeding terhadap database. Class ini berisi deretan instruksi seeding yang umumnya berupa aplikasi dari factory yang didefinisikan terhadap model tersebut.
#### 11. Views
   Views merupakan komponen projek yang bertanggung jawab terhadap tampilan frontend dari web app. Pada laravel, bentuk dari Views ini merupakan blade templating engine.
#### 12. Routes
   Routes merupakan komponen projek yang berfungsi untuk menerima request dari pengguna. Request yang diterima ini kemudian dihantarkan kepada Controller yang bersangkutan.

### B10 - Fitur Tambahan
Terdapat beberapa fitur tambahan pada aplikasi ini antara lain, yaitu

#### 1. Wishlist
Fitur Wishlist yang memungkinkan pengguna untuk menambahkan film yang mereka minati ke dalam daftar Wishlist mereka. Pengguna dapat melihat dan mengelola daftar Wishlist mereka pada halaman terpisah. Fitur ini dapat membantu pengguna untuk menyimpan film yang ingin mereka beli atau tonton nanti. 

#### 2. Fitur Rating dan Review
Pengguna dapat memberikan rating terhadap suatu film, misal bintang 1-5. Selain rating, terdapat juga fitur review atau menambahkan komentar terkait film tersebut. Pengguna tentu dapat melihat rating dan review dari pengguna lainnya.

### B11 - Ember
Projek ini menggunakan Amazon S3 Bucket sebagai cloud storage untuk penyimpanan cover image dan video dari film.


<h2 id="author">Author</h2>
<pre>
  Name  : Ignatius Jhon Hezkiel Chan
  NIM   : 13522029
  Email : <a href="mailto:13522029@std.stei.itb.ac.id">13522029@std.stei.itb.ac.id</a>
</pre>