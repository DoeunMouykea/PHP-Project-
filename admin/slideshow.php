<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">
  
<?php include 'components/head.php'; ?>
<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <?php include 'components/meun.php'; ?>
      <div class="layout-page">
        <?php include 'components/navbar.php'; ?>

        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
            
            <div class="d-flex justify-content-end mb-3">
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSlideModal">Add Slideshow</button>
            </div>

            <!-- Modal for Adding Slideshow -->
            <div class="modal fade" id="addSlideModal" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Add Slideshow</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <form id="slideForm" method="POST" enctype="multipart/form-data">
                      <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" required></textarea>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Link</label>
                        <input type="text" name="link" class="form-control">
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                      </div>
                      <button type="submit" class="btn btn-success">Save</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal for Editing Slideshow -->
            <div class="modal fade" id="editSlideModal" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Slideshow</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <form id="editSlideForm" method="POST" enctype="multipart/form-data">
                      <input type="hidden" name="id" id="editSlideId">
                      <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="editTitle" class="form-control" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="editDescription" class="form-control" required></textarea>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Link</label>
                        <input type="url" name="link" id="editLink" class="form-control">
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                      </div>
                      <button type="submit" class="btn btn-success">Save Changes</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!-- Slideshow Table -->
            <div class="card">
              <h5 class="card-header text-center">Table Slideshow</h5>
              <div class="table-responsive text-nowrap">
                <table class="table">
                  <caption class="ms-4">List of slides</caption>
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Image</th>
                      <th>Title</th>
                      <th>Description</th>
                      <th>Link</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody id="slideTableBody">
                    <!-- Load slides from database -->
                    <?php
                    include 'config/slide.php';
                    $slide = new Slide();
                    $slides = $slide->getSlides();
                    foreach ($slides as $s) {
                      echo "<tr>
                        <td>{$s['id']}</td>
                        <td><img src='{$s['image']}' width='100'></td>
                        <td>{$s['title']}</td>
                        <td>" . substr($s['description'], 0, 30) . "</td>
                        <td><a href='{$s['link']}' target='_blank'>{$s['link']}</a></td>
                        <td>
                          <button class='btn btn-info btn-sm edit-slide' data-id='{$s['id']}' data-title='{$s['title']}' data-description='{$s['description']}' data-link='{$s['link']}' data-image='{$s['image']}'>Edit</button>
                          <button class='btn btn-danger btn-sm delete-slide' data-id='{$s['id']}'>Delete</button>
                        </td>
                      </tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include 'components/footer.php'; ?>
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

  <!-- Include jQuery -->
  <script src="assets/vendor/libs/jquery/jquery.js"></script>
  <script src="assets/vendor/js/bootstrap.js"></script>

  <script>
    $(document).ready(function () {
      // Open edit modal and populate form fields
      $(".edit-slide").click(function () {
        let id = $(this).data("id");
        let title = $(this).data("title");
        let description = $(this).data("description");
        let link = $(this).data("link");
        let image = $(this).data("image");

        $("#editSlideId").val(id);
        $("#editTitle").val(title);
        $("#editDescription").val(description);
        $("#editLink").val(link);

        // If an image exists, you can display it if necessary
        // e.g., set a preview of the image

        $("#editSlideModal").modal("show");
      });

       // Delete slide
    $(".delete-slide").click(function () {
      let slideId = $(this).data("id");
      
      if (confirm("Are you sure you want to delete this slide?")) {
        $.ajax({
          url: "slide.php", // PHP script that handles deleting
          type: "POST",
          data: {
            action: "delete",
            id: slideId
          },
          success: function (response) {
            let result = JSON.parse(response);
            if (result.success) {
              alert("Slide deleted successfully!");
              location.reload(); // Reload the page to update the table
            } else {
              alert("Error: " + result.error);
            }
          }
        });
      }
    });

      // Submit the edit form
      $("#editSlideForm").submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append("action", "update");

        $.ajax({
          url: "slide.php",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          success: function (response) {
            let result = JSON.parse(response);
            if (result.success) {
              alert("Slide updated successfully!");
              $("#editSlideModal").modal("hide");
              location.reload(); // Reload to update table
            } else {
              alert("Error: " + result.error);
            }
          }
        });
      });
    });
  </script>
</body>
</html>
