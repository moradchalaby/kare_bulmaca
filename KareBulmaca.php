<?php
class KareBulmaca
{
    const HARFLER = "abcçdefgğhıijklmnoöpqrsştuüvwxyz";
    private $yonX = [0, 1];
    private $yonY = [1, 0];
    private $alan;
    private $yKelimeler;
    private $dKelimeler;
    private $sat;
    private $sut;
    private $yUzunluk;
    private $dUzunluk;
    private $sagdan;
 
    private $eklenecekKelimeler;
    private $sonAlan;
    private $enIyiBosluk;
     public $kullanilanKelimeler = [];
    private $basZaman;

    public function __construct($sat, $sut)
    {
        //Verilen değerlere uygun Alan başlat.
        $this->alan = array_fill(0, $sat, array_fill(0, $sut, ' '));
        $this->yKelimeler = array_fill(0, $sat, array_fill(0, $sut, 0));
        $this->dKelimeler = array_fill(0, $sat, array_fill(0, $sut, 0));
        $this->sat = $sat;
        $this->sut = $sut;
        

        for ($i = 0; $i < $this->sat; $i++) {
            for ($j = 0; $j < $this->sut; $j++) {
                $this->alan[$i][$j] = ' ';
            }
        }
    }

  

    public function konumDogrula($x, $y)
    {
        // Verilen pozisyonun geçerli olup olmadığını kontrol et
        return $x >= 0 && $y >= 0 && $x < $this->sat&& $y < $this->sut;
    }
    public function yerlesebilir($kelime, $x, $y, $yon)
    {
        $sonuc = 0;
        // Yatay ve Dikey yönde kelimenin yerleştirilebilirliğini kontrol et
        // Ayrıca yerleştirilebiliyorsa, kaç harfinin yerleştirilebileceğini döndür
        if ($yon == 0) {
            for ($j = 0; $j < strlen($kelime); $j++) {
                $x1 = $x;
                $y1 = $y + $j;
                if (!($this->konumDogrula($x1, $y1) && ($this->alan[$x1][$y1] == ' ' || $this->alan[$x1][$y1] == $kelime[$j]))) return -1;
                if ($this->konumDogrula($x1 - 1, $y1) && $this->yKelimeler[$x1 - 1][$y1] > 0) return -1;
                if ($this->konumDogrula($x1 + 1, $y1) && $this->yKelimeler[$x1 + 1][$y1] > 0) return -1;
                if ($this->alan[$x1][$y1] == $kelime[$j]) $sonuc++;
            }
        } else {
             

            for ($j = 0; $j < strlen($kelime); $j++) {
                $x1 = $x + $j;
                $y1 = $y;
                if (!($this->konumDogrula($x1, $y1) && ($this->alan[$x1][$y1] == ' ' || $this->alan[$x1][$y1] == $kelime[$j]))) return -1;
                if ($this->konumDogrula($x1, $y1 - 1) && $this->dKelimeler[$x1][$y1 - 1] > 0) return -1;
                if ($this->konumDogrula($x1, $y1 + 1) && $this->dKelimeler[$x1][$y1 + 1] > 0) return -1;
                if ($this->alan[$x1][$y1] == $kelime[$j]) $sonuc++;
            }
        }

        // Kelimenin kenarlara temas etmemesi için kontrol et

        $xStar = $x - $this->yonX[$yon];
        $yStar = $y - $this->yonY[$yon];
        if ($this->konumDogrula($xStar, $yStar) && !($this->alan[$xStar][$yStar] == ' ' || $this->alan[$xStar][$yStar] == '*')) return -1;

        $xStar = $x + $this->yonX[$yon] * strlen($kelime);
        $yStar = $y + $this->yonY[$yon] * strlen($kelime);
        if ($this->konumDogrula($xStar, $yStar) && !($this->alan[$xStar][$yStar] == ' ' || $this->alan[$xStar][$yStar] == '*')) return -1;

        // Kelimenin yerleştirilebilir olduğunu belirt
        return ($sonuc == strlen($kelime)) ? -1 : $sonuc;
    }

    public function kelimeKoy($kelime, $x, $y, $yon, $deger)
    {
        $mat = ($yon == 0) ? $this->yKelimeler : $this->dKelimeler;
        // Kelimeyi yerleştir
        // İlgili matrise de değerleri kaydet

        for ($i = 0; $i < strlen($kelime); $i++) {
            $x1 = $x + $this->yonX[$yon] * $i;
            $y1 = $y + $this->yonY[$yon] * $i;
            $this->alan[$x1][$y1] = $kelime[$i];
            $mat[$x1][$y1] = $deger;
        }
        // Kenarlara '*' işareti ekle
        $xStar = $x - $this->yonX[$yon];
        $yStar = $y - $this->yonY[$yon];
        if ($this->konumDogrula($xStar, $yStar)) $this->alan[$xStar][$yStar] = '*';

        $xStar = $x + $this->yonX[$yon] * strlen($kelime);
        $yStar = $y + $this->yonY[$yon] * strlen($kelime);
        if ($this->konumDogrula($xStar, $yStar)) $this->alan[$xStar][$yStar] = '*';
    }


    private function konumBul($kelime)
    {
        //Verilen kelimenin yerleştirileceği konumları bul ve x, y kordinatlarına göre bir liste oluştur
        $maks = 0;
        $konumlar = [];

        for ($x = 0; $x < $this->sat; $x++) {
            for ($y = 0; $y < $this->sut; $y++) {
                for ($i = 0; $i < count($this->yonX); $i++) {
                    $yon = $i;
                    $eklenecekKelimeler = ($i == 0 && $this->sagdan) ? strrev($kelime) : $kelime;
                    $uzunluk = $this->yerlesebilir($eklenecekKelimeler, $x, $y, $yon);

                    if ($uzunluk < $maks) continue;
                    if ($uzunluk > $maks) $konumlar = [];

                    $maks = $uzunluk;
                    $konumlar[] = [$x, $y, $yon];
                }
            }
        }

        return $konumlar;
    }

