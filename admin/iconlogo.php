
<?php
require_once 'config/db.php'; 
require_once 'config/store.php'; 
// Create a Store instance
$store = new Store();

// Fetch the latest store details
$storeDetails = $store->getStoreDetails();
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
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
             

              <!-- Basic Layout & Basic with Icons -->
              <div class="row">
                <!-- Basic Layout -->
                <div class="col-xxl">
                  <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">About store </h5>
                     
                    </div>
                    <div class="card-body">
                      <form action="store_process.php" method="POST" enctype="multipart/form-data">
                          <div class="row mb-3">
                              <label class="col-sm-3 col-form-label">Meta Title</label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control" name="meta_title" placeholder="Store name" required />
                              </div>
                          </div>

                          <div class="row mb-3">
                              <label class="col-sm-3 col-form-label">Meta Tag Keywords</label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control" name="meta_keywords" placeholder="Keywords" required />
                              </div>
                          </div>

                          <div class="row mb-3">
                              <label class="col-sm-3 col-form-label">Email</label>
                              <div class="col-sm-9">
                                  <input type="email" class="form-control" name="email" placeholder="example@store.com" required />
                              </div>
                          </div>

                          <div class="row mb-3">
                              <label class="col-sm-3 col-form-label">Meta Description</label>
                              <div class="col-sm-9">
                                  <textarea class="form-control" name="meta_description" placeholder="Enter description" required></textarea>
                              </div>
                          </div>
                          <div class=" d-flex align-items-center justify-content-between">
                            <h5 class="mb-5">Store Logo & Icons of store</h5>
                          </div>
                          <div class="row mb-3">
                              <label class="col-sm-3 col-form-label">Favicon</label>
                              <div class="col-sm-9">
                                  <input type="file" name="favicon" class="form-control" accept="image/*" required />
                              </div>
                          </div>

                          <div class="row mb-3">
                              <label class="col-sm-3 col-form-label">Store Icon</label>
                              <div class="col-sm-9">
                                  <input type="file" name="store_icon" class="form-control" accept="image/*" required />
                              </div>
                          </div>

                          <div class="row mb-3">
                              <label class="col-sm-3 col-form-label">Logo</label>
                              <div class="col-sm-9">
                                  <input type="file" name="logo" class="form-control" accept="image/*" required />
                              </div>
                          </div>

                          <div class="row justify-content-end">
                              <div class="col-sm-12">
                                  <button type="submit" class="btn btn-primary">Submit</button>
                              </div>
                          </div>
                      </form>

                    </div>
                  </div>
                </div>
                <div class="col-xxl">
                  <div class="card mb-4">
                    <div class=" d-flex align-items-center justify-content-between">
                     
                     
                    </div>
                    <div class="card-body">
                    <h5 class="mb-0">About store preview</h5>
                      <form action="store_process.php" method="POST" enctype="multipart/form-data">
                        <div id="formPreview" class="mt-4">
                          <!-- Display database data in the preview section -->
                          <p><strong>Meta Title:</strong> <span id="previewMetaTitle"><?php echo htmlspecialchars($storeDetails['meta_title']); ?></span></p>
                          <p><strong>Meta Tag Keywords:</strong> <span id="previewMetaKeywords"><?php echo htmlspecialchars($storeDetails['meta_keywords']); ?></span></p>
                          <p><strong>Email:</strong> <span id="previewEmail"><?php echo htmlspecialchars($storeDetails['email']); ?></span></p>
                          <p><strong>Meta Description:</strong> <span id="previewMetaDescription"><?php echo htmlspecialchars($storeDetails['meta_description']); ?></span></p>
                          
                          <p><strong>Favicon </strong>
                            <?php if ($storeDetails['favicon']): ?>
                              <img id="previewFavicon" src="<?php echo $storeDetails['favicon']; ?>" alt="Favicon Preview" width="80" height="80" />
                            <?php else: ?>
                              <span>No favicon uploaded</span>
                            <?php endif; ?>
                          </p>
                          
                          <p><strong>Icon </strong>
                            <?php if ($storeDetails['store_icon']): ?>
                              <img id="previewStoreIcon" src="<?php echo $storeDetails['store_icon']; ?>" alt="Store Icon Preview" width="80" height="80" />
                            <?php else: ?>
                              <span>No store icon uploaded</span>
                            <?php endif; ?>
                          </p>

                          <p><strong>Logo</strong>
                            <?php if ($storeDetails['logo']): ?>
                              <img id="previewLogo" src="<?php echo $storeDetails['logo']; ?>" alt="Logo Preview" width="260" height="80"   />
                            <?php else: ?>
                              <span>No logo uploaded</span>
                            <?php endif; ?>
                          </p>
                           <button type="button" class="btn btn-warning mt-3" id="editButton" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- / Content -->
            <?php include 'components/footer.php' ?>
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-"></div>
    </div>
    <!-- / Layout wrapper -->
     <!-- Edit Modal -->
     <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editModalLabel">Edit Store Details</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="store_process.php" method="POST">
                        <input type="hidden" name="store_id" value='<?php echo $storeDetails['id']; ?>'>

                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" class="form-control" name="meta_title" id="editMetaTitle" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control" name="meta_keywords" id="editMetaKeywords" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="editEmail" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea class="form-control" name="meta_description" id="editMetaDescription" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Favicon</label>
                            <input type="file" name="favicon" class="form-control" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Store Icon</label>
                            <input type="file" name="store_icon" class="form-control" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Logo</label>
                            <input type="file" name="logo" class="form-control" accept="image/*">
                        </div>
                        <button type="submit" name="update_store" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>
