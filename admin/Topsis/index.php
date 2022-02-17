<?php include_once '../conf/function.php' ?>
<?php include_once '../template/header.php'; ?>
<?php
// default score
$ph_tanah = [];
$teksturTanah = [];
$usia = [];
$jenis_pupuk = [];
$ketinggian_tempat = [];
// normalize score
$normPh_tanah = [];
$normUsia = [];
$normTeksturTanah = [];
$normKetinggianTempat = [];
$normJenisPupuk = [];
// normalize score multiply by weight
$normPh_tanahBobot = [];
$normUsiaBobot = [];
$normTeksturTanahBobot = [];
$normKetinggianTempatBobot = [];
$normJenisPupukBobot = [];
// dividen score
$divPh_tanah = 0;
$divUsia = 0;
$divTeksturTanah = 0;
$divKetinggianTempat = 0;
$divJenisPupuk = 0;

// preference score
$V = [];

$bobot = query("SELECT * FROM tb_alternatif");
$bobotAlt = query("SELECT * FROM tb_bobotkriteria");
$jml = count($bobot);
// var_dump($bobot);
// echo $jml;
foreach ($bobot as $row) {
  // var_dump($row);
  // tinggi
  if ($row['ph_tanah'] >= 5 && $row['ph_tanah'] < 6) {
    array_push($ph_tanah, 25);
  } elseif ($row['ph_tanah'] >= 6 && $row['ph_tanah'] < 7) {
    array_push($ph_tanah, 70);
  } elseif ($row['ph_tanah'] >= 7 && $row['ph_tanah'] <= 7.8) {
    array_push($ph_tanah, 100);
  }
  // usia
  if ($row['usia'] >= 4 && $row['usia'] <= 6) {
    array_push($usia, 25);
  } elseif ($row['usia'] > 6 && $row['usia'] <= 7) {
    array_push($usia, 50);
  } elseif ($row['usia'] > 7) {
    array_push($usia, 100);
  }  // Daun
  if ($row['tekstur_tanah'] == 'gembur') {
    array_push($teksturTanah, 100);
  } elseif ($row['tekstur_tanah'] == 'lempung sekam') {
    array_push($teksturTanah, 50);
  } elseif ($row['tekstur_tanah'] == 'lainnya') {
    array_push($teksturTanah, 10);
  }
  // cabang
  if ($row['jenis_pupuk'] == 'kompos') {
    array_push($jenis_pupuk, 100);
  } elseif ($row['jenis_pupuk'] == 'hayati') {
    array_push($jenis_pupuk, 60);
  } elseif ($row['jenis_pupuk'] == 'perangsang bunga') {
    array_push($jenis_pupuk, 20);
  }
  // batang
  if (($row['ketinggian_tempat'] >= 400) && ($row['ketinggian_tempat'] <= 500)) {
    array_push($ketinggian_tempat, 100);
  } elseif (($row['ketinggian_tempat'] > 500) && ($row['ketinggian_tempat'] <= 700)) {
    array_push($ketinggian_tempat, 80);
  } elseif (($row['ketinggian_tempat'] > 700) && ($row['ketinggian_tempat'] <= 1250)) {
    array_push($ketinggian_tempat, 25);
  }
}
// divide for normalize
for ($i = 0; $i < count($ph_tanah); $i++) {
  $divPh_tanah = $divPh_tanah + pow($ph_tanah[$i], 2);
  $divTeksturTanah = $divTeksturTanah + pow($teksturTanah[$i], 2);
  $divJenisPupuk = $divJenisPupuk + pow($jenis_pupuk[$i], 2);
  $divKetinggianTempat = $divKetinggianTempat + pow($ketinggian_tempat[$i], 2);
  $divUsia = $divUsia + pow($usia[$i], 2);
}
// square root on every result
$divTeksturTanah = sqrt($divTeksturTanah);
$divJenisPupuk = sqrt($divJenisPupuk);
$divKetinggianTempat = sqrt($divKetinggianTempat);
$divPh_tanah = sqrt($divPh_tanah);
$divUsia = sqrt($divUsia);
// exit;
// Normalize
for ($i = 0; $i < $jml; $i++) {
  array_push($normPh_tanah, $ph_tanah[$i] / $divPh_tanah);
  array_push($normTeksturTanah, $teksturTanah[$i] / $divTeksturTanah);
  array_push($normUsia, $usia[$i] / $divUsia);
  array_push($normJenisPupuk, $jenis_pupuk[$i] / $divJenisPupuk);
  array_push($normKetinggianTempat, $ketinggian_tempat[$i] / $divKetinggianTempat);
}
// var_dump($normPh_tanah);
// exit;
// var_dump($usia);