    private function enIyiKonum($kelime)
    {
        //Kelimenin konumlar içinde en iyi konumu bul
        $konumlar = $this->konumBul($kelime);
        if (!empty($konumlar)) {
            $i= mt_rand(0, count($konumlar) - 1);
            return $konumlar[$i];
        }
        return null;
    }

   

    public function alaniGetir()
    {
        //Bulmaca alanını döndür.
        return $this->alan;
    }

    public function sifirla()
    {
        //Bulmaca alanını ve ilgili matrisleri sıfırlar
        for ($i = 0; $i < $this->sat; $i++) {
            for ($j = 0; $j < $this->sut; $j++) {
                $this->alan[$i][$j] = ' ';
                $this->dKelimeler[$i][$j] = 0;
                $this->yKelimeler[$i][$j] = 0;
                $this->yUzunluk = $this->dUzunluk = 0;
            }
        }
    }

    public function kelimeleriEkle($kelimeler)
    {
        //Önce uzun kelimeleri yerleştirmek için kelimeleri uzunluklarına göre sıralıyorum
        usort($kelimeler, function($a, $b) {
            return strlen($b) - strlen($a);
        });
        
        //Kelimeleri yerleştir.
        $this->eklenecekKelimeler = $kelimeler;
        $this->enIyiBosluk = $this->sat* $this->sut;
        $this->basZaman = time();

        $this->olustur(0);
        $this->alan = $this->sonAlan;
    }

    private function bosluklar()
    {
        $uzunluk = 0;
        for ($i = 0; $i < $this->sat; $i++) {
            for ($j = 0; $j < $this->sut; $j++) {
                if ($this->alan[$i][$j] == ' ' || $this->alan[$i][$j] == '*') {
                    $uzunluk++;
                }
            }
        }
        return $uzunluk;
    }

    private function olustur($konum)
    {
        //Bulmacayı oluştur.
        if ($konum >= count($this->eklenecekKelimeler) || (time() - $this->basZaman) > 60) {
            return;
        }
 
        for ($i = $konum; $i < count($this->eklenecekKelimeler); $i++) {
            $konumi = $this->enIyiKonum($this->eklenecekKelimeler[$i]);
            if ($konumi !== null && !in_array($this->eklenecekKelimeler[$i],$this->kullanilanKelimeler)) {
                $kelime = $this->eklenecekKelimeler[$i];
                if ($konumi[2] == 0 && $this->sagdan ) {
                    $kelime = strrev($kelime);
                }
                $value = ($konumi[2] == 0) ? $this->yUzunluk : $this->dUzunluk;
                $this->kelimeKoy($kelime, $konumi[0], $konumi[1], $konumi[2], $value);
                $this->olustur($konum + 1);
                $this->kelimeSil($kelime, $konumi[0], $konumi[1], $konumi[2]);
                $this->kullanilanKelimeler[]=$this->eklenecekKelimeler[$i];
            } else {
                $this->olustur($konum + 1);
            }

        
        }

        $c = $this->bosluklar();
        if ($c >= $this->enIyiBosluk) return;
        $this->enIyiBosluk = $c;
        $this->sonAlan = $this->alan;
    }

    private function kelimeSil($kelime, $x, $y, $yon)
    {
        //Belirtilen kelimeyi kaldır.
        $mat = ($yon == 0) ? $this->yKelimeler : $this->dKelimeler;
        $mat1 = ($yon == 0) ? $this->dKelimeler : $this->yKelimeler;

        for ($i = 0; $i < strlen($kelime); $i++) {
            $x1 = $x + $this->yonX[$yon] * $i;
            $y1 = $y + $this->yonY[$yon] * $i;
             if ($mat1[$x1][$y1] == 0)
                 $this->alan[$x1][$y1] = ' ';
            $mat[$x1][$y1] = 0;
        }

         $xStar = $x - $this->yonX[$yon];
         $yStar = $y - $this->yonY[$yon];
         if ($this->konumDogrula($xStar, $yStar) && $this->cevreKontrol($xStar, $yStar))
             $this->alan[$xStar][$yStar] = ' ';

         $xStar = $x + $this->yonX[$yon] * strlen($kelime);
         $yStar = $y + $this->yonY[$yon] * strlen($kelime);
         if ($this->konumDogrula($xStar, $yStar) && $this->cevreKontrol($xStar, $yStar))
             $this->alan[$xStar][$yStar] = ' ';
    }

    private function cevreKontrol($x, $y)
    {
        //Belirtilen konum etrafında ki karakterleri kontrol eder.
        for ($i = 0; $i < count($this->yonX); $i++) {
            $x1 = $x + $this->yonX[$i];
            $y1 = $y + $this->yonY[$i];
            if ($this->konumDogrula($x1, $y1) && ($this->alan[$x1][$y1] != ' ' || $this->alan[$x1][$y1] == '*'))
                return true;
            $x1 = $x - $this->yonX[$i];
            $y1 = $y - $this->yonY[$i];
            if ($this->konumDogrula($x1, $y1) && ($this->alan[$x1][$y1] != ' ' || $this->alan[$x1][$y1] == '*'))
                return true;
        }
        return false;
    }
}