<script>
  // Populate modal fields when "Edit" is clicked
  document.getElementById('editButton').addEventListener('click', function () {
            document.getElementById('editMetaTitle').value = document.getElementById('previewMetaTitle').textContent;
            document.getElementById('editMetaKeywords').value = document.getElementById('previewMetaKeywords').textContent;
            document.getElementById('editEmail').value = document.getElementById('previewEmail').textContent;
            document.getElementById('editMetaDescription').value = document.getElementById('previewMetaDescription').textContent;
        });
    // Function to update preview on form input change
    function updatePreview() {
        // Update text fields
        document.getElementById('previewMetaTitle').textContent = document.querySelector('[name="meta_title"]').value;
        document.getElementById('previewMetaKeywords').textContent = document.querySelector('[name="meta_keywords"]').value;
        document.getElementById('previewEmail').textContent = document.querySelector('[name="email"]').value;
        document.getElementById('previewMetaDescription').textContent = document.querySelector('[name="meta_description"]').value;

        // Handle file previews
        const faviconFile = document.querySelector('[name="favicon"]').files[0];
        const storeIconFile = document.querySelector('[name="store_icon"]').files[0];
        const logoFile = document.querySelector('[name="logo"]').files[0];

        if (faviconFile) {
            const faviconReader = new FileReader();
            faviconReader.onload = function (e) {
                document.getElementById('previewFavicon').src = e.target.result;
            };
            faviconReader.readAsDataURL(faviconFile);
        }

        if (storeIconFile) {
            const storeIconReader = new FileReader();
            storeIconReader.onload = function (e) {
                document.getElementById('previewStoreIcon').src = e.target.result;
            };
            storeIconReader.readAsDataURL(storeIconFile);
        }

        if (logoFile) {
            const logoReader = new FileReader();
            logoReader.onload = function (e) {
                document.getElementById('previewLogo').src = e.target.result;
            };
            logoReader.readAsDataURL(logoFile);
        }
    }

    // Attach event listeners to form inputs to trigger preview update
    document.querySelector('form').addEventListener('input', updatePreview);
    document.querySelector('form').addEventListener('change', updatePreview);
</script>
