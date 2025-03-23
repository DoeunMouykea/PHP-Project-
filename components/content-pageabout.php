<?php
require_once 'admin/config/about.php'; // Include the About class
include_once 'admin/config/db.php';

// Get database instance
$db = Database::getInstance();
$conn = $db->getConnection(); // Add semicolon here

// Fetch the latest About data
$sql = "SELECT * FROM about_us ORDER BY id DESC LIMIT 1";
$stmt = $conn->prepare($sql); // Use $conn to prepare the query
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('admin/<?php echo $data['story_image']; ?>');">
    <h2 class="ltext-105 cl0 txt-center">
    <?php echo $data['section_title']; ?>
    </h2>
</section>

<section class="bg0 p-t-75 p-b-120">
    <div class="container">
        <div class="row p-b-148">
            <div class="col-md-7 col-lg-8">
                <div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
                    <h3 class="mtext-111 cl2 p-b-16">
                    <?php echo $data['story_title']; ?>
                    </h3>

                    <p class="stext-113 cl6 p-b-26">
                        <?php echo $data['story_content']; ?>
                    </p>

                    <p class="stext-113 cl6 p-b-26">
                        <?php echo $data['story_content']; // Repeat or change content as needed ?>
                    </p>

                   
                </div>
            </div>

            <div class="col-11 col-md-5 col-lg-4 m-lr-auto">
                <div class="how-bor1 ">
                    <div class="hov-img0">
                        <img src="admin/<?php echo $data['story_image']; ?>" alt="IMG">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="order-md-2 col-md-7 col-lg-8 p-b-30">
                <div class="p-t-7 p-l-85 p-l-15-lg p-l-0-md">
                    <h3 class="mtext-111 cl2 p-b-16">
                    <?php echo $data['mission_title']; ?>
                    </h3>

                    <p class="stext-113 cl6 p-b-26">
                        <?php echo $data['mission_content']; ?>
                    </p>

                    <div class="bor16 p-l-29 p-b-9 m-t-22">
                        <p class="stext-114 cl6 p-r-40 p-b-11">
                            <?php echo $data['quote']; ?>
                        </p>

                        <span class="stext-111 cl8">
                            - <?php echo $data['quote_author']; ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="order-md-1 col-11 col-md-5 col-lg-4 m-lr-auto p-b-30">
                <div class="how-bor2">
                    <div class="hov-img0">
                        <img src="admin/<?php echo $data['mission_image']; ?>" alt="IMG">
                    </div>
                </div>
            </div>
        </div>

        <div class="row p-b-148">
            <div class="col-md-7 col-lg-8">
                <div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
                    <h3 class="mtext-111 cl2 p-b-16">
                    <?php echo $data['team_title']; ?>
                    </h3>

                    <p class="stext-113 cl6 p-b-26">
                        <?php echo $data['team_content']; ?>
                    </p>

                    <p class="stext-113 cl6 p-b-26">
                        <?php echo $data['team_content']; ?>
                    </p>

                   
                </div>
            </div>

            <div class="col-11 col-md-5 col-lg-4 m-lr-auto">
                <div class="how-bor1 ">
                    <div class="hov-img0">
					<img src="admin/<?php echo $data['team_image']; ?>" alt="IMG">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
