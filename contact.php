<?php
// contact.php - menyimpan pesan ke pesan.txt
$success = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '') $errors[] = 'Nama wajib diisi.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email tidak valid.';
    if ($message === '') $errors[] = 'Pesan tidak boleh kosong.';

    if (!$errors) {
        $time = date('Y-m-d H:i:s');
        $line = "[$time] Nama: " . htmlspecialchars($name) . " | Email: " . htmlspecialchars($email) . " | Pesan: " . htmlspecialchars($message) . PHP_EOL;
        $file = 'pesan.txt';
        if (file_put_contents($file, $line, FILE_APPEND | LOCK_EX) !== false) {
            $success = 'Terima kasih! Pesanmu telah terkirim.';
            $name = $email = $message = '';
        } else {
            $errors[] = 'Gagal menyimpan pesan. Periksa permission folder.';
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Contact — Tanjung Phone</title>
<link rel="stylesheet" href="css/style.css" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
  <div class="neon-bg"></div>
  <header class="site-header">
    <div class="wrap">
      <a class="brand" href="index.html">
        <img src="images/logo.png" alt="Tanjung Phone" class="logo" />
        <span class="brand-text">Tanjung Phone</span>
      </a>
      <nav class="main-nav">
        <a href="index.html">Home</a>
        <a href="about.html">About</a>
        <a href="contact.php" class="active">Contact</a>
      </nav>
    </div>
  </header>

  <main class="wrap contact-page">
    <section class="card contact-card">
      <h2>Hubungi Kami</h2>

      <?php if ($errors): ?>
        <div class="alert error">
          <ul>
            <?php foreach ($errors as $e): ?>
              <li><?php echo htmlspecialchars($e); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <?php if ($success): ?>
        <div class="alert success"><?php echo htmlspecialchars($success); ?></div>
      <?php endif; ?>

      <form id="contactForm" method="post" action="contact.php" novalidate>
        <label>Nama
          <input type="text" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required />
        </label>

        <label>Email
          <input type="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required />
        </label>

        <label>Pesan
          <textarea name="message" rows="6" required><?php echo htmlspecialchars($message ?? ''); ?></textarea>
        </label>

        <div class="form-actions">
          <button class="btn primary" type="submit">Kirim Pesan</button>
          <a class="btn ghost" href="index.html">Kembali</a>
        </div>
      </form>
      <p class="contact-meta"><strong>Alamat:</strong> Jl. Tanjung No.12 • <strong>Telp:</strong> 0812-3456-7890</p>
    </section>
  </main>

  <footer class="site-footer">
    <div class="wrap foot-inner">
      <div>© <span id="year3"></span> Tanjung Phone</div>
    </div>
  </footer>

<script src="js/script.js"></script>
</body>
</html>
