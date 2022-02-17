<?php include_once '../conf/function.php' ?>
<?php include_once '../template/header.php'; ?>
<?php
// default score
$ph_tanahTopsis = [];
$teksturTanahTopsis = [];
$usiaTopsis = [];
$jenis_pupukTopsis = [];
$ketinggian_tempatTopsis = [];
// normalize score
$normPh_tanahTopsis = [];
$normUsiaTopsis = [];
$normTeksturTanahTopsis = [];
$normKetinggianTempatTopsis = [];
$normJenisPupukTopsis = [];
// normalize score multiply by weight
$normPh_tanahTopsisBobot = [];
$normUsiaTopsisBobot = [];
$normTeksturTanahTopsisBobot = [];
$normKetinggianTempatTopsisBobot = [];
$normJenisPupukTopsisBobot = [];
// dividen score
$divPh_tanahTopsis = 0;
$divUsiaTopsis = 0;
$divTeksturTanahTopsis = 0;
$divKetinggianTempatTopsis = 0;
$divJenisPupukTopsis = 0;

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
    array_push($ph_tanahTopsis, 25);
  } elseif ($row['ph_tanah'] >= 6 && $row['ph_tanah'] < 7) {
    array_push($ph_tanahTopsis, 70);
  } elseif ($row['ph_tanah'] >= 7 && $row['ph_tanah'] <= 7.8) {
    array_push($ph_tanahTopsis, 100);
  }
  // usiaTopsis
  if ($row['usia'] >= 4 && $row['usia'] <= 6) {
    array_push($usiaTopsis, 25);
  } elseif ($row['usia'] > 6 && $row['usia'] <= 7) {
    array_push($usiaTopsis, 50);
  } elseif ($row['usia'] > 7) {
    array_push($usiaTopsis, 100);
  }  // Daun
  if ($row['tekstur_tanah'] == 'gembur') {
    array_push($teksturTanahTopsis, 100);
  } elseif ($row['tekstur_tanah'] == 'lempung sekam') {
    array_push($teksturTanahTopsis, 50);
  } elseif ($row['tekstur_tanah'] == 'lainnya') {
    array_push($teksturTanahTopsis, 10);
  }
  // cabang
  if ($row['jenis_pupuk'] == 'kompos') {
    array_push($jenis_pupukTopsis, 100);
  } elseif ($row['jenis_pupuk'] == 'hayati') {
    array_push($jenis_pupukTopsis, 60);
  } elseif ($row['jenis_pupuk'] == 'perangsang bunga') {
    array_push($jenis_pupukTopsis, 20);
  }
  // batang
  if (($row['ketinggian_tempat'] >= 400) && ($row['ketinggian_tempat'] <= 500)) {
    array_push($ketinggian_tempatTopsis, 100);
  } elseif (($row['ketinggian_tempat'] > 500) && ($row['ketinggian_tempat'] <= 700)) {
    array_push($ketinggian_tempatTopsis, 80);
  } elseif (($row['ketinggian_tempat'] > 700) && ($row['ketinggian_tempat'] <= 1250)) {
    array_push($ketinggian_tempatTopsis, 25);
  }
}
// divide for normalize
for ($i = 0; $i < count($ph_tanahTopsis); $i++) {
  $divPh_tanahTopsis = $divPh_tanahTopsis + pow($ph_tanahTopsis[$i], 2);
  $divTeksturTanahTopsis = $divTeksturTanahTopsis + pow($teksturTanahTopsis[$i], 2);
  $divJenisPupukTopsis = $divJenisPupukTopsis + pow($jenis_pupukTopsis[$i], 2);
  $divKetinggianTempatTopsis = $divKetinggianTempatTopsis + pow($ketinggian_tempatTopsis[$i], 2);
  $divUsiaTopsis = $divUsiaTopsis + pow($usiaTopsis[$i], 2);
}
// square root on every result
$divTeksturTanahTopsis = sqrt($divTeksturTanahTopsis);
$divJenisPupukTopsis = sqrt($divJenisPupukTopsis);
$divKetinggianTempatTopsis = sqrt($divKetinggianTempatTopsis);
$divPh_tanahTopsis = sqrt($divPh_tanahTopsis);
$divUsiaTopsis = sqrt($divUsiaTopsis);
// exit;
// Normalize
for ($i = 0; $i < $jml; $i++) {
  array_push($normPh_tanahTopsis, $ph_tanahTopsis[$i] / $divPh_tanahTopsis);
  array_push($normTeksturTanahTopsis, $teksturTanahTopsis[$i] / $divTeksturTanahTopsis);
  array_push($normUsiaTopsis, $usiaTopsis[$i] / $divUsiaTopsis);
  array_push($normJenisPupukTopsis, $jenis_pupukTopsis[$i] / $divJenisPupukTopsis);
  array_push($normKetinggianTempatTopsis, $ketinggian_tempatTopsis[$i] / $divKetinggianTempatTopsis);
}
// var_dump($normPh_tanahTopsis);
// exit;
// var_dump($usiaTopsis);

