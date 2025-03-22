<?php
require_once "config/book.php";
$book = new Book();
$books = $book->getBooks();
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">
  
<?php include 'components/head.php' ?>
  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
      <?php include 'components/meun.php' ?>
        <!-- Layout container -->
        <div class="layout-page">
        <?php include 'components/navbar.php' ?>

          <!-- Content wrapper -->
          <div class="content-wrapper">
         
            <div class="container-xxl flex-grow-1 container-p-y">
            <div class="">
                    <div class="w-50 align-items-end row">
                      <div class="col-sm-7">
                        <div class="card-body">
                         

                          <a
                            href="create.php"
                            class="btn btn-sm btn-outline-primary"
                            >Add Product</a
                          >
                        </div>
                      </div>
                      <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                          <img
                            src="assets/img/illustrations/man-with-laptop-light.png"
                            height="140"
                            alt="View Badge User"
                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                            data-app-light-img="illustrations/man-with-laptop-light.png"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
             <!-- Bootstrap Table with Header - Dark -->
             <div class="card">
            
                <h5 class="card-header text-center">Table Products</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead class="table-dark">
                      <tr>
                        <th >ID</th>
                        <th width="30%">Images</th>
                        <th width="10%">Title</th>
                        <th>Authors</th>
                        <th>Genre</th>
                        <th>Prices</th>
                        <th>Types</th>
                        <th>Stock</th>
                        <th width="50%">Description</th>
                        <th width="20%">Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <?php foreach ($books as $b): ?>
                      <tr>
                        <td>
                          <i class="fab fa-angular fa-lg text-danger me-3"></i>
                          <strong><?= $b['id'] ?></strong>
                        </td>                        
                        <td>
                          <ul
                            class="list-unstyled users-list m-0 avatar-group d-flex align-items-center"
                          >
                            <li>
                              <img
                                src="<?= $b['image'] ?>"
                                alt="Book Image"
                                width="50%"
                              />
                            </li>
                           
                          </ul>
                        </td>
                        <td><strong><?= htmlspecialchars(substr($b['title'], 0, 20)) ?></strong></td>
                        <td><?= htmlspecialchars(substr($b['author'], 0, 10)) ?></td>
                        <td><?= htmlspecialchars(substr($b['genre'], 0, 10)) ?></td>
                        <td>
                          <i class="fab fa-angular fa-lg text-danger me-3"></i>
                          <strong><?= number_format($b['price'], 2) ?></strong>
                        </td>
                        <td><?= htmlspecialchars($b['type']) ?></td>
                        <td>
                        <i class="fab fa-angular fa-lg text-danger me-3"></i>
                          <strong><?= $b['stock'] ?></strong>
                        </td>
                        <td>
                        <i class="fab fa-angular fa-lg me-2">
                        <?= nl2br(htmlspecialchars(substr($b['description'], 0, 20))) ?>...</i>
                        </td>
                        <td>
                          <div class="dropdown">
                            <button
                              type="button"
                              class="btn p-0 dropdown-toggle hide-arrow"
                              data-bs-toggle="dropdown"
                            >
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a
                                class="dropdown-item"
                                href="edit.php?id=<?= $b['id'] ?>"
                                ><i class="bx bx-edit-alt me-1"></i> Edit</a
                              >
                              <a
                                class="dropdown-item"
                                href="config/delete.php?id=<?= $b['id'] ?>" onclick="return confirm('Are you sure?')"
                                ><i class="bx bx-trash me-1"></i> Delete</a
                              >
                            </div>
                          </div>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Bootstrap Table with Header Dark -->
              

         
              <?php include 'components/footer.php' ?>

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-"></div>
    </div>
    <!-- / Layout wrapper -->

    

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
