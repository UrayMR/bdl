<?php
session_start();
include 'connection.php';

$data_page = 10;

$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$offset = ($current_page - 1) * $data_page;

$total_records_query = "SELECT COUNT(*) AS total FROM data";
$total_records_result = mysqli_query($conn, $total_records_query);
$total_records_row = mysqli_fetch_assoc($total_records_result);
$total_records = $total_records_row['total'];

$total_pages = ceil($total_records / $data_page);

$query = "SELECT * FROM data LIMIT $offset, $data_page";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BDL</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-gray-100">
    <header class="p-6 bg-blue-600 text-white text-center">
      <h1>Data Panitia Fasilkom Lego 2024</h1>
    </header>

    <main class="p-8">
      <section class="table w-full max-w-4xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr>
              <th class="p-3 border-b-2 border-gray-200">NPM</th>
              <th class="p-3 border-b-2 border-gray-200">Nama</th>
              <th class="p-3 border-b-2 border-gray-200">Divisi</th>
              <th class="p-3 border-b-2 border-gray-200">Angkatan</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td class='p-3 border-b'>" . htmlspecialchars($row['npm']) . "</td>";
                echo "<td class='p-3 border-b'>" . htmlspecialchars($row['nama']) . "</td>";
                echo "<td class='p-3 border-b'>" . htmlspecialchars($row['divisi']) . "</td>";
                echo "<td class='p-3 border-b'>" . htmlspecialchars($row['angkatan']) . "</td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='4' class='p-3 text-center'>No users found</td></tr>";
            }
            ?>
          </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination flex justify-center space-x-4 p-4">
          <a href="?page=<?php echo max(1, $current_page - 1); ?>" 
             class="px-4 py-2 rounded <?php echo ($current_page == 1) ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-blue-500 text-white'; ?>">
            Previous
          </a>

          <?php for ($page = 1; $page <= $total_pages; $page++): ?>
            <a href="?page=<?php echo $page; ?>" 
               class="px-4 py-2 rounded <?php echo ($page == $current_page) ? 'bg-blue-600 text-white' : 'bg-gray-200 text-blue-600'; ?>">
              <?php echo $page; ?>
            </a>
          <?php endfor; ?>

          <a href="?page=<?php echo min($total_pages, $current_page + 1); ?>" 
             class="px-4 py-2 rounded <?php echo ($current_page == $total_pages) ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-blue-500 text-white'; ?>">
            Next
          </a>
        </div>
      </section>
    </main>
  </body>
</html>
