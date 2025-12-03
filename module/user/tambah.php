<?php
error_reporting(E_ALL);
require_once __DIR__ . '/../../config/gajah.php';
require ROOT . 'view/header.php';
require_once ROOT . 'module/clank/form.php';
?>

<div class="container">
    <h1>Tambah Barang</h1>

    <?php
    if ($_POST) {
        $data = [
            'nama'       => $_POST['nama'],
            'kategori'   => $_POST['kategori'],
            'harga_jual' => $_POST['harga_jual'],
            'harga_beli' => $_POST['harga_beli'],
            'stok'       => $_POST['stok'],
        ];

        if (!empty($_FILES['file_gambar']['name']) && $_FILES['file_gambar']['error'] == 0) {
            $filename = str_replace(' ', '_', $_FILES['file_gambar']['name']);
            $destination = GAMBAR . $filename;
            if (move_uploaded_file($_FILES['file_gambar']['tmp_name'], $destination)) {
                $data['gambar'] = 'gambar/' . $filename;
            }
        }

        $db->insert('data_barang', $data);
        header('Location: ' . BASE_URL . 'view/home.php');
        exit;
    }

    $form = new Form("", "Simpan Barang", true); 
    $form->addText("nama", "Nama Barang");
    $form->addSelect("kategori", "Kategori", [
        "Komputer" => "Komputer",
        "Elektronik" => "Elektronik",
        "Hand Phone" => "Hand Phone"
    ]);
    $form->addText("harga_jual", "Harga Jual");
    $form->addText("harga_beli", "Harga Beli");
    $form->addText("stok", "Stok");
    $form->addFile("file_gambar", "File Gambar");

    $form->displayForm();
    ?>

    <br>
    <a href="<?= BASE_URL ?>view/home.php" class="btn">Kembali</a>
</div>

<?php require ROOT . 'view/footer.php'; ?>