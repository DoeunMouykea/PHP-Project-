<?php
include_once 'admin/config/db.php';

// Get database instance
$db = Database::getInstance();
$conn = $db->getConnection();

// Fetch slides from database using PDO
$sql = "SELECT * FROM slides ORDER BY id ASC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$slides = $stmt->fetchAll();
?>

<section id="billboard" class="wrap-slick1">
    <div class="container">
        <div class="row">
            <div class="slick1 col-md-12">
                <?php
                if (!empty($slides)) {
                    foreach ($slides as $slide) {
                        echo '<div class="item-slick1 main-slider pattern-overlay" style="background-image: url(images/pattern1.png);">
                                <div class="slider-item">
                                    <div class="banner-content">
                                        <h3 class="banner-title">' . htmlspecialchars($slide['title']) . '</h3>
                                        <p>' . htmlspecialchars($slide['description']) . '</p>
                                        <div class="btn-wrap">
                                            <a href="' . htmlspecialchars($slide['link']) . '" class="btn btn-outline-accent btn-accent-arrow">Shop Now<i class="icon icon-ns-arrow-right"></i></a>
                                        </div>
                                    </div>
                                    <img src="'.'admin/images/' . htmlspecialchars($slide['image']) . '" alt="banner" width="35%"  class="banner-image">
                                </div>
                            </div>';
                    }
                } else {
                    echo '<p>No slides available.</p>';
                }
                ?>
            </div>
        </div>
    </div>
</section>
