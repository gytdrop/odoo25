<?php
include "includes/auth.php";
include "includes/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $category = $_POST['category'];
  $type = $_POST['type'];
  $size = $_POST['size'];
  $condition = $_POST['condition'];
  $tags = $_POST['tags'];
  $user_id = $_SESSION['user_id'];

  $image = $_FILES['image'];
  $imagePath = 'uploads/' . basename($image['name']);
  move_uploaded_file($image['tmp_name'], $imagePath);

  $stmt = $conn->prepare("INSERT INTO items (user_id, title, description, category, type, size, item_condition, tags, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("issssssss", $user_id, $title, $description, $category, $type, $size, $condition, $tags, $imagePath);
  $stmt->execute();

  header("Location: dashboard.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>List a New Item – ReWear</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f7fa;
    }
    footer {
      background-color: #222;
      color: #fff;
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
        <li class="nav-item"><a class="nav-link active" href="#">List Item</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">
  <h2 class="mb-4 text-center">📤 List a New Item</h2>
  <form method="POST" enctype="multipart/form-data" class="row g-3 bg-white p-4 shadow rounded">
    <div class="col-md-6">
      <label class="form-label">Upload Image</label>
      <input type="file" name="image" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Title</label>
      <input type="text" name="title" class="form-control" required>
    </div>
    <div class="col-md-12">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="3" required></textarea>
    </div>
    <div class="col-md-4">
      <label class="form-label">Category</label>
      <select name="category" class="form-select" required>
        <option value="">Choose...</option>
        <option value="Men">Men</option>
        <option value="Women">Women</option>
        <option value="Kids">Kids</option>
        <option value="Accessories">Accessories</option>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Type</label>
      <input type="text" name="type" class="form-control" placeholder="e.g. T-shirt, Jeans" required>
    </div>
    <div class="col-md-4">
      <label class="form-label">Size</label>
      <input type="text" name="size" class="form-control" placeholder="e.g. M, L, XL" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Condition</label>
      <select name="condition" class="form-select" required>
        <option value="">Select...</option>
        <option value="New">New</option>
        <option value="Like New">Like New</option>
        <option value="Used">Used</option>
        <option value="Good">Good</option>
      </select>
    </div>
    <div class="col-md-6">
      <label class="form-label">Tags</label>
      <input type="text" name="tags" class="form-control" placeholder="comma-separated e.g. casual, cotton" required>
    </div>
    <div class="col-12 text-center">
      <button type="submit" class="btn btn-primary px-5">Submit Item</button>
    </div>
  </form>
</div>

<footer class="text-center py-3 mt-5">
  <p class="mb-0">© <?= date("Y") ?> ReWear. Share your style responsibly.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
