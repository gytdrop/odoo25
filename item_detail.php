<?php
include "includes/auth.php";
include "includes/db.php";

if (!isset($_GET['id'])) {
  header("Location: browse.php");
  exit;
}
$item_id = intval($_GET['id']);
$item = $conn->query("SELECT i.*, u.name, u.email FROM items i JOIN users u ON i.user_id = u.id WHERE i.id = $item_id")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($item['title']) ?> – ReWear</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background-color: #f5f7fa; }
    footer { background-color: #222; color: #fff; }
    .img-preview {
      max-height: 400px;
      object-fit: cover;
    }
    .badge-status {
      font-size: 0.9rem;
      padding: 5px 10px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">♻️ ReWear</a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="browse.php">Browse</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">
  <div class="row">
    <div class="col-md-6" data-aos="fade-right">
      <img src="<?= $item['image'] ?>" class="img-fluid rounded shadow img-preview mb-3" alt="<?= htmlspecialchars($item['title']) ?>">
    </div>
    <div class="col-md-6" data-aos="fade-left">
      <h2><?= htmlspecialchars($item['title']) ?></h2>
      <span class="badge bg-<?= $item['status'] == 'available' ? 'success' : 'secondary' ?> badge-status">
        <?= ucfirst($item['status']) ?>
      </span>
      <p class="mt-3"> <strong>Description:</strong><br><?= nl2br(htmlspecialchars($item['description'])) ?></p>
      <p><strong>Category:</strong> <?= htmlspecialchars($item['category']) ?> <br>
         <strong>Type:</strong> <?= htmlspecialchars($item['type']) ?> <br>
         <strong>Size:</strong> <?= htmlspecialchars($item['size']) ?> <br>
         <strong>Condition:</strong> <?= htmlspecialchars($item['item_condition']) ?> <br>
         <strong>Tags:</strong> <?= htmlspecialchars($item['tags']) ?></p>

      <hr>
      <p><strong>Uploaded by:</strong><br><?= htmlspecialchars($item['name']) ?> (<?= htmlspecialchars($item['email']) ?>)</p>

      <?php if ($item['status'] === 'available'): ?>
        <a href="swap_request.php?item_id=<?= $item['id'] ?>" class="btn btn-outline-primary me-2">🔁 Request Swap</a>
        <a href="redeem_item.php?item_id=<?= $item['id'] ?>" class="btn btn-success">🎁 Redeem via Points</a>
      <?php else: ?>
        <div class="alert alert-info">This item is currently not available.</div>
      <?php endif; ?>
    </div>
  </div>
</div>

<footer class="text-center py-3 mt-5">
  <p class="mb-0">© <?= date("Y") ?> ReWear. Wear with purpose.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
