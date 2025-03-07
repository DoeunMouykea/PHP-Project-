<?php
include 'components/head.php';
require_once 'config/db.php';
require_once 'config/book.php';

$book = new Book();
$books = $book->getBooksWithDiscount();
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">
  <body>
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <?php include 'components/meun.php'; ?>
        <div class="layout-page">
          <?php include 'components/navbar.php'; ?>
          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- Bootstrap Table with Caption -->
              <div class="card">
                <h5 class="card-header text-center">Table Offers</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <caption class="ms-4">List of Offers</caption>
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Description</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($books as $b) {
                        echo "<tr>
                                <td>{$b['id']}</td>
                                <td><img src='{$b['image']}' width='100'></td>
                                <td>{$b['title']}</td>
                                <td>{$b['author']}</td>
                                <td>{$b['type']}</td>
                                <td>{$b['price']}</td>
                                <td>{$b['discount_price']}</td>
                                <td>" . substr($b['description'], 0, 30) . "</td>
                                <td>
                                  <button class='m-1 btn btn-info btn-sm edit-book' data-id='{$b['id']}'>Edit</button>
                                  <button class='m-1 btn btn-danger btn-sm delete-book' data-id='{$b['id']}'>Delete</button>
                                </td>
                              </tr>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- End Table -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include 'components/footer.php'; ?>
  </body>
</html>
