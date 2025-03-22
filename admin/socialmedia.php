<?php
require_once 'config/db.php';
require_once 'config/socialmedia.php';

// Get database connection
$database = Database::getInstance();
$db = $database->getConnection();

// Fetch existing records from the database
$socialMedia = new SocialMedia();
$socialMediaData = $socialMedia->getAllSocialMedia();

?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">

<?php include 'components/head.php'; ?>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include 'components/meun.php'; ?>
            <div class="layout-page">
                <?php include 'components/navbar.php'; ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                    
                        <!-- Add/Edit Form (Now Positioned on Top) -->
                        <div id="socialMediaForm" class="card mb-4" style="display: none;">
                            <div class="card-header">
                                <h5 id="formTitle">Add URL Social Media</h5>
                            </div>
                            <div class="card-body">
                                <form id="saveForm">
                                    <input type="hidden" name="id" id="recordId">
                                    
                                    <div class="mb-3">
                                        <label>Facebook</label>
                                        <input type="url" name="facebook" id="facebook" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>YouTube</label>
                                        <input type="url" name="youtube" id="youtube" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Twitter</label>
                                        <input type="url" name="twitter" id="twitter" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Telegram</label>
                                        <input type="url" name="telegram" id="telegram" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Another URL</label>
                                        <input type="url" name="another_url" id="another_url" class="form-control">
                                    </div>
                                    
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" onclick="hideForm()">Cancel</button>
                                </form>
                            </div>
                        </div>

                        <!-- Table (Below the Form) -->
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5>Social Media URLs</h5>
                                <button class="btn btn-primary" onclick="showForm()">Add New</button>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Facebook</th>
                                            <th>YouTube</th>
                                            <th>Twitter</th>
                                            <th>Telegram</th>
                                            <th>Another URL</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="socialMediaTable">
                                        <?php foreach ($socialMediaData as $row): ?>
                                            <tr id="row-<?= $row['id']; ?>">
                                                <td><?= htmlspecialchars($row['id']); ?></td>
                                                <td><?= htmlspecialchars($row['facebook']); ?></td>
                                                <td><?= htmlspecialchars($row['youtube']); ?></td>
                                                <td><?= htmlspecialchars($row['twitter']); ?></td>
                                                <td><?= htmlspecialchars($row['telegram']); ?></td>
                                                <td><?= htmlspecialchars($row['another_url']); ?></td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm" 
                                                        onclick="editRecord(<?= $row['id']; ?>, '<?= $row['facebook']; ?>', '<?= $row['youtube']; ?>', '<?= $row['twitter']; ?>', '<?= $row['telegram']; ?>', '<?= $row['another_url']; ?>')">
                                                        Edit
                                                    </button>

                                                    <button class="btn btn-danger btn-sm" onclick="deleteRecord(<?= $row['id']; ?>)">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <?php include 'components/footer.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script>
        // Show the form to add/edit social media URLs
        function showForm() {
            document.getElementById('socialMediaForm').style.display = 'block';
            document.getElementById('formTitle').textContent = 'Add URL Social Media';
            document.getElementById('recordId').value = '';
            document.getElementById('saveForm').reset();
        }

        // Hide the form
        function hideForm() {
            document.getElementById('socialMediaForm').style.display = 'none';
        }

        // Populate form with existing data for editing
        function editRecord(id, facebook, youtube, twitter, telegram, another_url) {
            document.getElementById('socialMediaForm').style.display = 'block';
            document.getElementById('formTitle').textContent = 'Edit URL Social Media';
            document.getElementById('recordId').value = id;
            document.getElementById('facebook').value = facebook;
            document.getElementById('youtube').value = youtube;
            document.getElementById('twitter').value = twitter;
            document.getElementById('telegram').value = telegram;
            document.getElementById('another_url').value = another_url;
        }

        // Save or update the social media URLs
        $('#saveForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize() + '&action=save'; // Add action=save to the form data

            $.ajax({
                url: 'config/socialmedia.php',
                method: 'POST',
                data: formData,
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.status == 'success') {
                        alert(result.message);
                        location.reload(); // Reload the page to reflect changes
                    }
                },
                error: function() {
                    alert('Error saving data!');
                }
            });
        });

        // Delete record
        function deleteRecord(id) {
            if (confirm('Are you sure you want to delete this record?')) {
                $.ajax({
                    url: 'config/socialmedia.php',
                    method: 'POST',
                    data: { id: id, action: 'delete' }, // Add action=delete to the data
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.status == 'success') {
                            alert(result.message);
                            $('#row-' + id).remove(); // Remove the row from the table
                        }
                    },
                    error: function() {
                        alert('Error deleting data!');
                    }
                });
            }
        }
    </script>

</body>
</html>
