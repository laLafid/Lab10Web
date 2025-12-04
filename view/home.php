<?php
session_start();
require_once __DIR__ . '/../config/gajah.php';
if (!isset($_SESSION['login'])) {
    header('Location: ' . BASE_URL . 'index.php');
    exit;
}
$result = $db->get('data_barang');
require ROOT . 'view/header.php';
?>
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Data Barang</h1>
        <a href="<?= BASE_URL ?>module/user/tambah.php" class="btn btn-primary">+ Tambah Barang</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-5">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Harga Jual</th>
                    <th>Harga Beli</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td data-label="Gambar">
                                <?php if ($row['gambar']): ?>
                                    <img src="<?= BASE_URL ?>gambar/<?= htmlspecialchars($row['gambar']) ?>" 
                                         alt="<?= htmlspecialchars($row['nama']) ?>" class="img-fluid">
                                <?php else: ?>
                                    <img src="<?= BASE_URL ?>gambar/no-image.jpg" alt="No Image" class="img-fluid">
                                <?php endif; ?>
                            </td>
                            <td data-label="Nama Barang">   <?= htmlspecialchars($row['nama']) ?></td>
                            <td data-label="Kategori">      <?= htmlspecialchars($row['kategori']) ?></td>
                            <td data-label="Harga Jual">    <?= number_format($row['harga_jual']) ?></td>
                            <td data-label="Harga Beli">    <?= number_format($row['harga_beli']) ?></td>
                            <td data-label="Stok">          <?= $row['stok'] ?></td>
                            <td data-label="Aksi">
                                <a href="<?= BASE_URL ?>module/user/ubah.php?id=<?= $row['id_barang'] ?>">Ubah</a> |
                                <a href="<?= BASE_URL ?>module/user/hapus.php?id=<?= $row['id_barang'] ?>"
                                   onclick="return confirm('Yakin?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center py-5">Belum ada data barang.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require ROOT . 'view/footer.php'; ?>
