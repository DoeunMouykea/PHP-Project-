<?php
require_once "config/book.php";

$book = new Book();

// Get book details by ID
if (isset($_GET['id'])) {
    $bookId = $_GET['id'];
    $bookDetails = $book->getBookById($bookId);
    
    if (!$bookDetails) {
        die("Book not found!");
    }
}

// Update book details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    $image = $bookDetails['image']; // Default to the old image

    // Ensure uploads folder exists
    $targetDir = "upload/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Create directory if not exists
    }

    $image = $targetDir . basename($_FILES["image"]["name"]);
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $image)) {
        echo "File uploaded successfully!";
    } else {
        echo "Failed to upload file!";
    }


    // Update the book
    $book->updateBook($bookId, $title, $author, $genre, $type, $price, $stock, $description, $image);
    
    echo "<p style='color:green;'>Book updated successfully!</p>";
    header("Location: product.php"); 
    exit();
    // Refresh book details
    $bookDetails = $book->getBookById($bookId);
}
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
          <!-- Basic Layout -->
          <div class="col-xxl">
                  <div class="card mb-4">
                    <div class="card-header   ">
                      <h5 class="mb-0 text-center">Edit Product</h5>
                     
                    </div>
                    <div class="card-body">
                      <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Title</label>
                          <div class="col-sm-10">
                            <input type="text" name="title" value="<?= htmlspecialchars($bookDetails['title']) ?>" class="form-control" id="basic-default-name" placeholder="Product name" />
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Author</label>
                          <div class="col-sm-10">
                            <input type="text" name="author" value="<?= htmlspecialchars($bookDetails['author']) ?>" class="form-control" id="basic-default-name" placeholder="Product name" />
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Genre</label>
                          <div class="col-sm-10">
                            <input type="text" name="genre" value="<?= htmlspecialchars($bookDetails['genre']) ?>" class="form-control" id="basic-default-name" placeholder="Product name" />
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-company">Price</label>
                          <div class="col-sm-10">
                          <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input
                          type="number"
                          name="price"
                          value="<?= $bookDetails['price'] ?>"
                          class="form-control"
                          placeholder="Amount"
                          aria-label="Amount (to the nearest dollar)"
                        />
                        <span class="input-group-text">.00</span>
                      </div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-email">Image</label>
                          <div class="col-sm-10">
                            <div class="input-group input-group-merge">              
                            <img src="<?= $bookDetails['image'] ?>" width="40px"><br><br>
                            <input class="form-control" type="file" name="image" id="formFile" accept="image/*"/>
                            </div>
                           
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-phone">Type</label>
                          <div class="col-sm-10">
                          <div class="input-group">
                            <select class="form-select" name="type" id="inputGroupSelect02">
                              <option selected>Choose...</option>
                              <option value="Business" <?= $bookDetails['type'] == 'Business' ? 'selected' : '' ?>>Business</option>
                              <option value="Technology" <?= $bookDetails['type'] == 'Technology' ? 'selected' : '' ?>>Technology</option>
                              <option value="Romantic" <?= $bookDetails['type'] == 'Romantic' ? 'selected' : '' ?>>Romantic</option>
                              <option value="Adventure" <?= $bookDetails['type'] == 'Adventure' ? 'selected' : '' ?>>Adventure</option>
                              <option value="Fictional"> <?= $bookDetails['type'] == 'Fictional' ? 'selected' : '' ?>Fictional</option>
                              <option value="Novel" <?= $bookDetails['type'] == 'Novel' ? 'selected' : '' ?>>Novel</option>
                              <option value="History" <?= $bookDetails['type'] == 'History' ? 'selected' : '' ?>>History</option>
                            </select>
                            <label class="input-group-text" for="inputGroupSelect02">Options</label>
                          </div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-phone">Stock</label>
                          <div class="col-sm-10">
                          <div class="input-group">
                          <input class="form-control" type="number" name="stock" value="<?= $bookDetails['stock'] ?>" />
                          </div>
                          </div>
                        </div>                       
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-message">Description</label>
                          <div class="col-sm-10">
                            <textarea
                              name="description"
                              id="basic-default-message"
                              class="form-control"
                              placeholder="Description something special of products"
                              aria-label="Description something special of products"
                              aria-describedby="basic-icon-default-message2"
                            ><?= htmlspecialchars($bookDetails['description']) ?></textarea>
                          </div>
                        </div>
                        <div class="row justify-content-end">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">UPDATE</button>
                          </div>
                          
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
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
