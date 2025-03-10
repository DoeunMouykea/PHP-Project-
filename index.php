<?php
include_once 'admin/config/db.php';
$page = "components/subscribe.php";
$f = "home";
$slider = true;
$client = true;
$feature = true;
$selling = true;
$popular = true;
$quotation = true;
$offer = true;
$subscribe = true;
$blog = true;
$download = true; // corrected typo

if (isset($_GET['f'])) {
    $f = $_GET['f'];
    if ($f == "about") {
        $page = "about.php";
        $slider = false;
        $client = false;
        $feature = false;
        $selling = false;
        $popular = false;
        $quotation = false;
        $offer = false;
        $subscribe = false;
        $blog = false;
        $download = false;
    } 
    elseif ($f == "account") {
        $page = "account.php";
        $slider = false;
        $client = false;
        $feature = false;
        $selling = false;
        $popular = false;
        $quotation = false;
        $offer = false;
        $subscribe = false;
        $blog = false;
        $download = false;
    }
    elseif ($f == "store") {
        $page = "store.php";
        $slider = false;
        $client = false;
        $feature = false;
        $selling = false;
        $popular = false;
        $quotation = false;
        $offer = false;
        $subscribe = false;
        $blog = false;
        $download = false;
    }
    elseif ($f == "contact") {
        $page = "components/contact.php";
        $slider = false;
        $client = false;
        $feature = false;
        $selling = false;
        $popular = false;
        $quotation = false;
        $offer = false;
        $subscribe = false;
        $blog = false;
        $download = false;
    }
    elseif ($f == "download-app") {
        $page = "components/download-app.php";
        $slider = false;
        $client = false;
        $feature = false;
        $selling = false;
        $popular = false;
        $quotation = false;
        $offer = false;
        $subscribe = false;
        $blog = false;
        $download = false;
    }
    elseif ($f == "popular-books") {
        $page = "components/popular-books.php";
        $slider = false;
        $client = false;
        $feature = false;
        $selling = false;
        $popular = false;
        $quotation = false;
        $offer = false;
        $subscribe = false;
        $blog = false;
        $download = false;
    }
    elseif ($f == "special-offer") {
        $page = "components/special-offer.php";
        $slider = false;
        $client = false;
        $feature = false;
        $selling = false;
        $popular = false;
        $quotation = false;
        $offer = false;
        $subscribe = false;
        $blog = false;
        $download = false;
    }
    elseif ($f == "blog") {
        $page = "components/latest-blog.php";
        $slider = false;
        $client = false;
        $feature = false;
        $selling = false;
        $popular = false;
        $quotation = false;
        $offer = false;
        $subscribe = false;
        $blog = false;
        $download = false;
    }
    elseif ($f == "thankyou") {
        $page = "thankyou.php";
        $slider = false;
        $client = false;
        $feature = false;
        $selling = false;
        $popular = false;
        $quotation = false;
        $offer = false;
        $subscribe = false;
        $blog = false;
        $download = false;
    } 
    elseif ($f == "order") {
        $page = "order.php";
        $slider = false;
        $client = false;
        $feature = false;
        $selling = false;
        $popular = false;
        $quotation = false;
        $offer = false;
        $subscribe = false;
        $blog = false;
        $download = false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'components/head.php'; ?>
<body data-bs-spy="scroll" data-bs-target="#header" tabindex="0">
	<!-- Header -->
	<?php include 'components/header.php'; ?> 
	<!-- Slider -->
	<?php if ($slider) include 'components/slider.php'; ?>	
    <?php if ($client) include 'components/client-holder.php'; ?>

    <?php include "$page"; ?>

	<?php if ($feature) include 'components/featured-books.php'; ?>
	<?php if ($selling) include 'components/best-selling.php'; ?>
	<?php if ($popular) include 'components/popular-books.php'; ?>
	<?php if ($quotation) include 'components/quotation.php'; ?>
	<?php if ($offer) include 'components/special-offer.php'; ?>
	<?php if ($subscribe) include 'components/subscribe.php'; ?>
	<?php if ($blog) include 'components/latest-blog.php'; ?>
	<?php if ($download) include 'components/download-app.php'; ?>

<!-- Footer -->
<?php include 'components/footer.php'; ?>
</body>
</html>
