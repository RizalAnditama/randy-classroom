<?php

/**
 *? Di dalem pemrograman web, kalo lu mau buka hasil kerja lu di browser make alamat folder,
 *! lu HARUS kasih nama "index"
 *  Biar file itu jadi file pertama yang dibuka dari folder lu 
 */
?>

<!-- Semua yang ada simbol buka elemen(<>) dan simbol tutup elemen (</>) (contohnya : <element> </element>) di dalam html itu namanya elemen -->

<!-- Elemen ini bisa dikasih atribut -->
<!-- Atribut gunanya sebagai identitas diri elemen tersebut... (contoh atributnya : class, id, name, dll) -->
<!-- ... juga bisa sebagai pemanggil identitas elemen lain... (contoh atributnya : for) -->
<!-- Atribut juga bisa dipakai buat nambah fungsi tertentu (contoh atributnya : required, placeholder, disabled, lang, dll) -->

<!-- Untuk mulai ngetik html, lu mesti taruh elemen <hmtl> contohnya kek dibawah -->
<html>

</html>
<!-- Di html, lu bisa ngebungkus segalanya make elemen-elemen yang ada. Tapi, tetep ada 3 struktur utama... -->
<!DOCTYPE html>
<html lang="en">
<!-- Ada <head> yang bisa lu pake buat naro tag <meta>, <title>, dan kalo bisa <link> untuk stylesheet CSS lu-->

<head>
  <!-- <meta> meta dipake biar browser tau apa yang kita pengen (kalo ga make juga gangaruh sih buat pemula) -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- <link> dipake buat ngambil elemen yang cakupannya external (ada di luar jangkauan index.html lu) -->
  <link rel="stylesheet" href="style.css">

  <!-- Lu bisa juga ngasih link dari elemen orang lain disini -->
  <!-- tujuannya sama, buat ngambil elemen external, bedanya ini online -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

  <!-- <title> dipake buat judul tab di browser lu -->
  <title>Judul Tab</title>
</head>

<!-- <body> dipake sebagai pembungkus utama -->
<!-- isinya elemen-elemen html yang mau lu tampilin ke browser -->

<body>
  <!-- Disini, lu bisa mulai kerjai proyek lu -->
  <!-- Biasanya, orang orang mulai ngerjainnya make pembungkus jenis <div> atau <section> -->
  <!-- Semua pembungkus biasanya memiiki atribut yang sama (dengan pengecualian) -->
  <!-- Kalo masalah pembungkus kek gini, mending make div aja (kecuali kalo emang mainan navbar, mending make <nav>) -->

  <!-- Pembungkus ini juga bisa diberi atribut identitas diri, kek id dan class -->
  <!-- Nantinya, identitas pembungkus ini bakal jadi identitas kelompoknya dia -->
  <!-- Jadi, semua yang ada di kelompok dia pasti dapat pengaruh dia, tapi dia gamungkin dapet pengaruh kelompoknya -->
  <div id="halo" class="dunia">
    <!-- di dalem pembungkus <div>, lu masih bisa ngasih pembungkus lain -->
    <div class="container">
      <div class="row">
        <!-- Di html, kalo mau ngasih style css, lu bisa make inline kek gini -->
        <div class="col-6" style="background-color: grey;">
          <!-- Atau make internal (contoh di paling bawah) -->
          <p class="biru">Hai</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Elemen di bawah bisa dipake untuk internal... -->
  <style>
    .biru {
      color: royalblue;
    }
  </style>
  <script>
    console.log('Halo dunia');
  </script>

  <!-- ...atau ngambil elemen dari file lain secara external -->
  <style>
    @import url(https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css);
  </style>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
  </script>
</body>

</html>