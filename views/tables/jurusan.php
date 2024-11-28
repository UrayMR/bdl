<?php include __DIR__ . '/../../components/partials/Header.php'; ?>

<main class="container-fluid">
  <section id="table-jurusan" class="container-fluid py-4">
    <h1>Jurusan</h1>
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
            <td class="colspan-2"> Tidak ada data ditemukan </td>
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
