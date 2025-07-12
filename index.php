<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
include "includes/db.php";
$items = $conn->query("SELECT * FROM items ORDER BY created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ReWear – Clothing Exchange Platform</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <!-- Bootstrap & AOS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }
    .hero {
      background: url('https://heraclothing.com/cdn/shop/files/20230102-Rewear-Homepage-Hero-Mobile_59de0e5f-94fc-4704-b49f-9a9e98bce593.jpg') no-repeat center center/cover;
      height: 100vh;
      color: white;
      position: relative;
    }
    .overlay {
      background-color: rgba(0,0,0,0.5);
      height: 100%;
      width: 100%;
      position: absolute;
      top: 0;
      left: 0;
    }
    .hero-content {
      position: relative;
      z-index: 1;
      top: 50%;
      transform: translateY(-50%);
    }
    .btn-cta {
      margin: 0 10px;
      transition: transform 0.3s ease;
    }
    .btn-cta:hover {
      transform: scale(1.05);
    }
    .intro-section, .carousel-section {
      padding: 60px 15px;
    }
    footer {
      background-color: #222;
      color: #fff;
    }
  </style>
</head>
<body>

<!-- Hero Section -->
<section class="hero d-flex align-items-center justify-content-center text-center">
  <div class="overlay"></div>
  <div class="hero-content container">
    <h1 class="display-3 fw-bold" data-aos="zoom-in">♻️ ReWear</h1>
    <p class="lead fs-4" data-aos="fade-up" data-aos-delay="200">Swap clothes. Save the planet. Sustain your style.</p>
    <div class="mt-4" data-aos="fade-up" data-aos-delay="400">
      <a href="<?php echo $isLoggedIn ? 'dashboard.php' : 'login.php'; ?>" class="btn btn-success btn-lg btn-cta">Start Swapping</a>
      <a href="<?php echo $isLoggedIn ? 'browse.php' : 'login.php'; ?>" class="btn btn-outline-light btn-lg btn-cta">Browse Items</a>
      <a href="<?php echo $isLoggedIn ? 'add_item.php' : 'login.php'; ?>" class="btn btn-primary btn-lg btn-cta">List an Item</a>
    </div>
  </div>
</section>

<!-- Platform Introduction -->
<section class="intro-section text-center container" data-aos="fade-up">
  <h2 class="fw-bold mb-4">Welcome to ReWear</h2>
  <p class="lead">ReWear is your go-to platform for sustainable fashion. We make it easy to exchange gently used clothes, giving them a second life and reducing fashion waste. Earn points for items you share, and use them to claim new styles from others.</p>
</section>

<!-- Featured Items Carousel -->
<section class="carousel-section container" data-aos="fade-up" data-aos-delay="200">
  <h2 class="text-center mb-4">Featured Items</h2>
  <div id="featuredCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <?php $active = true; while ($item = $items->fetch_assoc()): ?>
      <div class="carousel-item <?= $active ? 'active' : '' ?>">
        <div class="d-flex flex-column align-items-center">
          <img src="https://via.placeholder.com/600x300?text=<?= urlencode($item['title']) ?>" class="img-fluid rounded mb-3" alt="Item">
          <h5><?= htmlspecialchars($item['title']) ?></h5>
          <p class="text-muted text-center px-4"><?= htmlspecialchars($item['description']) ?></p>
        </div>
      </div>
      <?php $active = false; endwhile; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</section>

<!-- Footer -->
<footer class="text-center py-3">
  <p class="mb-0">© <?= date("Y") ?> ReWear. Join the Swap Movement.</p>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>