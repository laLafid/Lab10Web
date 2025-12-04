<?php
error_reporting(E_ALL);
require_once __DIR__ . '/../../config/gajah.php';
require ROOT . 'view/header.php';
require_once ROOT . 'config/form.php';

if ($_POST) {
    $id = $_POST['id'];
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

            $old = $db->get('data_barang', "id_barang = '$id'")->fetch_assoc();
            if (!empty($old['gambar']) && file_exists(GAMBAR . basename($old['gambar']))) {
                unlink(GAMBAR . basename($old['gambar']));
            }
        }
    }

    $db->update('data_barang', $data, "id_barang = '$id'");
    header('Location: ' . BASE_URL . 'view/home.php');
    exit;
}

$id = $_GET['id'] ?? 0;
$result = $db->get('data_barang', "id_barang = '$id'");
$data = $result->fetch_assoc();

if (!$data) {
    die('Data tidak ditemukan!');
}
?>

<div class="container">
    <h1>Ubah Barang</h1>

    <?php
    $form = new Form("", "Update Barang", true);
    $form->addText("id", "", $data['id_barang'], "hidden");
    $form->addText("nama",       "Nama Barang",      $data['nama']);
    $form->addSelect("kategori", "Kategori", [
        "Komputer"   => "Komputer",
        "Elektronik" => "Elektronik",
        "Hand Phone" => "Hand Phone"
    ], $data['kategori']);
    $form->addText("harga_jual", "Harga Jual",       $data['harga_jual']);
    $form->addText("harga_beli", "Harga Beli",       $data['harga_beli']);
    $form->addText("stok",       "Stok",             $data['stok']);
    $form->addFile("file_gambar","Ganti Gambar (kosongkan jika tidak diganti)");

    $form->displayForm();
    ?>

    <br>
    <a href="<?= BASE_URL ?>view/home.php" class="btn">Kembali</a>
</div>

<?php require ROOT . 'view/footer.php'; ?>