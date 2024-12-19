<?php include __DIR__ . '/../../components/partials/Header.php'; ?>

<main class="container-fluid">
  <section id="table-divisi" class="container-fluid py-4">
    <h1>Tabel Panitia</h1>

    <div class="card mb-4">
      <div class="card-body">
        <form method="GET" class="row g-3">
          <div class="col-md-3">
            <label for="nama" class="form-label">Nama Referensi</label>
            <select name="npm" id="nama" class="form-select" required>
              <option value="">Pilih Nama</option>
              <?php foreach ($data['names'] as $npm => $name): ?>
                <option value="<?php echo htmlspecialchars($npm); ?>"
                  <?php echo (isset($_GET['npm']) && $_GET['npm'] == $npm) ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($name); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-3">
            <label for="parameter" class="form-label">Parameter</label>
            <select name="parameter" id="parameter" class="form-select" required>
              <option value="">Pilih Parameter</option>
              <option value="angkatan" <?php echo (isset($_GET['parameter']) && $_GET['parameter'] === 'angkatan') ? 'selected' : ''; ?>>Angkatan</option>
              <option value="npm" <?php echo (isset($_GET['parameter']) && $_GET['parameter'] === 'npm') ? 'selected' : ''; ?>>NPM</option>
              <option value="jurusan" <?php echo (isset($_GET['parameter']) && $_GET['parameter'] === 'jurusan') ? 'selected' : ''; ?>>Jurusan</option>
              <option value="divisi" <?php echo (isset($_GET['parameter']) && $_GET['parameter'] === 'divisi') ? 'selected' : ''; ?>>Divisi</option>
              <option value="fakultas" <?php echo (isset($_GET['parameter']) && $_GET['parameter'] === 'fakultas') ? 'selected' : ''; ?>>Fakultas</option>
            </select>
          </div>

          <div class="col-md-3">
            <label for="kriteria" class="form-label">Kriteria</label>
            <select name="kriteria" id="kriteria" class="form-select" required>
              <option value="">Pilih Kriteria</option>
              <option value="above" <?php echo (isset($_GET['kriteria']) && $_GET['kriteria'] === 'above') ? 'selected' : ''; ?>>Di Atas</option>
              <option value="below" <?php echo (isset($_GET['kriteria']) && $_GET['kriteria'] === 'below') ? 'selected' : ''; ?>>Di Bawah</option>
              <option value="equal" <?php echo (isset($_GET['kriteria']) && $_GET['kriteria'] === 'equal') ? 'selected' : ''; ?>>Sama Dengan</option>
              <option value="above_equal" <?php echo (isset($_GET['kriteria']) && $_GET['kriteria'] === 'above_equal') ? 'selected' : ''; ?>>Di Atas Sama Dengan</option>
              <option value="below_equal" <?php echo (isset($_GET['kriteria']) && $_GET['kriteria'] === 'below_equal') ? 'selected' : ''; ?>>Di Bawah Sama Dengan</option>
            </select>
          </div>

          <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Filter</button>
            <?php if (!empty($_GET)): ?>
              <a href="?" class="btn btn-secondary ms-2">Reset Filter</a>
            <?php endif; ?>
          </div>
        </form>


      </div>
    </div>

    <!-- Tabel Data -->
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>NPM</th>
            <th>Nama</th>
            <th>Divisi</th>
            <th>Angkatan</th>
            <th>Jurusan</th>
            <th>Fakultas</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $displayData = !empty($data['results']) ? $data['results'] : $data['tablePanitia'];
          ?>
          <?php if (!empty($displayData)): ?>
            <?php foreach ($displayData as $panitia): ?>
              <tr>
                <td><?= htmlspecialchars($panitia['npm']); ?></td>
                <td><?= htmlspecialchars($panitia['nama']); ?></td>
                <td><?= htmlspecialchars($panitia['divisi']); ?></td>
                <td><?= htmlspecialchars($panitia['angkatan']); ?></td>
                <td><?= htmlspecialchars($panitia['jurusan']); ?></td>
                <td><?= htmlspecialchars($panitia['fakultas'] ?? '-'); ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center">Tidak ada data yang ditemukan.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination Component -->
    <?php include __DIR__ . '/../../components/Pagination.php'; ?>
  </section>
</main>

<?php include __DIR__ . '/../../components/partials/Footer.php'; ?>