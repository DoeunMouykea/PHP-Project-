<?php
// Include the necessary classes and create an instance of the Store class
require_once 'admin/config/db.php';
require_once 'admin/config/store.php';

$store = new Store();

// Get store details
$storeDetails = $store->getStoreDetails();

// If data is available, use it; otherwise, set default values
$meta_title = $storeDetails ? $storeDetails['meta_title'] : 'Default Title';
$meta_keywords = $storeDetails ? $storeDetails['meta_keywords'] : 'default, keywords';
$meta_description = $storeDetails ? $storeDetails['meta_description'] : 'Default store description';
$favicon = $storeDetails ? $storeDetails['favicon'] : 'images/default-favicon.png';
$logo = $storeDetails ? $storeDetails['logo'] : 'images/default-logo.png';
$store_icon = $storeDetails ? $storeDetails['store_icon'] : 'images/default-icon.png';
?>
<head>
	<title><?php echo htmlspecialchars($meta_title); ?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="author" content="book store">
	<meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="icomoon/icomoon.css">
	<link rel="stylesheet" type="text/css" href="css/vendor.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="icon" href="admin/<?php echo htmlspecialchars($store_icon); ?>">
</head>