<?php
include "includes/auth.php"; // ensures only logged-in users can access
include "includes/db.php";

$items = $conn->query("SELECT i.*, u.name FROM items i JOIN users u ON i.user_id = u.id ORDER BY i.created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Browse Items – ReWear</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f5f7fa;
    }
    .item-card {
      transition: transform 0.2s ease;
    }
    .item-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    footer {
      background-color: #222;
      color: white;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">♻️ ReWear</a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link active" href="#">Browse</a></li>
        <li class="nav-item"><a class="nav-link" href="add_item.php">List an Item</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Item Grid -->
<div class="container py-5">
  <h2 class="mb-4 text-center fw-bold" data-aos="fade-up">All Available Items</h2>
  <div class="row g-4">
    <?php while ($item = $items->fetch_assoc()): ?>
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
      <div class="card item-card h-100">
        <img src="https://via.placeholder.com/600x400?text=<?= urlencode($item['title']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['title']) ?>">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
          <p class="card-text"><?= htmlspecialchars($item['description']) ?></p>
        </div>
        <div class="card-footer text-muted small">
          Shared by <?= htmlspecialchars($item['name']) ?>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</div>

<!-- Footer -->
<footer class="text-center py-3 mt-5">
  <p class="mb-0">© <?= date("Y") ?> ReWear. Browse sustainably.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
