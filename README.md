<h1 align="center">Gudang Film Web App</h1>
<p align="center">
  <img alt="Coding" width="400" src="public/gudangfilm-logo.png">
</p>
<h2 id="description">Description </h2>

Gudang Film is a web app where users can purchase and watch their favorite films. The app offers a list of films available for purchase, with a variety of genres, including Action, Horror, Romance, and many others. This app also serves as a streaming platform, allowing users to watch films immediately after purchasing them.

The web app is equipped with an authentication feature that uses token-based authentication with JWT tokens. It also includes a WishList feature for users who want to bookmark a film for future purchase or viewing, a rating feature so users can gauge the quality of a film based on public opinion, and a commenting feature that enables users to discuss films with each other.

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

1. <b>With Docker</b> (not working)
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

1. <h3>Structural Patterns</h3>  
   - Factory Pattern (UserFactory Class)    
   Class UserFactory, yang mewarisi kelas Factory Laravel untuk menghasilkan instance model. Model dibuat di kelas Factory, tetapi User Factory yang merupakan subclass, mengubah tipe objek yang dibuat, yang dalam hal ini adalah User. 
    - Builder Pattern (Query Builder)  
Pola query builder Laravel memungkinkan konstruksi query SQL dengan cara yang lancar dan fleksibel. Ini menyediakan cara untuk membangun query kompleks dengan interface yang sederhana.

2. Structural Patterns  
   - MVC (Model-View-Controller)  
Pola MVC adalah pola struktural, yang mengorganisir aplikasi menjadi tiga komponen yang saling terhubung (Model, View, Controller) untuk separation concerns dan mengelola kompleksitas.

<h2 id="endpoints">Endpoints</h2>

1. <b>Web App Endpoints </b> 
   - GET "/"  
   Tampilan home, berisi list films dengan pagination
   - GET "/films/:slug"
   Tampilan detail film, berisi deskripsi lengkap dari film yang bersangkutan, yakni judul, deskripsi, director, tahun rilis, durasi, genres, dan harga film. User disini dapat membeli film, menambahkan ke wishlist, memberi rating, menonton film (jika sudah membeli), dan juga memberikan komentar terkait film tersebut  
   - GET "/myfilms"  
   Tampilan film yang dimiliki pengguna. Berisi daftar film yang telah dibeli oleh pengguna  
   - GET "/wishlist"  
   Tampilan wishlist pengguna, berisi daftar film yang telah ditandai sebagai bagian dari wishlist pengguna (baik yang sudah dibeli ataupun belum)  
   - GET "/register"
   Tampilan register, berisi tampilan pendaftaran pengguna baru, dengan input berupa username, email, firstname, lastname, dan password calon pengguna.  
   - GET "/login"  
   Berisi tampilan login pengguna dengan input berupa username / email dan password.
   - POST "/add-user"  
   Route logic BE untuk menambah pengguna baru  
   - POST "/login-be"  
   Route logic BE untuk menghandle request login dari pengguna
   - POST "/logout-be"  
   Route logic BE untuk menghandle request logout dari pengguna
   - POST "/buy-film/{film}"  
   Route logic BE untuk menghandle request pembelian film pengguna
   - POST "/wish-film/{film}"  
   Route logic BE untuk menghandle request penambahan film ke wishlist pengguna
   - POST "/buy-film/{film}"  
   Route logic BE untuk menghandle request penghapusan film dari wishlist pengguna
   - POST "/rate-film/{film}/{rating}"  
   Route logic BE untuk menghandle request pemberian rating film dari pengguna
   - POST "/comment-film/{film}"  
   Route logic BE untuk menghandle request pemberian komentar film dari pengguna  

2. Web App API  
   - POST /films
   - GET /films
   - GET /films/:id
   - PUT /films/:id
   - DELETE /films/:id
   - POST /login
   - GET /self
   - GET /users
   - GET /users/:id
   - POST /users/:id/balance
   - DELETE /users/:id

