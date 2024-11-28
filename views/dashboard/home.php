<?php include __DIR__ . '/../../components/partials/Header.php'; ?>

<main class="container-fluid">
  <section id="home" class="container-fluid py-4">
    <h1>Dashboard</h1>
    <div class="row row-cols-1 row-cols-md-2 g-4 mx-auto my-auto px-1">
      <div class="col">
        <div class="card">
          <div class="card-body text-center">
            <h5 class="card-title">Banyak Panitia</h5>
            <h5 class="card-text">
              <?php echo $data['banyakPanitia'] ?? 0; ?>
            </h5>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-body text-center">
            <h5 class="card-title">Banyak Divisi</h5>
            <h5 class="card-text"><?php echo $data['banyakDivisi'] ?? 0; ?></h5>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-body text-center">
            <h5 class="card-title">Banyak Jurusan</h5>
            <h5 class="card-text">
              <?php echo $data['banyakJurusan'] ?? 0; ?>
            </h5>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-body text-center">
            <h5 class="card-title">Banyak Fakultas</h5>
            <h5 class="card-text">
              <?php echo $data['banyakFakultas'] ?? 0; ?>
            </h5>
          </div>
        </div>
      </div>
    </div>

    <div class="col mt-3 px-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-center">Tabel Panitia 5 Teratas</h5>
          <table class="card-text table table-hover">
            <thead>
              <tr>
                <th>NPM</th>
                <th>Nama</th>
                <th>Divisi</th>
                <th>Angkatan</th>
                <th>Jurusan</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data['tablePanitia'] as $panitia): ?>
              <tr>
                <td><?php echo htmlspecialchars($panitia['npm']); ?></td>
                <td><?php echo htmlspecialchars($panitia['nama']); ?></td>
                <td><?php echo htmlspecialchars($panitia['divisi']); ?></td>
                <td><?php echo htmlspecialchars($panitia['angkatan']); ?></td>
                <td><?php echo htmlspecialchars($panitia['jurusan']); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</main>

<?php include __DIR__ . '/../../components/partials/Footer.php'; ?>
