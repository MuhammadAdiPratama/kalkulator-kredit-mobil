<?php
$perusahaan = "Adi Enterprise";
$bunga = 6;

// nilai awal form (kosong) -> dipakai saat halaman pertama kali dibuka
$nama = "";
$email = "";
$harga = "";
$dp = "";
$tenor = "";
$pesan_error = "";
$angsuran = 0;


function rupiah($angka)
{
    return "Rp " . number_format($angka, 0, ",", ".");
}


// cek apakah form telah di submit
if (isset($_POST['hitung'])) {

    // ambil nilai form (bab 20.11: trim + strip_tags + htmlentities)
    $nama  = htmlentities(strip_tags(trim($_POST['nama'])));
    $email = htmlentities(strip_tags(trim($_POST['email'])));
    $harga = htmlentities(strip_tags(trim($_POST['harga'])));
    $dp    = htmlentities(strip_tags(trim($_POST['dp'])));

    // radio button yang tidak dipilih tidak dikirim, jadi cek dengan isset()
    if (isset($_POST['tenor'])) {
        $tenor = htmlentities(strip_tags(trim($_POST['tenor'])));
    }

    // cek apakah "nama" sudah diisi atau tidak
    if (empty($nama)) {
        $pesan_error .= "Nama belum diisi <br>";
    }

    // cek apakah "email" sudah diisi atau tidak
    if (empty($email)) {
        $pesan_error .= "Email belum diisi <br>";
    }

    // cek apakah "harga" sudah diisi, dan harus berupa angka
    if (empty($harga)) {
        $pesan_error .= "Harga mobil belum diisi <br>";
    } elseif (!is_numeric($harga) || $harga <= 0) {
        $pesan_error .= "Harga mobil harus berupa angka lebih dari 0 <br>";
    }

    // cek apakah "dp" sudah dipilih atau tidak
    if (empty($dp)) {
        $pesan_error .= "DP belum dipilih <br>";
    }

    // cek apakah "tenor" sudah dipilih atau tidak
    if (empty($tenor)) {
        $pesan_error .= "Tenor belum dipilih <br>";
    }

    // jika tidak ada error, lakukan perhitungan
    if ($pesan_error === "") {
        $harga = (int) $harga;
        $dp    = (int) $dp;
        $tenor = (int) $tenor;

        $uang_dp = $harga * $dp / 100;
        $pinjaman = $harga - $uang_dp;
        $total_bunga = $pinjaman * $bunga / 100 * $tenor;
        $angsuran = ($pinjaman + $total_bunga) / ($tenor * 12);
        $bunga_perbulan = $total_bunga / ($tenor * 12);
    }
}

