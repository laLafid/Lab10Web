<?php 
session_start();
require_once __DIR__ . '/config/gajah.php';
require ROOT . 'view/header.php'; 
?>

<div class="row justify-content-center text-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow">
            <div class="card-body p-5">
                <h1 class="display-5 fw-bold text-primary mb-4">Selamat Datang!</h1>
                <p class="lead text-muted mb-5">Silakan login dulu untuk mengakses.</p>
                <a href="<?= BASE_URL ?>module/auth/login.php" class="btn btn-primary btn-lg rounded-pill px-5">
                    Masuk ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<?php require ROOT . 'view/footer.php'; ?>