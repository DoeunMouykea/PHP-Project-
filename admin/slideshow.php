<?php
include 'config/slide.php';
$slide = new Slide();
$slides = $slide->getSlides();

// Handle insert
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['title'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $link = $_POST['link'];
    $order_number = $_POST['order_number'];
    $image = $_FILES['image'];

    $result = $slide->insertSlide($title, $description, $link, $image, $order_number);
    header("Location: slideshow.php");
    exit;
}

// Handle update
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $link = $_POST['link'];
  $order_number = $_POST['order_number'];
  $image = isset($_FILES['image']) && $_FILES['image']['size'] > 0 ? $_FILES['image'] : null;

  $result = $slide->updateSlide($id, $title, $description, $link, $image, $order_number);
  
  // Return JSON response for AJAX
  header('Content-Type: application/json');
  echo json_encode($result);
  exit;
}

// Handle delete
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $result = $slide->deleteSlide($id);
    header("Location: slideshow.php");
    exit;
}

?>
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
                        <label class="form-label">Order Number</label>
                        <input type="number" name="order_number" class="form-control" required>
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
                            <input type="text" name="link" id="editLink" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Order Number</label>
                            <input type="number" name="order_number" id="editOrderNumber" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <img id="editPreviewImage" src=" " width="100" class="mt-2">
                        </div>
                        <button type="submit" class="btn btn-success">Update</button>
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
                    <th>Number</th>
                      <th>Image</th>
                      <th>Title</th>
                      <th>Description</th>                    
                      <th>Link</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody id="slideTableBody">
                    <?php
                    
                    foreach ($slides as $s) {
                      echo "<tr>
                        <td>{$s['order_number']}</td>
                        <td><img src='images/{$s['image']}' width='100'></td>
                        <td>{$s['title']}</td>
                        <td>" . substr($s['description'], 0, 30) . "</td>                      
                        <td><a href='{$s['link']}' target='_blank'>{$s['link']}</a></td>
                        <td>
                          <button class='btn btn-info btn-sm edit-slide' 
                              data-id='{$s['id']}' 
                              data-title='{$s['title']}' 
                              data-description='{$s['description']}' 
                              data-link='{$s['link']}' 
                              data-image='{$s['image']}' 
                              data-order_number='{$s['order_number']}'>
                              Edit
                          </button>
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

  <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-slide").forEach(function (button) {
            button.addEventListener("click", function () {
                let slideId = this.getAttribute("data-id");

                if (confirm("Are you sure you want to delete this slide?")) {
                    window.location.href = "?delete=" + slideId;
                }
            });
        });
    });

    $(document).on("click", ".edit-slide", function () {
        let slide = $(this).data();
        $("#editSlideId").val(slide.id);
        $("#editTitle").val(slide.title);
        $("#editDescription").val(slide.description);
        $("#editLink").val(slide.link);
        $("#editOrderNumber").val(slide.order_number);
        $("#editPreviewImage").attr("src", "images/" + slide.image);
        
        // Show the edit modal
        $("#editSlideModal").modal("show");
    });
    // Submit the update form
    $("#editSlideForm").submit(function (e) {
          e.preventDefault();

          let formData = new FormData(this);

          $.ajax({
              url: "slideshow.php",  // Ensure the correct PHP file is called for updating the slide
              type: "POST",
              data: formData,
              processData: false,
              contentType: false,
              success: function (response) {
                  location.reload(); // Reload the page to see the changes
              },
              error: function () {
                  alert("Error updating slide.");
              }
          });
      });

  </script>
  
</body>
</html>
