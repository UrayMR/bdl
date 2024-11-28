<?php include __DIR__ . '/../../components/partials/Header.php'; ?>

<main class="container-fluid">
  <section id="table-fakultas" class="container-fluid py-4">
    <h1>fakultas</h1>
    <table class="card-text table table-hover">
      <thead>
        <tr>
          <th>Id Fakultas</th>
          <th>Nama Fakultas</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($data)): ?>
          <tr>
            <td class="colspan-2"> Tidak ada data ditemukan </td>
          </tr>
          <?php else: ?>
          <?php foreach ($data as $fakultas): ?>
          <tr>
            <td><?php echo htmlspecialchars($fakultas['idFakultas']); ?></td>
            <td><?php echo htmlspecialchars($fakultas['namaFakultas']); ?></td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <?php include __DIR__ . '/../../components/Pagination.php'; ?>
  </section>
</main>

<?php include __DIR__ . '/../../components/partials/Footer.php'; ?>
