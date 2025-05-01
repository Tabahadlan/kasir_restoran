<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'waiter') {
    header("Location: ../../login.php");
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID tidak ditemukan.";
    exit;
}

// Ambil data pesanan
$pesanan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pesanan WHERE idpesanan = $id"));

// Ambil detail pesanan dan menu (query ulang supaya aman)
$detail_query = mysqli_query($conn, "SELECT * FROM detail_pesanan WHERE idpesanan = $id");
$menu_query = mysqli_query($conn, "SELECT * FROM menu");
$menu_data = [];
while ($row = mysqli_fetch_assoc($menu_query)) {
    $menu_data[] = $row;
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f8f9fa;
    }
    .container {
        max-width: 800px;
        margin-top: 40px;
    }
</style>

<div class="container">
    <h3 class="mb-4">Edit Pesanan #<?= $id ?></h3>

    <form action="proses_edit_pesanan.php" method="POST">
        <input type="hidden" name="idpesanan" value="<?= $id ?>">

        <div id="menu-container">
            <?php $index = 0; while ($d = mysqli_fetch_assoc($detail_query)): ?>
            <div class="card mb-3 shadow-sm p-3">
                <div class="row align-items-end">
                    <div class="col-md-6">
                        <label class="form-label">Menu</label>
                        <select name="idmenu[]" class="form-select">
                            <?php foreach ($menu_data as $m): ?>
                                <option value="<?= $m['idmenu'] ?>" <?= ($m['idmenu'] == $d['idmenu']) ? 'selected' : '' ?>>
                                    <?= $m['namamenu'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="jumlah[]" class="form-control" value="<?= $d['jumlah'] ?>" required>
                    </div>
                    <div class="col-md-2 text-end">
                        <?php if ($index > 0): ?>
                            <button type="button" class="btn btn-outline-danger btn-sm mt-4" onclick="hapusBaris(this)">🗑</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php $index++; endwhile; ?>
        </div>

        <button type="button" class="btn btn-outline-success mb-3" onclick="tambahMenu()">+ Tambah Menu</button>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
            <a href="index.php" class="btn btn-secondary">❌ Batal</a>
        </div>
    </form>
</div>

<script>
function tambahMenu() {
    const menuData = <?= json_encode($menu_data) ?>;
    const menuContainer = document.getElementById('menu-container');

    const selectOptions = menuData.map(m => `<option value="${m.idmenu}">${m.namamenu}</option>`).join('');

    const newMenu = `
        <div class="card mb-3 shadow-sm p-3">
            <div class="row align-items-end">
                <div class="col-md-6">
                    <label class="form-label">Menu</label>
                    <select name="idmenu[]" class="form-select">
                        ${selectOptions}
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="jumlah[]" class="form-control" required>
                </div>
                <div class="col-md-2 text-end">
                    <button type="button" class="btn btn-outline-danger btn-sm mt-4" onclick="hapusBaris(this)">🗑</button>
                </div>
            </div>
        </div>
    `;

    menuContainer.insertAdjacentHTML('beforeend', newMenu);
}

function hapusBaris(button) {
    button.closest('.card').remove();
}
</script>
