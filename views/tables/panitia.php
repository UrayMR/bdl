<?php include __DIR__ . '/../../components/partials/Header.php'; ?>

<main class="container-fluid">
  <section id="table-panitia" class="container-fluid py-4">
    <h1>Panitia</h1>
    <table class="card-text table table-hover">
      <thead>
        <tr>
          <th>IdPanitia</th>
          <th>NPM</th>
          <th>IdDivisi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($data)): ?>
          <tr>
            <td class="colspan-2"> Tidak ada data ditemukan </td>
          </tr>
          <?php else: ?>
          <?php foreach ($data as $panitia): ?>
          <tr>
            <td><?php echo htmlspecialchars($panitia['idPanitia']); ?></td>
            <td><?php echo htmlspecialchars($panitia['npm']); ?></td>
            <td><?php echo htmlspecialchars($panitia['idDivisi']); ?></td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <?php include __DIR__ . '/../../components/Pagination.php'; ?>
  </section>
</main>

<?php include __DIR__ . '/../../components/partials/Footer.php'; ?>
