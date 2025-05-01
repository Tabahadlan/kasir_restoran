<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tambah Meja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Tambah Meja</h2>
        <form action="proses_tambah_meja.php" method="POST" class="card p-4 shadow-sm">
            <div class="mb-3">
                <label for="nomormeja" class="form-label">Nomor Meja</label>
                <input type="number" class="form-control" name="nomormeja" required>
            </div>
            <div class="mb-3">
                <label for="namameja" class="form-label">Nama Meja</label>
                <input type="text" class="form-control" name="namameja" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>