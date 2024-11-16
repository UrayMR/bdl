<?php
session_start();
include 'connection.php';

$data_page = 10;

$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $data_page;

$filter_column = "";
$filter_value = "";

if (isset($_GET['filter']) && isset($_GET['value'])) {
    $filter_column = $_GET['filter'];
    $filter_value = $_GET['value'];
}

$total_records_query = "SELECT COUNT(*) AS total FROM data";
if ($filter_column && $filter_value) {
    $total_records_query .= " WHERE $filter_column = '$filter_value'";
}
$total_records_result = mysqli_query($conn, $total_records_query);
$total_records_row = mysqli_fetch_assoc($total_records_result);
$total_records = $total_records_row['total'];

$total_pages = ceil($total_records / $data_page);

$query = "SELECT * FROM data";
if ($filter_column && $filter_value) {
    $query .= " WHERE $filter_column = '$filter_value'";
}
$query .= " LIMIT $offset, $data_page";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <header class="p-6 bg-blue-600 text-white text-center">
        <h1>Data Panitia Fasilkom Lego 2024</h1>
    </header>

    <main class="p-8">
        <section class="mb-6">
            <form method="GET" class="flex justify-center space-x-4">
                <div>
                    <label for="filter" class="block text-sm font-medium text-gray-700">Filter Berdasarkan</label>
                    <select name="filter" id="filter" class="px-4 py-2 rounded border border-gray-300">
                        <option value="angkatan" <?php echo ($filter_column == 'angkatan') ? 'selected' : ''; ?>>Angkatan</option>
                        <option value="divisi" <?php echo ($filter_column == 'divisi') ? 'selected' : ''; ?>>Divisi</option>
                    </select>
                </div>
                <div>
                    <label for="value" class="block text-sm font-medium text-gray-700">Nilai</label>
                    <input type="text" name="value" id="value" value="<?php echo htmlspecialchars($filter_value); ?>" class="px-4 py-2 rounded border border-gray-300">
                </div>
                <div class="mt-5">
                    <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Filter</button>
                </div>
            </form>
        </section>

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
                <a href="?page=<?php echo max(1, $current_page - 1); ?>&filter=<?php echo $filter_column; ?>&value=<?php echo urlencode($filter_value); ?>" 
                   class="px-4 py-2 rounded <?php echo ($current_page == 1) ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-blue-500 hover:bg-blue-700 text-white'; ?>">
                    Previous
                </a>

                <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                    <a href="?page=<?php echo $page; ?>&filter=<?php echo $filter_column; ?>&value=<?php echo urlencode($filter_value); ?>" 
                       class="px-4 py-2 rounded <?php echo ($page == $current_page) ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-blue-100 text-blue-600'; ?>">
                        <?php echo $page; ?>
                    </a>
                <?php endfor; ?>

                <a href="?page=<?php echo min($total_pages, $current_page + 1); ?>&filter=<?php echo $filter_column; ?>&value=<?php echo urlencode($filter_value); ?>" 
                   class="px-4 py-2 rounded <?php echo ($current_page == $total_pages) ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-blue-500 hover:bg-blue-700 text-white'; ?>">
                    Next
                </a>
            </div>
        </section>
    </main>
</body>
</html>