<h2 id="bonus">Bonus</h2>

- B06 - Responsive Layout
- B08 - SOLID  
   Project ini menggunakan konsep MVC (Model-View-Controller) sebagai separation of concern dan agar memenuhi prinsip SOLID. Pembuatan class lain pada projek ini juga dibuat agar memenuhi prinsip-prinsip SOLID. Berikut adalah rincian class-class yang dibuat pada projek ini.
   1. Helper  
      Helper Class adalah class yang berisi metode-metode pembantu yang dibutuhkan pada class-class lain
   2. Controlers  
      Class Controlers bertanggung jawab untuk menerima request, memproses request tersebut dengan bantuan Model ataupun kelas lain, dan mengembalikan response yang sesuai  
   3. Middleware  
      Class Middleware bertanggung jawab sebagai 'filter' untuk request sebelum mencapai logic dari aplikasi. Disini dilakukan penyaringan request berdasarkan Authentication dan Authorization dari pengirim request dan request itu sendiri.
   4. Request
      Class Request berfungsi untuk melakukan penyaringan request setelah melalui middleware. Penyaringan disini bersifat spesifik terhadap resource yang ingin dilakukan operasi, seperti rules terhadap request body, dll.
   5. Resources
      Class Resources berfungsi untuk mengatur bentuk response JSON yang dikembalikan oleh API  
   6. Models
      Class Models mewakili entity atau row pada table database. Class Models berisi definisi dari suatu model dan business logic dari model tersebut.  
   7. Rules
      Class Rules berisi rule spesifik terhadap suatu attribut request yang kemudian akan digunakan pada Class Request. Penggunaan class ini agar dapat lebih leluasa dan fleksibel terhadap pemeriksaan attribut dan request dan pesan error yang dikembalikan
   8. Migrations
      Class Migrations berisi definisi tabel pada database, yang kemudian dijalankan untuk membangun definisi tersebut pada database.
   9. Factories
      Class Factory digunakan untuk membentuk suatu instance pada Model (umumnya instance dummy untuk seeding), yang dimana pada class ini dapat didefinisikan tiap-tiap attribut user yang akan dibentuk. Umumnya class ini digunakan pada Seeder.
   10. Seeder
      Class Seeder digunakan untuk melakukan operasi seeding terhadap database. Class ini berisi deretan instruksi seeding yang umumnya berupa aplikasi dari factory yang didefinisikan terhadap model tersebut.
   11. Views
      Views merupakan komponen projek yang bertanggung jawab terhadap tampilan frontend dari web app. Pada laravel, bentuk dari Views ini merupakan blade templating engine.
   12. Routes
      Routes merupakan komponen projek yang berfungsi untuk menerima request dari pengguna. Request yang diterima ini kemudian dihantarkan kepada Controller yang bersangkutan.

- B10 - Fitur Tambahan
    - Fitur Rating + Review
       Pada Film Details Page, terdapat fitur untuk memberikan rating, misal bintang 1-5. Selain rating, terdapat juga fitur review atau menambahkan komentar terkait film tersebut. Pengguna tentu dapat melihat rating dan review dari pengguna lainnya.
    - Wishlist  
       Pada Film Details Page, tambahkan fitur Wishlist yang memungkinkan pengguna untuk menambahkan film yang mereka minati ke dalam daftar Wishlist mereka. Pengguna dapat melihat dan mengelola daftar Wishlist mereka pada halaman terpisah. Fitur ini dapat membantu pengguna untuk menyimpan film yang ingin mereka beli atau tonton nanti.  

 - B11 - Bucket  
   Projek ini menggunakan Amazon S3 Bucket sebagai cloud storage untuk penyimpanan cover image dan video dari film.


<h2 id="author">Author</h2>
<pre>
  Name  : Ignatius Jhon Hezkiel Chan
  NIM   : 13522029
  Email : <a href="mailto:13522029@std.stei.itb.ac.id">13522029@std.stei.itb.ac.id</a>
</pre>