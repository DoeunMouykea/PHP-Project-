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
          <!-- Basic Bootstrap Table -->
          <div class="card">
                <h5 class="card-header text-center">Table Users</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Image</th>
                        <th>Registered</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <?php
                      // Fetch user data from the database
                      require_once 'config/user.php'; // Include the User class
                      $user = new User();
                      $users = $user->getUsers(); // Get all users

                      foreach ($users as $row) {
                          echo "<tr>";
                          echo "<td><i class='fab fa-angular fa-lg text-danger me-3'></i><strong>" . $row['username'] . "</strong></td>";
                          echo "<td>" . $row['email'] . "</td>";
                          echo "<td><ul class='list-unstyled users-list m-0 avatar-group d-flex align-items-center'><li class='avatar avatar-xs pull-up' title='" . $row['username'] . "'><img src='assets/img/avatars/5.png' alt='Avatar' class='rounded-circle'/></li></ul></td>";
                          echo "<td>" . $row['created_at'] . "</td>"; // Assuming there is a registered_at column
                          echo "<td><span class='badge bg-label-primary me-1'>Active</span></td>";
                          echo "<td><div class='dropdown'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu'><a class='dropdown-item' href='javascript:void(0);'><i class='bx bx-edit-alt me-1'></i> Edit</a><a class='dropdown-item' href='javascript:void(0);'><i class='bx bx-trash me-1'></i> Delete</a></div></div></td>";
                          echo "</tr>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Basic Bootstrap Table -->
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
