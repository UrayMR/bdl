<?php include __DIR__ . '/../../components/partials/Header.php'; ?>

<main class="container-fluid">
  <section id="table-jurusan" class="container-fluid py-4">
    <h1><?php echo ucfirst($tableName); ?></h1>

    <div class="card mb-4">
      <div class="card-body">
        <form method="GET" action="" class="row g-3">
          <div class="col-md-4">
            <input
              type="text"
              name="search"
              class="form-control"
              placeholder="Cari data..."
              value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" />
          </div>
          <div class="col-auto">
            <button type="submit" class="btn btn-primary">Cari</button>
            <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
              <a href="?page=1" class="btn btn-secondary">Reset</a>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>

    <table class="card-text table table-hover">
      <thead>
        <tr>
          <th>Id Jurusan</th>
          <th>Nama Jurusan</th>
          <th>Id Fakultas</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($data)): ?>
          <tr>
            <td colspan="100%"> Tidak ada data ditemukan </td>
          </tr>
        <?php else: ?>
          <?php foreach ($data as $jurusan): ?>
            <tr>
              <td><?php echo htmlspecialchars($jurusan['idJurusan']); ?></td>
              <td><?php echo htmlspecialchars($jurusan['namaJurusan']); ?></td>
              <td><?php echo htmlspecialchars($jurusan['idFakultas']); ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <?php include __DIR__ . '/../../components/Pagination.php'; ?>
  </section>
</main>

<?php include __DIR__ . '/../../components/partials/Footer.php'; ?>