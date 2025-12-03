<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/flatly/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>asset/style.css">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(45deg,#5d87b8,#4a6fa5);">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= BASE_URL ?>view/home.php">Inventori Gajah</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>view/home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>view/about.php">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>view/kontak.php">Kontak</a></li>
            </ul>
            <?php if (isset($_SESSION['login'])): ?>
                <div class="text-white me-3">
                    Hai, <strong><?= htmlspecialchars($_SESSION['nama']) ?></strong>!
                </div>
                <a href="<?= BASE_URL ?>module/auth/logout.php" class="btn btn-danger btn-sm">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container my-5 flex-grow-1">