?>
<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $perusahaan; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="style.css?v=3" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">


  <nav class="navbar navbar-expand-md bg-body-tertiary border-bottom sticky-top">
    <div class="container-fluid px-4">
      <a class="navbar-brand d-flex align-items-center gap-2" href="#beranda">
        <img src="logo.png" class="logo" alt="Logo <?php echo $perusahaan; ?>">
        <span class="nama"><?php echo $perusahaan; ?></span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="#beranda">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="#tentang">Tentang Perusahaan</a></li>
          <li class="nav-item"><a class="nav-link" href="#kalkulator">Kalkulator</a></li>
          <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
        </ul>
      </div>
    </div>
  </nav>


  <div id="beranda" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="mobil.jpg" class="d-block w-100" alt="Slide 1">
        <div class="carousel-caption d-none d-md-block">
          <h2>Selamat Datang di <?php echo $perusahaan; ?></h2>
        </div>
      </div>
      <div class="carousel-item">
        <img src="mob.jpg" class="d-block w-100" alt="Slide 2">
        <div class="carousel-caption d-none d-md-block">
          <h2>Simulasi Angsuran Mobil</h2>
        </div>
      </div>
      <div class="carousel-item">
        <img src="mobi.jpg" class="d-block w-100" alt="Slide 3">
        <div class="carousel-caption d-none d-md-block">
          <h2>DP Ringan, Tenor Sampai 5 Tahun</h2>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#beranda" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
      <span class="visually-hidden">Sebelumnya</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#beranda" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
      <span class="visually-hidden">Berikutnya</span>
    </button>
  </div>

  <div class="container-fluid px-4 py-4 flex-grow-1">

    <!-- tentang perusahaan -->
    <div id="tentang" class="row g-4 mb-4">
      <div class="col-md-7">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h2 class="h4">Tentang Perusahaan</h2>
            <p>Tempat perhitungan angsuran mobil sederhana.</p>
            <p class="mb-0">Cukup isi nama, email, dan harga mobil, pilih DP dan lama cicilan, lalu klik tombol Hitung untuk melihat perkiraan angsuran per bulan.</p>
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <img src="gambar.jpg" class="foto-tentang rounded" alt="Gambar tentang perusahaan">
      </div>
    </div>

    <!-- kalkulator -->
    <div id="kalkulator" class="row g-4">
      <div class="col-md-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h2 class="h4 mb-3">Hitung Angsuran</h2>

            <?php if ($pesan_error != "") { ?>
              <div class="alert alert-danger"><?php echo $pesan_error; ?></div>
            <?php } ?>

            <form method="post" action="index.php#kalkulator">
              <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>">
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
              </div>

              <div class="mb-3">
                <label for="harga" class="form-label">Harga Mobil (Rp)</label>
                <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $harga; ?>">
              </div>

              <div class="mb-3">
                <label for="dp" class="form-label">DP</label>
                <select class="form-select" id="dp" name="dp">
                  <option value="">-- Pilih DP --</option>
                  <?php for ($d = 10; $d <= 50; $d += 10) { ?>
                    <option value="<?php echo $d; ?>" <?php if ($dp == $d) { echo "selected"; } ?>><?php echo $d; ?>%</option>
                  <?php } ?>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label d-block">Tenor</label>
                <?php for ($t = 1; $t <= 5; $t++) { ?>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tenor" id="tenor<?php echo $t; ?>"
                           value="<?php echo $t; ?>" <?php if ($tenor == $t) { echo "checked"; } ?>>
                    <label class="form-check-label" for="tenor<?php echo $t; ?>"><?php echo $t; ?> Tahun</label>
                  </div>
                <?php } ?>
              </div>

              <button type="submit" name="hitung" class="btn btn-primary">Hitung</button>
<a href="index.php?reset=<?php echo time(); ?>#kalkulator" class="btn btn-outline-secondary">Reset</a>
            </form>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h2 class="h4 mb-3">Hasil Perhitungan</h2>

            <?php if ($angsuran > 0) { ?>
              <p class="mb-0">Halo <b><?php echo $nama; ?></b>, berikut hasil untuk <?php echo $email; ?>:</p>
              <h3 class="text-primary mb-3"><?php echo rupiah($angsuran); ?></h3>

              <table class="table table-sm">
                <tr><td>Harga mobil</td><td class="text-end"><?php echo rupiah($harga); ?></td></tr>
                <tr><td>DP (<?php echo $dp; ?>%)</td><td class="text-end"><?php echo rupiah($uang_dp); ?></td></tr>
                <tr><td>Pinjaman</td><td class="text-end"><?php echo rupiah($pinjaman); ?></td></tr>
                <tr><td>Total bunga (<?php echo $bunga; ?>% per tahun)</td><td class="text-end"><?php echo rupiah($total_bunga); ?></td></tr>
                <tr><td>Bunga per bulan</td><td class="text-end"><?php echo rupiah($bunga_perbulan); ?></td></tr>
                <tr><td>Lama cicilan</td><td class="text-end"><?php echo $tenor * 12; ?> bulan</td></tr>
              </table>
            <?php } else { ?>
              <p class="text-secondary">Hasil perhitungan akan muncul di sini.</p>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- footer -->
  <footer id="kontak" class="bg-body-tertiary border-top text-center p-3">
    <b><?php echo $perusahaan; ?></b><br>
    <i class="bi bi-telephone"></i> 085-124-554-659
    &nbsp;|&nbsp;
    <i class="bi bi-envelope"></i> yokosana68@gmail.com
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