// normalize multiply by on their weight(bobot)
$i = 0;
for ($i = 0; $i < $jml; $i++) {
  $normPh_tanahBobot[$i] = $normPh_tanah[$i] * $bobotAlt[0]['nilai_bobot'];
  $normJenisPupukBobot[$i] = $normJenisPupuk[$i] * $bobotAlt[1]['nilai_bobot'];
  $normTeksturTanahBobot[$i] = $normTeksturTanah[$i] * $bobotAlt[2]['nilai_bobot'];
  $normUsiaBobot[$i] = $normUsia[$i] * $bobotAlt[3]['nilai_bobot'];
  $normKetinggianTempatBobot[$i] = $normKetinggianTempat[$i] * $bobotAlt[4]['nilai_bobot'];
}

// get max(A+) and min(A-) of every criteria

// A+
$aPos[0] = max($normPh_tanahBobot);
$aPos[1] = max($normJenisPupukBobot);
$aPos[2] = max($normTeksturTanahBobot);
$aPos[3] = max($normUsiaBobot);
$aPos[4] = min($normKetinggianTempatBobot);

// A-
$aNeg[0] = min($normPh_tanahBobot);
$aNeg[1] = min($normJenisPupukBobot);
$aNeg[2] = min($normTeksturTanahBobot);
$aNeg[3] = min($normUsiaBobot);
$aNeg[4] = max($normKetinggianTempatBobot);

// count D+ and D-

// D+
for ($i = 0; $i < $jml; $i++) {
  $dPos[$i] = sqrt(pow(($normPh_tanahBobot[$i] - $aPos[0]), 2) + pow(($normJenisPupukBobot[$i] - $aPos[1]), 2) + pow(($normTeksturTanahBobot[$i] - $aPos[2]), 2) + pow(($normUsiaBobot[$i] - $aPos[3]), 2) + pow(($normKetinggianTempatBobot[$i] - $aPos[4]), 2));
}

// D-
for ($i = 0; $i < $jml; $i++) {
  $dNeg[$i] = sqrt(pow(($normPh_tanahBobot[$i] - $aNeg[0]), 2) + pow(($normJenisPupukBobot[$i] - $aNeg[1]), 2) + pow(($normTeksturTanahBobot[$i] - $aNeg[2]), 2) + pow(($normUsiaBobot[$i] - $aNeg[3]), 2) + pow(($normKetinggianTempatBobot[$i] - $aNeg[4]), 2));
}

