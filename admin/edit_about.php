<?php
require_once 'config/about.php';

// Create an instance of the About class
$about = new About();

// Fetch the ID from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = $about->getAboutData($id);
} else {
    die("ID not provided.");
}

// Handle form submission to update the data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    // Get updated form data
    $section_title = $_POST['section_title'];
    $story_title = $_POST['story_title'];
    $story_content = $_POST['story_content'];
    $mission_title = $_POST['mission_title'];
    $mission_content = $_POST['mission_content'];
    $quote = $_POST['quote'];
    $quote_author = $_POST['quote_author'];
    $team_title = $_POST['team_title'];
    $team_content = $_POST['team_content'];

    // Check if files were uploaded; if not, keep the old images
    $story_image = isset($_FILES['story_image']) ? $_FILES['story_image'] : null;
    $mission_image = isset($_FILES['mission_image']) ? $_FILES['mission_image'] : null;
    $team_image = isset($_FILES['team_image']) ? $_FILES['team_image'] : null;

    // Update data in the database
    $about->updateAboutData($id, $section_title, $story_title, $story_content, $mission_title, $mission_content, $quote, $quote_author, $story_image, $mission_image, $team_title, $team_content, $team_image);

    echo "Data has been updated successfully!";
    // Redirect to the main page or preview page
    header("Location: aboutcontent.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
  
<?php include 'components/head.php'; ?>
  
  <body>
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <?php include 'components/meun.php'; ?>
        <div class="layout-page">
          <?php include 'components/navbar.php'; ?>
          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="col-xxl">
                <div class="card mb-4">
                  <div class="card-header">
                    <h5 class="mb-0 text-center">Edit About Page</h5>
                  </div>
                  <div class="card-body">
                    <!-- Form to Edit Data -->
                    <form method="POST" enctype="multipart/form-data">
                      <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="section_title">Section Title:</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="section_title" id="section_title" value="<?= htmlspecialchars($data['section_title']); ?>" required>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="story_title">Story Title:</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="story_title" id="story_title" value="<?= htmlspecialchars($data['story_title']); ?>" required>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="story_content">Story Content:</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" name="story_content" id="story_content" rows="2" required><?= htmlspecialchars($data['story_content']); ?></textarea>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="mission_title">Mission Title:</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="mission_title" id="mission_title" value="<?= htmlspecialchars($data['mission_title']); ?>" required>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="mission_content">Mission Content:</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" name="mission_content" id="mission_content" rows="2" required><?= htmlspecialchars($data['mission_content']); ?></textarea>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="quote">Quote:</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" name="quote" id="quote" rows="2" required><?= htmlspecialchars($data['quote']); ?></textarea>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="quote_author">Quote Author:</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="quote_author" id="quote_author" value="<?= htmlspecialchars($data['quote_author']); ?>" required>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="team_title">Team Title:</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="team_title" id="team_title" value="<?= htmlspecialchars($data['team_title']); ?>" required>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="team_content">Team Content:</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" name="team_content" id="team_content" rows="2" required><?= htmlspecialchars($data['team_content']); ?></textarea>
                        </div>
                      </div>

                      <!-- File Upload Fields (Optional, show current file names) -->
                      <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="story_image">Story Image:</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="file" name="story_image" id="story_image">
                          <?php if (!empty($data['story_image'])): ?>
                            <img src="<?php echo $data['story_image']; ?>" alt="Current Image" width="100">
                          <?php endif; ?>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="mission_image">Mission Image:</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="file" name="mission_image" id="mission_image">
                          <?php if (!empty($data['mission_image'])): ?>
                            <img src="<?php echo $data['mission_image']; ?>" alt="Current Image" width="100">
                            
                          <?php endif; ?>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="team_image">Team Image:</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="file" name="team_image" id="team_image">
                          <?php if (!empty($data['team_image'])): ?>
                            <img src="<?php echo $data['team_image']; ?>" alt="Current Image" width="100">
                          <?php endif; ?>
                        </div>
                      </div>

                      <!-- Submit Button -->
                      <div class="row justify-content-end">
                        <div class="col-sm-10">
                          <button type="submit" name="update" class="btn btn-primary">Update</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </body>
</html>

 <?php include 'components/script.php' ?>