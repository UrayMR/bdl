<?php include __DIR__ . '/../../components/partials/Header.php'; ?>

<main class="container-fluid">
  <section id="table-divisi" class="container-fluid py-4">
    <h1>Divisi</h1>
    <table class="card-text table table-hover">
      <thead>
        <tr>
          <th>Id Divisi</th>
          <th>Nama Divisi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($data)): ?>
          <tr>
            <td class="colspan-2"> Tidak ada data ditemukan </td>
          </tr>
          <?php else: ?>
          <?php foreach ($data as $divisi): ?>
          <tr>
            <td><?php echo htmlspecialchars($divisi['idDivisi']); ?></td>
            <td><?php echo htmlspecialchars($divisi['namaDivisi']); ?></td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <?php include __DIR__ . '/../../components/Pagination.php'; ?>
  </section>
</main>

<?php include __DIR__ . '/../../components/partials/Footer.php'; ?>
