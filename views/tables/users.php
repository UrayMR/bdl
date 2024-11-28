<?php include __DIR__ . '/../../components/partials/Header.php'; ?>

<main class="container-fluid">
  <section id="table-users" class="container-fluid py-4">
    <h1>Users</h1>
    <table class="card-text table table-hover">
      <thead>
        <tr>
          <th>NPM</th>
          <th>Nama</th>
          <th>Angkatan</th>
          <th>idJurusan</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($data)): ?>
          <tr>
            <td class="colspan-3"> Tidak ada data ditemukan </td>
          </tr>
          <?php else: ?>
          <?php foreach ($data as $user): ?>
          <tr>
            <td><?php echo htmlspecialchars($user['npm']); ?></td>
            <td><?php echo htmlspecialchars($user['nama']); ?></td>
            <td><?php echo htmlspecialchars($user['angkatan']); ?></td>
            <td><?php echo htmlspecialchars($user['idJurusan']); ?></td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <?php include __DIR__ . '/../../components/Pagination.php'; ?>
  </section>
</main>

<?php include __DIR__ . '/../../components/partials/Footer.php'; ?>
