<?php
require_once 'admin/config/db.php';
require_once 'admin/config/notification.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = Database::getInstance();
    $db = $database->getConnection();
    $notification = new Notification($db);

    $user = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    if ($notification->insertNotification($user, $email, $message)) {
        echo "<script>alert('Notification inserted successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error inserting notification.'); window.location.href='index.php';</script>";
    }
}
?>


<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/post-img2.jpg');">
		<h2 class="ltext-105 cl0 txt-center">
			Contact
		</h2>
	</section>
<section class="bg0 p-t-104 p-b-116">
		<div class="container">
		<div class="flex-w flex-tr">
            <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
                <form action="index.php?f=contact" method="POST">
                    <h4 class="mtext-105 cl2 txt-center p-b-30">
                        Send Us A Message
                    </h4>
                    <div class="bor8 m-b-20 how-pos4-parent">
                        <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" name="name" placeholder="Your Name" required>
                    </div>                        
                    <div class="m-b-20 how-pos4-parent">
                        <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="email" name="email" placeholder="Your Email Address" required>
                    </div>
                    <div class="bor8 m-b-30">
                        <textarea class="stext-111 cl2 plh3 size-120 p-lr-28 p-tb-25" name="message" placeholder="How Can We Help?" required></textarea>
                    </div>

                    <button type="submit" class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
                        Submit
                    </button>
                </form>
            </div>


				<div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
					<div class="flex-w w-full p-b-42">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-map-marker"></span>
						</span>

						<div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
								Address
							</span>

							<p class="stext-115 cl6 size-213 p-t-18">
								Book Store Center in Sangkat Tuek Thla, Khan Sen Sok, Phnom Penh.
							</p>
						</div>
					</div>

					<div class="flex-w w-full p-b-42">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-phone-handset"></span>
						</span>

						<div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
								Lets Talk
							</span>

							<p class="stext-115 cl1 size-213 p-t-18">
								+855 85378162 <br>
								+855 889390038
							</p>
						</div>
					</div>

					<div class="flex-w w-full">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-envelope"></span>
						</span>

						<div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
								Sale Support
							</span>

							<p class="stext-115 cl1 size-213 p-t-18">
								bookstore@gmail.com
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>	