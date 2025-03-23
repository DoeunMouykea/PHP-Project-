<?php
require_once 'config/article.php';

  // Initialize the result variable to avoid undefined variable warning
  $result = null;

  // Fetch articles
  $article = new Article();
  $articles = $article->getArticles(); // Fetch all articles

  // Insert article if form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $result = $article->insertArticle($_POST['title'], $_POST['content'], $_POST['category'], $_FILES['image']); 
      // After inserting, refetch all articles to include the new one
      $articles = $article->getArticles(); 
      echo "<script>window.location.href='blogcontent.php';</script>";
  }

  // Check if an ID is provided via GET method
  if (isset($_GET['id'])) {
    $articleId = $_GET['id'];

    // Call the delete method to remove the article
    if ($article->deleteArticle($articleId)) {
        // Redirect to the main page (or articles list) after successful deletion
        
        header("Location: blogcontent.php");
        exit();
    } else {
        // If there was an error
        echo "Error deleting article.";
    }
  } else {
    echo "Invalid request.";
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
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="col-xxl">
                <div class="card mb-4">
                  <div class="card-header text-center">
                    <h5 class="mb-0">Create Blog Page</h5>
                  </div>
                  <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                      <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="section_title">Title:</label>
                          <div class="col-sm-10">
                              <input class="form-control" type="text" name="title" required>
                          </div>
                      </div>
                      <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="mission_title">Category:</label>
                          <div class="col-sm-10">
                            <input class="form-control" name="category" rows="5" required>
                          </div>
                      </div> 
                      <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="story_title">Content:</label>
                          <div class="col-sm-10">
                            <textarea class="form-control" name="content" rows="5" required></textarea>
                          </div>
                      </div>      
                      <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="story_image">Image:</label>
                          <div class="col-sm-10">
                              <input class="form-control" type="file" name="image" id="story_image" required>
                          </div>
                      </div>
                      <div class="row justify-content-end">
                          <div class="col-sm-10">
                              <button type="submit" class="btn btn-primary">Add Article</button>
                          </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div> 
              
              <!-- Display Articles Table -->
              <div class="card mb-4">
                <div class="card-header text-center">
                  <h5 class="mb-0">Article List</h5>
                </div>
                <div class="card-body">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Content</th>
                        <th>Image</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($articles as $article): ?>
                        <tr>
                          <td><?php echo $article['id']; ?></td>
                          <td><?php echo $article['title']; ?></td>
                          <td><?php echo $article['category']; ?></td>
                          <td><?php echo substr($article['content'], 0, 50) . '...'; ?></td>
                          <td><img src="<?php echo $article['image']; ?>" alt="Image" width="100"></td>
                          <td>
                            <!-- Action buttons (Edit, Delete) -->
                            <a href="edit_article.php?id=<?php echo $article['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="blogcontent.php?id=<?php echo $article['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/js/menu.js"></script>

    <!-- Vendors JS -->
    <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="assets/js/dashboards-analytics.js"></script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