for ($i = 0; $i < $jml; $i++) {
  $V[$i] = $dNeg[$i] / ($dNeg[$i] + $dPos[$i]);
  array_push($bobot[$i], $V[$i]);
}
for ($i = 0; $i < $jml; $i++) {
  $rank = 1;
  for ($j = 0; $j < $jml; $j++) {
    if ($bobot[$i][0] < $bobot[$j][0]) {
      $rank++;
    } elseif ($i == $j) {
      continue;
    } elseif ($bobot[$i][0] == $bobot[$j][0] && $i > $j) {
      $rank++;
    }
  }
  array_push($bobot[$i], $rank);
}
// var_dump($V);
?>
<div class="content-wrapper" style="background-image: url(../../dist/img/gambarr.jpg);background-size: cover;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 style="font-size: 64px; color:gainsboro;">HASIL PERHITUNGAN</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Blank Page</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <!-- <div class="card">
      <div class="card-header">
        <h3 class="card-title">Hasil Perhitungan Topsis</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body"> -->
    <!-- /.card -->

    <!-- <div class="card">
          <div class="card-header">
          </div> -->
    <!-- /.card-header -->
    <!-- <div class="card-body"> -->
    <!-- TABLE AWAL -->
    <table id="example1" class="table table-borderless" width="100%">
      <thead align="center" style="color: white; font-size: 18px; background-color: #5F9EA0;">
        <tr style="border:3px solid gray;">
          <th style=" border:3px solid gray;">No.</th>
          <th style=" border:3px solid gray;">Nama Alternatif</th>
          <th style="border:3px solid gray;">Ph Tanah</th>
          <th style=" border:3px solid gray;">Tekstur Tanah</th>
          <th style="border:3px solid gray;">Usia</th>
          <th style=" border:3px solid gray;">Batang</th>
          <th style="border:3px solid gray;">Hama</th>
          <!-- <th style=" border:3px solid gray;">Nilai Preferensi(V)</th> -->
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 0;
        foreach ($bobot as $row) :
        ?>
          <tr>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $no + 1 ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['nama_alternatif'] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['ph_tanah'] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['jenis_pupuk'] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['tekstur_tanah'] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['usia'], ' Bulan' ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['ketinggian_tempat'] ?></td>
            <!-- <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= number_format($V[$no++], 4)  ?></td> -->
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <!-- TABLE MATRIKS KEPUTUSAN -->
    <div class="card-header text-white text-bold h2">
      Table Matriks Keputusan
    </div>
    <table id="example1" class="table table-borderless" style="background-color: transparent; border:3px solid gray;" width=100%>
      <thead align="center" style="color: white; font-size: 18px; background-color: #5F9EA0;">
        <tr style="border:3px solid gray;">
          <th style="border:3px solid gray;">No.</th>
          <th style="border:3px solid gray;">Nama Alternatif</th>
          <th style="border:3px solid gray;">Ph Tanah</th>
          <th style="border:3px solid gray;">Tekstur Tanah</th>
          <th style="border:3px solid gray;">Usia</th>
          <th style="border:3px solid gray;">Batang</th>
          <th style="border:3px solid gray;">Hama</th>
          <!-- <th style="border:3px solid gray;">Nilai Preferensi(V)</th> -->
        </tr>
      </thead>
      <tbody class="warna-merah" style="color:tomato;">
        <?php
        $no = 0;
        foreach ($bobot as $row) :
        ?>
          <tr style="border:2px solid gray;">
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $no + 1 ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['nama_alternatif'] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $ph_tanah[$no] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $jenis_pupuk[$no] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $teksturTanah[$no] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $usia[$no] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $ketinggian_tempat[$no] ?></td>
            <!-- <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= number_format($V[$no++], 4)  ?></td> -->
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="card-header text-white text-bold h2">
      Table Normalisasi
    </div>
    <table id="example1" class="table table-borderless" style="background-color: transparent; border:3px solid gray;" width=100%>
      <thead align="center" style="color: white; font-size: 18px; background-color: #5F9EA0;">
        <tr style="border:3px solid gray;">
          <th style="border:3px solid gray;">No.</th>
          <th style="border:3px solid gray;">Nama Alternatif</th>
          <th style="border:3px solid gray;">Ph Tanah</th>
          <th style="border:3px solid gray;">Tekstur Tanah</th>
          <th style="border:3px solid gray;">Usia</th>
          <th style="border:3px solid gray;">Batang</th>
          <th style="border:3px solid gray;">Hama</th>
          <th style="border:3px solid gray;">Nilai Preferensi(V)</th>
        </tr>
      </thead>
      <tbody class="warna-merah" style="color:tomato;">
        <?php
        $no = 0;
        foreach ($bobot as $row) :
        ?>
          <tr style="border:2px solid gray;">
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $no + 1 ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['nama_alternatif'] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $normPh_tanah[$no] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $normJenisPupuk[$no] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $normTeksturTanah[$no] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $normUsia[$no] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $normKetinggianTempat[$no] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= number_format($V[$no++], 4)  ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="card-header text-white text-bold h2">
      Table Normalisasi Terbobot
    </div>
    <table id="example1" class="table table-borderless" style="background-color: transparent; border:3px solid gray;" width=100%>
      <thead align="center" style="color: white; font-size: 18px; background-color: #5F9EA0;">
        <tr style="border:3px solid gray;">
          <th style="border:3px solid gray;">No.</th>
          <th style="border:3px solid gray;">Nama Alternatif</th>
          <th style="border:3px solid gray;">Ph Tanah</th>
          <th style="border:3px solid gray;">Tekstur Tanah</th>
          <th style="border:3px solid gray;">Usia</th>
          <th style="border:3px solid gray;">Batang</th>
          <th style="border:3px solid gray;">Hama</th>
          <th style="border:3px solid gray;">Nilai Preferensi(V)</th>
        </tr>
      </thead>
      <tbody class="warna-merah" style="color:tomato;">
        <?php
        $no = 0;
        foreach ($bobot as $row) :
        ?>
          <tr style="border:2px solid gray;">
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $no + 1 ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['nama_alternatif'] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $normPh_tanahBobot[$no] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $normJenisPupukBobot[$no] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $normTeksturTanahBobot[$no] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $normUsiaBobot[$no] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $normKetinggianTempatBobot[$no] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= number_format($V[$no++], 4)  ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="card-header text-white text-bold h2">
      Table Solusi ideal positif dan negatif
    </div>
    <table id="example1" class="table table-borderless" style="background-color: transparent; border:3px solid gray;" width=100%>
      <thead align="center" style="color: white; font-size: 18px; background-color: #5F9EA0;">
        <tr style="border:3px solid gray;">
          <th style="border:3px solid gray;">#</th>
          <th style="border:3px solid gray;">K1(Benefit)</th>
          <th style="border:3px solid gray;">K2(Benefit)</th>
          <th style="border:3px solid gray;">K3(Benefit)</th>
          <th style="border:3px solid gray;">K4(Benefit)</th>
          <th style="border:3px solid gray;">K5(Cost)</th>
        </tr>
      </thead>
      <tbody class="warna-merah" style="color:tomato;">
        <?php
        $no = 0;
        ?>
        <tr style="border:2px solid gray;">

          <th align="center" style="color:white; font-size:20px; border:2px solid gray;">Positif</th>
          <?php foreach ($aPos as $item) : ?>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $item ?></td>
          <?php endforeach; ?>
        </tr>
        <tr>
          <th align="center" style="color:white; font-size:20px; border:2px solid gray;">Negatif</th>
          <?php foreach ($aNeg as $item) : ?>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $item ?></td>
          <?php endforeach; ?>
        </tr>
      </tbody>
    </table>
    <div class="card-header text-white text-bold h2">
      Table Jarak Solusi Ideal Positif
    </div>
    <table id="example1" class="table table-borderless" style="background-color: transparent; border:3px solid gray;" width=100%>
      <thead align="center" style="color: white; font-size: 18px; background-color: #5F9EA0;">
        <tr style="border:3px solid gray;">
          <th style="border:3px solid gray;">Alternatif</th>
          <th style="border:3px solid gray;">K1</th>
          <th style="border:3px solid gray;">K2</th>
          <th style="border:3px solid gray;">K3</th>
          <th style="border:3px solid gray;">K4</th>
          <th style="border:3px solid gray;">K5</th>
        </tr>
      </thead>
      <tbody class="warna-merah" style="color:tomato;">
        <?php
        $no = 0; ?>

        <?php foreach ($dPos as $item) : ?>
          <tr style="border:2px solid gray;">
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $bobot[$no++]['nama_alternatif'] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;" colspan="5"><?= $item ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="card-header text-white text-bold h2">
      Table Jarak Solusi Ideal Negatif
    </div>
    <table id="example1" class="table table-borderless" style="background-color: transparent; border:3px solid gray;" width=100%>
      <thead align="center" style="color: white; font-size: 18px; background-color: #5F9EA0;">
        <tr style="border:3px solid gray;">
          <th style="border:3px solid gray;">Alternatif</th>
          <th style="border:3px solid gray;">K1</th>
          <th style="border:3px solid gray;">K2</th>
          <th style="border:3px solid gray;">K3</th>
          <th style="border:3px solid gray;">K4</th>
          <th style="border:3px solid gray;">K5</th>
        </tr>
      </thead>
      <tbody class="warna-merah" style="color:tomato;">
        <?php
        $no = 0; ?>

        <?php foreach ($dNeg as $item) : ?>
          <tr style="border:2px solid gray;">
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $bobot[$no++]['nama_alternatif'] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;" colspan="5"><?= $item ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="card-header text-white text-bold h2">
      Table Nilai Preferensi
    </div>
    <table id="example1" class="table table-borderless" style="background-color: transparent; border:3px solid gray;" width=100%>
      <thead align="center" style="color: white; font-size: 18px; background-color: #5F9EA0;">
        <tr style="border:3px solid gray;">
          <th style="border:3px solid gray;">Alternatif</th>
          <th style="border:3px solid gray;">K1</th>
          <th style="border:3px solid gray;">K2</th>
          <th style="border:3px solid gray;">K3</th>
          <th style="border:3px solid gray;">K4</th>
          <th style="border:3px solid gray;">K5</th>
          <th style="border:3px solid gray;">Rank</th>
        </tr>
      </thead>
      <tbody class="warna-merah" style="color:tomato;">
        <?php
        $no = 0;
        for ($i = 0; $i < $jml; $i++) :
        ?>
          <?php
          foreach ($bobot as $row) :
          ?>
            <tr>
              <?php if ($row[1] == ($i + 1)) : ?>
                <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['nama_alternatif'] ?></td>
                <td align="center" style="color:white; font-size:20px; border:2px solid gray;" colspan="5"><?= $row[0]; ?></td>
                <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row[1];  ?></td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        <?php endfor; ?>
      </tbody>
    </table>
    <!-- </div> -->
    <!-- /.card-body -->
    <!-- </div> -->
    <!-- /.card -->
    <!-- </div> -->
    <!-- /.card -->
    <?php include_once '../template/footer.php' ?>