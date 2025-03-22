<?php
require_once 'config/store.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $meta_title = $_POST['meta_title'];
    $meta_keywords = $_POST['meta_keywords'];
    $email = $_POST['email'];
    $meta_description = $_POST['meta_description'];
    $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : null;

    // Folder for uploads
    $upload_dir = "uploads/";
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Handle File Uploads
    function uploadFile($file, $upload_dir) {
        if (isset($_FILES[$file]) && $_FILES[$file]['error'] == 0) {
            $target_path = $upload_dir . basename($_FILES[$file]['name']);
            move_uploaded_file($_FILES[$file]['tmp_name'], $target_path);
            return $target_path;
        }
        return "";
    }

    $favicon = uploadFile('favicon', $upload_dir);
    $logo = uploadFile('logo', $upload_dir);
    $store_icon = uploadFile('store_icon', $upload_dir);

    $store = new Store();

    if ($store_id) {
        // Update existing store details
        $success = $store->updateStore($store_id, $meta_title, $meta_keywords, $email, $meta_description, $favicon, $logo, $store_icon);
    } else {
        // Insert new store details
        $success = $store->insertStore($meta_title, $meta_keywords, $email, $meta_description, $favicon, $logo, $store_icon);
    }

    if ($success) {
        header("Location: iconlogo.php");
        exit;
    } else {
        echo "Failed to save store details.";
    }

    if (isset($_POST['update_store'])) {
        $storeId = $_POST['store_id'];
        $metaTitle = $_POST['meta_title'];
        $metaKeywords = $_POST['meta_keywords'];
        $email = $_POST['email'];
        $metaDescription = $_POST['meta_description'];
    
        $updateStatus = $store->updateStoreDetails($storeId, $metaTitle, $metaKeywords, $email, $metaDescription);
    
        if ($updateStatus) {
            header("Location: iconlogo.php?status=success");
        } else {
            header("Location: iconlogo.php?status=error");
        }
    }
}
?>
