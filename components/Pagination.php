<?php if ($totalPages > 1): ?>
  <?php
  $queryParams = $_GET;
  unset($queryParams['page']);
  $queryString = '';
  if (!empty($queryParams)) {
    $queryString = '&' . http_build_query($queryParams);
  }
  ?>
  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
      <!-- Previous -->
      <li class="page-item <?php echo $currentPage <= 1 ? 'disabled' : ''; ?>">
        <a class="page-link" href="?page=<?php echo $currentPage - 1 . $queryString; ?>">
          Previous
        </a>
      </li>

      <!-- Page Numbers -->
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?php echo $i === $currentPage ? 'active' : ''; ?>">
          <a class="page-link" href="?page=<?php echo $i . $queryString; ?>">
            <?php echo $i; ?>
          </a>
        </li>
      <?php endfor; ?>

      <!-- Next -->
      <li class="page-item <?php echo $currentPage >= $totalPages ? 'disabled' : ''; ?>">
        <a class="page-link" href="?page=<?php echo $currentPage + 1 . $queryString; ?>">
          Next
        </a>
      </li>
    </ul>
  </nav>
<?php endif; ?>