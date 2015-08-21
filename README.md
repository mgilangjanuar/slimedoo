# SliMedoo Framework v2

SliMedoo adalah PHP framework yang merupakan hasil pengembangan dari [Slim] dan [Medoo] sebagai komponen utamanya. Slim digunakan untuk routing dan Medoo untuk melakukan koneksi dan komunikasi dengan database. Komponen lainnya yaitu [Valitron], [uFlex], dan [PHPMailer]. SliMedoo Framework v2 terispirasi dari [yii2] yang elegan dan powerful. Beberapa syntax yang ada di yii2 terdapat juga di sini.

### Requirements
PHP >= 5.3

### Usage
Install via composer, ketik ini di console
```
composer create-project mgilangjanuar/slimedoo:"dev-master"
```

Jika belum install composer, ketk ini di console
```
curl -sS https://getcomposer.org/installer | php
```

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
Coming soon

[Slim]:http://slimframework.com/
[Medoo]:http://medoo.in/
[Valitron]:https://github.com/vlucas/valitron
[uFlex]:http://ptejada.com/projects/uFlex
[PHPMailer]:https://github.com/PHPMailer/PHPMailer
[yii2]:http://yiiframework.com