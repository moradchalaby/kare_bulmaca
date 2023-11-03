<?php 
require 'KareBulmaca.php';


$bulmaca = new KareBulmaca(12, 12); // 12x12 boyutunda bir çözüm tahtası oluşturuluyor

// Çözüm tahtasına eklemek istediğiniz kelimeleri bir dizi olarak belirtin
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
    "bodevoffice"
    
];

// Kelimeleri Bulmaca tahtasına ekleyin
$bulmaca->kelimeleriEkle($kelimeler);

// Bulmacayı ekrana yazdırın
$alan = $bulmaca->alaniGetir();

for ($i = 0; $i < count($alan); $i++) {
    for ($j = 0; $j < count($alan[$i]); $j++) {
        echo $alan[$i][$j] . " ";
    }
    echo "\n";
}