// normalize multiply by on their weight(bobot)
$i = 0;
for ($i = 0; $i < $jml; $i++) {
  $normPh_tanahTopsisBobot[$i] = $normPh_tanahTopsis[$i] * $bobotAlt[0]['nilai_bobot'];
  $normJenisPupukTopsisBobot[$i] = $normJenisPupukTopsis[$i] * $bobotAlt[1]['nilai_bobot'];
  $normTeksturTanahTopsisBobot[$i] = $normTeksturTanahTopsis[$i] * $bobotAlt[2]['nilai_bobot'];
  $normUsiaTopsisBobot[$i] = $normUsiaTopsis[$i] * $bobotAlt[3]['nilai_bobot'];
  $normKetinggianTempatTopsisBobot[$i] = $normKetinggianTempatTopsis[$i] * $bobotAlt[4]['nilai_bobot'];
}

// get max(A+) and min(A-) of every criteria

// A+
$aPos[0] = max($normPh_tanahTopsisBobot);
$aPos[1] = max($normJenisPupukTopsisBobot);
$aPos[2] = max($normTeksturTanahTopsisBobot);
$aPos[3] = max($normUsiaTopsisBobot);
$aPos[4] = min($normKetinggianTempatTopsisBobot);

// A-
$aNeg[0] = min($normPh_tanahTopsisBobot);
$aNeg[1] = min($normJenisPupukTopsisBobot);
$aNeg[2] = min($normTeksturTanahTopsisBobot);
$aNeg[3] = min($normUsiaTopsisBobot);
$aNeg[4] = max($normKetinggianTempatTopsisBobot);

// count D+ and D-

// D+
for ($i = 0; $i < $jml; $i++) {
  $dPos[$i] = sqrt(pow(($normPh_tanahTopsisBobot[$i] - $aPos[0]), 2) + pow(($normJenisPupukTopsisBobot[$i] - $aPos[1]), 2) + pow(($normTeksturTanahTopsisBobot[$i] - $aPos[2]), 2) + pow(($normUsiaTopsisBobot[$i] - $aPos[3]), 2) + pow(($normKetinggianTempatTopsisBobot[$i] - $aPos[4]), 2));
}

// D-
for ($i = 0; $i < $jml; $i++) {
  $dNeg[$i] = sqrt(pow(($normPh_tanahTopsisBobot[$i] - $aNeg[0]), 2) + pow(($normJenisPupukTopsisBobot[$i] - $aNeg[1]), 2) + pow(($normTeksturTanahTopsisBobot[$i] - $aNeg[2]), 2) + pow(($normUsiaTopsisBobot[$i] - $aNeg[3]), 2) + pow(($normKetinggianTempatTopsisBobot[$i] - $aNeg[4]), 2));
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

// SAW

$ph_tanah = [];
$teksturTanah = [];
$usia = [];
$jenis_pupuk = [];
$ketinggian_tempat = [];
$normPh_tanah = [];
$normUsia = [];
$normTeksturTanah = [];
$normKetinggianTempat = [];
$normJenisPupuk = [];
$V = [];

// $bobot = query("SELECT * FROM tb_alternatif");
// $bobotAlt = query("SELECT * FROM tb_bobotkriteria");
// $jml = count($bobot);
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
for ($i = 0; $i < $jml; $i++) {
  array_push($normPh_tanah, $ph_tanah[$i] / max($ph_tanah));
  array_push($normTeksturTanah, $teksturTanah[$i] / max($teksturTanah));
  array_push($normUsia, $usia[$i] / max($usia));
  array_push($normJenisPupuk, $jenis_pupuk[$i] / max($jenis_pupuk));
  array_push($normKetinggianTempat, min($ketinggian_tempat) / $ketinggian_tempat[$i]);
}
// var_dump($normPh_tanah);
// exit;
// var_dump($usia);
$i = 0;
for ($i = 0; $i < $jml; $i++) {
  $countPref = (($normPh_tanah[$i] * (float)$bobotAlt[0]['nilai_bobot']) + ($normTeksturTanah[$i] * (float)$bobotAlt[2]['nilai_bobot']) + ($normUsia[$i] * (float)$bobotAlt[3]['nilai_bobot']) + ($normJenisPupuk[$i] * (float)$bobotAlt[1]['nilai_bobot']) + ($normKetinggianTempat[$i] * (float)$bobotAlt[4]['nilai_bobot']));
  array_push($V, $countPref);
  array_push($bobot[$i], $countPref);
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
    <div class="row">
      <div class="col-6">
        <div class="card-header text-white text-bold h2">
          Table Nilai Preferensi Topsis
        </div>
      </div>
      <div class="col-6 text-right">

        <a href="cetak.php" class="btn btn-primary"> Cetak</a>
      </div>
    </div>
    <table id="example1" class="table table-borderless" style="background-color: transparent; border:3px solid gray;" width=100%>
      <thead align="center" style="color: white; font-size: 18px; background-color: #5F9EA0;">
        <tr style="border:3px solid gray;">
          <th style="border:3px solid gray;">Alternatif</th>
          <th style="border:3px solid gray;">Nilai Prefensi</th>

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
                <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row[0]; ?></td>
                <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row[1];  ?></td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        <?php endfor; ?>
      </tbody>
    </table>
    <div class="card-header text-white text-bold h2">
      Table Preferensi SAW
    </div>
    <table id="example1" class="table table-borderless" style="background-color: transparent; border:3px solid gray;" width=100%>
      <thead align="center" style="color: white; font-size: 18px; background-color: #5F9EA0;">
        <tr style="border:3px solid gray;">
          <th style="border:3px solid gray;">Alternatif</th>
          <th style="border:3px solid gray;">Nilai Prefensi</th>

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
                <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row[2]; ?></td>
                <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row[3];  ?></td>
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