<?php
include "includes/db.php";
session_start();

if ($_POST) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prevent duplicate email
    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        $error = "Email already registered!";
    } else {
        $conn->query("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$pass')");
        header("Location: login.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register – ReWear</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <!-- Bootstrap & AOS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f9f9f9;
    }
    .navbar-brand {
      font-weight: bold;
      font-size: 1.4rem;
    }
    .form-box {
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.05);
      padding: 30px;
      margin-top: 50px;
    }
    footer {
      background-color: #222;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">♻️ ReWear</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="#">Register</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Register Form -->
<div class="container col-md-6">
  <div class="form-box" data-aos="fade-up">
    <h2 class="text-center mb-4">📝 Create Your Account</h2>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button class="btn btn-success w-100">Register</button>
      <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
    </form>
  </div>
</div>

<!-- Footer -->
<footer class="text-light text-center py-3 mt-5">
  <p class="mb-0">© <?= date("Y") ?> ReWear. Join the fashion sustainability revolution.</p>
</footer>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
