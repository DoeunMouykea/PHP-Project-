<?php
require_once 'config/about.php'; // Include the About class
// Create an instance of the About class
$about = new About();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $section_title = $_POST['section_title'];
    $story_title = $_POST['story_title'];
    $story_content = $_POST['story_content'];
    $mission_title = $_POST['mission_title'];
    $mission_content = $_POST['mission_content'];
    $quote = $_POST['quote'];
    $quote_author = $_POST['quote_author'];
    $team_title = $_POST['team_title'];
    $team_content = $_POST['team_content'];

    // Handle file uploads correctly
    $story_image = $_FILES['story_image'];
    $mission_image = $_FILES['mission_image'];
    $team_image = $_FILES['team_image'];

    // Create an instance of the About class
    $about = new About();

    // Insert data into the about_us table
    $about->insertAboutData($section_title, $story_title, $story_content, $mission_title, $mission_content, $quote, $quote_author, $story_image, $mission_image, $team_title, $team_content, $team_image);

    echo "Data has been inserted successfully!";
}
    // Check if the 'id' is set in the URL to delete a specific record
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Call the delete method from the About class
        if ($about->deleteAboutData($id)) {
            echo "Data has been deleted successfully!";
            // Redirect back to the main page or the list of entries after deletion
            header("Location: aboutcontent.php");
            exit;
        } else {
            echo "Error deleting record!";
        }
}
    // Fetch all data to show the preview
    $aboutData = $about->getAllAboutData();
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
                <div class="card-header">
                  <h5 class="mb-0 text-center">Create About page</h5>
                  <div class="card-body">
                  <form method="POST" enctype="multipart/form-data">
                      <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="section_title">Section Title:</label>
                          <div class="col-sm-10">
                              <input class="form-control" type="text" name="section_title" id="section_title" required>
                          </div>
                      </div>
                      <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="story_title">Story Title:</label>
                          <div class="col-sm-10">
                              <input class="form-control" type="text" name="story_title" id="story_title" required>
                          </div>
                      </div>
                      <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="story_content">Story Content:</label>
                          <div class="col-sm-10">
                              <textarea class="form-control" name="story_content" id="story_content" rows="2" required></textarea>
                          </div>
                      </div>
                      <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="mission_title">Mission Title:</label>
                          <div class="col-sm-10">
                              <input class="form-control" type="text" name="mission_title" id="mission_title" required>
                          </div>
                      </div>
                      <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="mission_content">Mission Content:</label>
                          <div class="col-sm-10">
                              <textarea class="form-control" name="mission_content" id="mission_content" rows="2" required></textarea>
                          </div>
                      </div>
                      <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="team_title">Team Title:</label>
                          <div class="col-sm-10">
                              <input class="form-control" type="text" name="team_title" id="team_title" required>
                          </div>
                      </div>
                      <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="team_content">Team Content:</label>
                          <div class="col-sm-10">
                              <textarea class="form-control" name="team_content" id="team_content" rows="2" required></textarea>
                          </div>
                      </div>
                      <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="quote">Quote:</label>
                          <div class="col-sm-10">
                              <textarea class="form-control" name="quote" id="quote" rows="2" required></textarea>
                          </div>
                      </div>
                      <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="quote_author">Quote Author:</label>
                          <div class="col-sm-10">
                              <input class="form-control" type="text" name="quote_author" id="quote_author" required>
                          </div>
                      </div>
                      <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="story_image">Story Image:</label>
                          <div class="col-sm-10">
                              <input class="form-control" type="file" name="story_image" id="story_image" required>
                          </div>
                      </div>
                      <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="mission_image">Mission Image URL:</label>
                          <div class="col-sm-10">
                              <input class="form-control" type="file" name="mission_image" id="mission_image" required>
                          </div>
                      </div>    
                      <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="team_image">Team Image:</label>
                          <div class="col-sm-10">
                              <input class="form-control" type="file" name="team_image" id="team_image" required>
                          </div>
                      </div>               
                     <div class="row justify-content-end">
                          <div class="col-sm-10">
                              <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                          </div>
                      </div>
                  </form>

                  </div>
                </div>
              </div>
              <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0 text-center">Preview of Submitted Data</h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($aboutData)): ?>
                                <?php foreach ($aboutData as $data): ?>
                                    <div class="preview-section">
                                        <h4>Section Title: <?= htmlspecialchars($data['section_title']); ?></h4>
                                        <p><strong>Story Title:</strong> <?= htmlspecialchars($data['story_title']); ?></p>
                                        <p><strong>Story Content:</strong> <?= nl2br(htmlspecialchars($data['story_content'])); ?></p>
                                        <p><strong>Mission Title:</strong> <?= htmlspecialchars($data['mission_title']); ?></p>
                                        <p><strong>Mission Content:</strong> <?= nl2br(htmlspecialchars($data['mission_content'])); ?></p>
                                        <p><strong>Team Title:</strong> <?= htmlspecialchars($data['team_title']); ?></p>
                                        <p><strong>Team Content:</strong> <?= nl2br(htmlspecialchars($data['team_content'])); ?></p>
                                        <p><strong>Quote:</strong> <?= nl2br(htmlspecialchars($data['quote'])); ?></p>
                                        <p><strong>Quote Author:</strong> <?= htmlspecialchars($data['quote_author']); ?></p>

                                        <p><label class="col-sm-2 col-form-label" for="team_image">Story Image:</label><img src="<?= htmlspecialchars($data['story_image']); ?>" alt="Story Image" width="100"></p>
                                        <p><label class="col-sm-2 col-form-label" for="team_image">Mission Image:</label><img src="<?= htmlspecialchars($data['mission_image']); ?>" alt="Mission Image" width="100"></p>
                                        <p><label class="col-sm-2 col-form-label" for="team_image">Team Image:</label><img src="<?= htmlspecialchars($data['team_image']); ?>" alt="Team Image" width="100"></p>

                                        <!-- Edit and Delete buttons -->
                                        <div class="row justify-content-start">
                                        <div class="col-sm-10 mt-5">
                                        <a href="edit_about.php?id=<?= $data['id']; ?>" class="btn btn-warning">Edit</a>
                                        <a href="aboutcontent.php?id=<?= $data['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                                        </div>
                                        </div>
                                    </div>
                                    <hr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No data available to preview.</p>
                            <?php endif; ?>
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
