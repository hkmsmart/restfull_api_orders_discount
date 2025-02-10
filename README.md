
Projeyi indirdikten sonra , projenin ana klsorüne "restfull_api_orders_discount-main" terminal ile açınız. Docker compose ile aşağıdaki komutu calıştırınız.
# docker compose up -d

docker container webserver2 olan container içine giriniz ve terminal ile açınız.
example dizini içinde aşağıdaki sıra ile komutları çalıştırınız.

Aşağıdaki kod ile laravel kütüphanlerini indiriniz.
1 # composer install

Laravel key oluşturmak için aşağıdaki komutu çalıştırınız.
2 # php artisan key:generate

Proje tabloları:database/migrations klasörünün altındadır. tabloları veritabanına eklemek için aşağıdaki komutu çalıştırınız.
3 # php artisan migrate

Proje örnek veriler:database/seeders klasörünün altındadır. örnek verileri tabloya aktarmak için aşağıdaki komutu çalıştırınız.
4 # php artisan db:seed

kurulum bitmiştir.

postman_collection.json dosyasında, methodlar bulunmaktadır, istek atarak çalıştırabilirsiniz.
