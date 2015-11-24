# SliMedoo Framework v2
[![Latest Stable Version](https://poser.pugx.org/mgilangjanuar/slimedoo/v/stable)](https://packagist.org/packages/mgilangjanuar/slimedoo) [![Total Downloads](https://poser.pugx.org/mgilangjanuar/slimedoo/downloads)](https://packagist.org/packages/mgilangjanuar/slimedoo) [![Latest Unstable Version](https://poser.pugx.org/mgilangjanuar/slimedoo/v/unstable)](https://packagist.org/packages/mgilangjanuar/slimedoo) [![License](https://poser.pugx.org/mgilangjanuar/slimedoo/license)](https://packagist.org/packages/mgilangjanuar/slimedoo)

SliMedoo adalah PHP framework yang merupakan hasil pengembangan dari [Slim] dan [Medoo] sebagai komponen utamanya. Slim digunakan untuk routing dan Medoo untuk melakukan koneksi dan komunikasi dengan database. Komponen lainnya yaitu [Valitron], [uFlex], dan [PHPMailer]. SliMedoo Framework v2 terispirasi dari [yii2] yang elegan dan powerful. Beberapa syntax yang ada di yii2 terdapat juga di sini.

### Requirements
PHP >= 5.3

### Usage
Install via composer, ketik ini di console

Untuk versi 2.0.1 (menggunakan Valitron sebagai validator form)
```
composer create-project mgilangjanuar/slimedoo:"2.0.1"
```

Untuk current version (menggunakan [verifyjs] sebagai validator form)
```
composer create-project mgilangjanuar/slimedoo
```

Jika belum install composer, ketik ini di console
```
curl -sS https://getcomposer.org/installer | php
```

Setelah itu pindahkan isi folder environments/app/* ke app/ dan lakukan beberapa konfigurasi file berikut:

* update composer (gunakan perintah ```composer update``` pada console).
* config.php (sesuaikan dengan konfigurasi database Anda dll).
* mail.php (optional, pada base app konfigurasi ini hanya digunakan untuk implementasi forgot password).
* params.php (optional, bila menggunakan plugin lain yang perlu menginitialisasi value tertentu, akses dengan cara \App::params()).

### Folder Structure
```
app
    component/                  for add PHP class to project
    config/                     config files
    controllers/                controllers class files
    models/                     models class files
    system/                     main PHP class                
    views/                      view files
environments
    app
        config                  config files
            database/           SQL File for initialize database
web
    assets/                     assets files like css, js, and others
```

### Tutorial
[Simple Guide](https://github.com/mgilangjanuar/slimedoo/wiki)

### License
MIT

[Slim]:http://slimframework.com/
[Medoo]:http://medoo.in/
[Valitron]:https://github.com/vlucas/valitron
[uFlex]:http://ptejada.com/projects/uFlex
[PHPMailer]:https://github.com/PHPMailer/PHPMailer
[yii2]:http://yiiframework.com
[verifyjs]:http://verifyjs.com
