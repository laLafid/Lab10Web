<?php
session_start();
require_once __DIR__ . '/../../config/gajah.php';
require_once ROOT . 'module/clank/form.php';

$peng = [
    "rina@gmail.com" => ["nama" => "Rina Wulandari", "password" => "rina567", "role" => "User"],
    "agus@gmail.com" => ["nama" => "Agus Pranoto",   "password" => "agus567", "role" => "User"],
    "cell@gmail.com" => ["nama" => "Celine Marlina", "password" => "cell567", "role" => "Admin"]
];

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (isset($peng[$email]) && $peng[$email]['password'] === $password) {
        $_SESSION['login'] = true;
        $_SESSION['nama']  = $peng[$email]['nama'];
        $_SESSION['role']  = $peng[$email]['role'];
        header('Location: ' . BASE_URL . 'view/home.php');
        exit;
    } else {
        $error_message = "Email atau password salah!";
    }
}

require ROOT . 'view/header.php';
?>

<div class="container">
    <h2>Login Dulu</h2>

    <?php if ($error_message): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>

    <?php
    $form = new Form("", "Login Sekarang");
    $form->addText("username", "Email", $_POST['username'] ?? '', "email");
    $form->addText("password", "Password", "", "password");
    $form->displayForm();
    ?>

    <div style="margin-top:20px; padding:15px; background:#f8f9fa; border-radius:8px; font-size:0.9em;">
        <strong>Akun Demo:</strong><br>
        • User  → <code>agus@gmail.com</code> / <code>agus567</code>
    </div>
</div>

<?php require ROOT . 'view/footer.php'; ?>