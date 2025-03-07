<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">

<?php 
include 'components/head.php'; 
require_once 'config/order.php';

// Fetch order items
$order = new Order();
$orderItems = $order->getOrderItems();
?>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include 'components/meun.php'; ?>

            <!-- Layout container -->
            <div class="layout-page">
                <?php include 'components/navbar.php'; ?>

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">

                        <!-- Bordered Table -->
                        <div class="card">
                            <h5 class="card-header text-center">Table Sales</h5>
                            <div class="card-body">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Day</th>
                                                <th>Order Items Name</th>
                                                <th>Order Items Image</th>
                                                <th>Quantity</th>
                                                <th>Total Items Sold</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            <?php foreach ($orderItems as $item) : ?>
                                                <tr>
                                                    <td><strong><?= $no++; ?></strong></td>
                                                    <td><?= date('M d, Y', strtotime($item['created_at'])); ?></td> 
                                                    <td><?= htmlspecialchars($item['product_name']); ?></td>
                                                    <td>
                                                        <img src="<?= htmlspecialchars($item['product_image']); ?>" 
                                                             alt="<?= htmlspecialchars($item['product_name']); ?>" 
                                                             width="50">
                                                    </td>
                                                    <td><?= htmlspecialchars($item['quantity']); ?></td>
                                                    <td><?= htmlspecialchars($item['total']); ?></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="edit_order.php?id=<?= $item['id']; ?>">
                                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                                </a>
                                                                <a class="dropdown-item" href="delete_order.php?id=<?= $item['id']; ?>" onclick="return confirm('Are you sure?');">
                                                                    <i class="bx bx-trash me-1"></i> Delete
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/ Bordered Table -->

                        <?php include 'components/footer.php'; ?>

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

        <!-- GitHub Buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
    </body>
</html>
