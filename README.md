# Kare Bulmaca Oluşturma Sınıfı

Bu PHP sınıfı, belirtilen boyutlarda bir kare bulmaca oluşturmanıza olanak tanır.

## Kullanım

Proje dosyalarınızın olduğu dizine `KareBulmaca.php` dosyasını ekleyin. Daha sonra aşağıdaki gibi sınıfı kullanarak bulmaca oluşturabilirsiniz:

```php
<?php
require 'KareBulmaca.php';

// Örnek Kullanım
$bulmaca = new KareBulmaca(12, 12); 
// 12x12 boyutunda bir bulmaca oluşturur

$kelimeler = [
    "python",
    "javascript",
    "html",
    "css",
    "react",
    "angular",
    "nodejs",
    "java",
    "php",
    "ruby",
    "mysql",
    "mongodb",
    "php",
    "pars",
    "kal",
    "veri",
    "karebulmaca"
    
]; // Eklemek istediğiniz kelimeleri belirtin


$bulmaca->kelimeleriEkle($kelimeler); 
// Kelimeleri bulmacaya yerleştirir

$alan = $bulmaca->alaniGetir();

for ($i = 0; $i < count($alan); $i++) {
    for ($j = 0; $j < count($alan[$i]); $j++) {
        echo $alan[$i][$j] . " ";
    }
    echo "\n";
} // Bulmacayı ekrana yazdırır

```
## Fonksiyonlar
```php
__construct($sat, $sut)
```
Belirtilen satır ($sat) ve sütun ($sut) sayısına göre bir bulmaca oluşturur.

```php
kelimeleriEkle($kelimeler)
```
Belirtilen kelimeleri bulmacaya yerleştirir.

$kelimeler: Bir dizi olarak yerleştirilecek kelimeler.

```php
sifirla()
```
Bulmaca alanını sıfırlar.

```php
alaniGetir()
```
Bulmaca alanını döndürür.

## Katkıda Bulunma;

Eğer projeye katkıda bulunmak isterseniz, lütfen bir çekme isteği gönderin.

## Lisans;

Bu proje MIT lisansı altında lisanslanmıştır. Detaylar için [LİSANS](LICENSE) dosyasına göz atın.
