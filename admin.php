<?php
session_start();

// Auto-login for admin user (for demo/testing)
if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) {
  // Fake session if credentials match (real app should verify securely)
  $_SESSION['user_id'] = 1; // Example admin user ID
  $_SESSION['user_email'] = 'admin@hackathon.com';
}

if (!isset($_SESSION['user_id']) || $_SESSION['user_email'] !== 'admin@hackathon.com') {
  header("Location: login.php");
  exit;
}

include "includes/db.php";

// Approve item
if (isset($_GET['approve'])) {
  $item_id = intval($_GET['approve']);
  $conn->query("UPDATE items SET status='available' WHERE id=$item_id");
}

// Reject/remove item
if (isset($_GET['remove'])) {
  $item_id = intval($_GET['remove']);
  $conn->query("UPDATE items SET status='removed' WHERE id=$item_id");
}

$pending_items = $conn->query("SELECT i.*, u.name FROM items i JOIN users u ON i.user_id = u.id WHERE i.status='pending'");
$all_users = $conn->query("SELECT id, name, email, points, role FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel – ReWear</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background-color: #f5f5f5; }
    footer { background-color: #222; color: #fff; }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">♻️ ReWear Admin</a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">User Dashboard</a></li>
        <li class="nav-item"><a class="nav-link active" href="#">Admin Panel</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">
  <h2 class="mb-4">🛠 Admin: Moderate Pending Items</h2>
  <?php if ($pending_items->num_rows > 0): ?>
    <div class="row g-4 mb-5">
      <?php while ($item = $pending_items->fetch_assoc()): ?>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <img src="<?= htmlspecialchars($item['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['title']) ?>">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
              <p class="card-text small">Submitted by: <?= htmlspecialchars($item['name']) ?></p>
              <p class="card-text small text-muted"><?= htmlspecialchars($item['description']) ?></p>
            </div>
            <div class="card-footer text-center">
              <a href="?approve=<?= $item['id'] ?>" class="btn btn-success btn-sm">Approve</a>
              <a href="?remove=<?= $item['id'] ?>" class="btn btn-danger btn-sm">Reject</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-info">No pending items to review at the moment.</div>
  <?php endif; ?>

  <h2 class="mt-5 mb-3">👥 User Overview</h2>
  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>#ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Points</th>
          <th>Role</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($user = $all_users->fetch_assoc()): ?>
        <tr>
          <td><?= $user['id'] ?></td>
          <td><?= htmlspecialchars($user['name']) ?></td>
          <td><?= htmlspecialchars($user['email']) ?></td>
          <td><?= $user['points'] ?></td>
          <td><?= ucfirst($user['role']) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<footer class="text-center py-3 mt-5">
  <p class="mb-0">© <?= date("Y") ?> ReWear Admin. Keep it clean and green.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
