<nav aria-label="Pagination">
  <ul class="pagination justify-content-center">
    <!-- Previous Page -->
    <li class="page-item <?php echo ($currentPage == 1) ? 'disabled' : ''; ?>">
      <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>"
        >Previous</a
      >
    </li>

    <!-- Pages -->
    <?php for ($page = 1; $page <= $totalPages; $page++): ?>
    <li
      class="page-item <?php echo ($page == $currentPage) ? 'active' : ''; ?>"
    >
      <a class="page-link" href="?page=<?php echo $page; ?>"
        ><?php echo $page; ?></a
      >
    </li>
    <?php endfor; ?>

    <!-- Next Page -->
    <li
      class="page-item <?php echo ($currentPage == $totalPages) ? 'disabled' : ''; ?>"
    >
      <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>">Next</a>
    </li>
  </ul>
</nav>
