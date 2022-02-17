<?php include_once '../conf/function.php' ?>
<?php include_once '../template/header.php'; ?>
<?php
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
        <h3 class="card-title">Hasil Perhitungan SAW</h3>

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
      </div>  -->
    <!-- /.card-header -->
    <div class="" style="background-color: transparent;">
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
              <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['ph_tanah'] ?></td>
              <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['jenis_pupuk'] ?></td>
              <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['tekstur_tanah'] ?></td>
              <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['usia'], ' Bulan' ?></td>
              <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['ketinggian_tempat'] ?></td>
              <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= number_format($V[$no++], 4)  ?></td>
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
    </div>
    <!-- /.card-body -->
    <!-- </div> -->
    <!-- /.card -->
    <!-- </div> -->
    <!-- /.card -->

    <?php include_once '../template/footer.php' ?>