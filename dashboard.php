<?php
include "includes/auth.php";
include "includes/db.php";

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id=$user_id")->fetch_assoc();
$items = $conn->query("SELECT * FROM items WHERE user_id=$user_id ORDER BY created_at DESC");
$sent_swaps = $conn->query("SELECT s.*, i.title FROM swap_requests s JOIN items i ON s.item_id = i.id WHERE s.requester_id=$user_id");
$received_swaps = $conn->query("SELECT s.*, i.title, u.name FROM swap_requests s JOIN items i ON s.item_id = i.id JOIN users u ON s.requester_id = u.id WHERE i.user_id = $user_id");

if (isset($_GET['approve'])) {
  $swap_id = intval($_GET['approve']);
  $conn->query("UPDATE swap_requests SET status='accepted' WHERE id=$swap_id");
}
if (isset($_GET['reject'])) {
  $swap_id = intval($_GET['reject']);
  $conn->query("UPDATE swap_requests SET status='rejected' WHERE id=$swap_id");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ReWear Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background-color: #f2f4f7; }
    .navbar-brand { font-weight: bold; }
    .dashboard-box {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.07);
      padding: 25px;
      margin-bottom: 30px;
      transition: all 0.3s ease-in-out;
    }
    .dashboard-box:hover {
      transform: translateY(-4px);
      box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    .section-title {
      font-weight: 600;
      font-size: 1.4rem;
      margin-bottom: 20px;
      color: #333;
    }
    footer { background-color: #222; color: #fff; }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">♻️ ReWear</a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link active" href="#">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="add_item.php">Add Item</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">
  <div class="dashboard-box" data-aos="fade-up">
    <h2 class="section-title">👤 Profile Overview</h2>
    <div class="row">
      <div class="col-md-6"><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?><br><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></div>
      <div class="col-md-6"><strong>Points:</strong> <span class="badge bg-success"><?= $user['points'] ?> pts</span><br><strong>Role:</strong> <?= ucfirst($user['role']) ?></div>
    </div>
  </div>

  <div class="dashboard-box" data-aos="fade-up" data-aos-delay="100">
    <h2 class="section-title">📦 My Items</h2>
    <div class="row g-4">
      <?php while ($item = $items->fetch_assoc()): ?>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <img src="<?= htmlspecialchars($item['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['title']) ?>">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
              <p class="card-text text-muted">Status: <?= ucfirst($item['status']) ?></p>
              <a href="item_detail.php?id=<?= $item['id'] ?>" class="btn btn-outline-primary btn-sm">View Item</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <div class="dashboard-box" data-aos="fade-up" data-aos-delay="200">
    <h2 class="section-title">🔁 Swap Requests Sent</h2>
    <ul class="list-group">
      <?php while ($swap = $sent_swaps->fetch_assoc()): ?>
        <li class="list-group-item d-flex justify-content-between">
          <?= htmlspecialchars($swap['title']) ?>
          <span class="badge bg-<?= $swap['status'] == 'pending' ? 'warning' : ($swap['status'] == 'accepted' ? 'success' : 'secondary') ?>"><?= ucfirst($swap['status']) ?></span>
        </li>
      <?php endwhile; ?>
    </ul>
  </div>

  <div class="dashboard-box" data-aos="fade-up" data-aos-delay="300">
    <h2 class="section-title">📥 Swap Requests Received</h2>
    <ul class="list-group">
      <?php while ($req = $received_swaps->fetch_assoc()): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div><?= htmlspecialchars($req['name']) ?> requested <strong><?= htmlspecialchars($req['title']) ?></strong></div>
          <div>
            <?php if ($req['status'] == 'pending'): ?>
              <a href="?approve=<?= $req['id'] ?>" class="btn btn-success btn-sm">Accept</a>
              <a href="?reject=<?= $req['id'] ?>" class="btn btn-danger btn-sm">Reject</a>
            <?php else: ?>
              <span class="badge bg-<?= $req['status'] == 'accepted' ? 'success' : 'secondary' ?>"><?= ucfirst($req['status']) ?></span>
            <?php endif; ?>
          </div>
        </li>
      <?php endwhile; ?>
    </ul>
  </div>
</div>

<footer class="text-center py-3">
  <p class="mb-0">© <?= date("Y") ?> ReWear. Sustainable Swapping Starts Here.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
