<?php
require_once 'config/article.php';

$article = new Article();

// Fetch article details if 'id' is provided
if (isset($_GET['id'])) {
    $articleId = $_GET['id'];
    $articleDetails = $article->getArticleById($articleId);
}

// Check if the form is submitted to update the article
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $result = $article->updateArticle($_POST['id'], $_POST['title'], $_POST['content'], $_POST['category'], $_FILES['image']);
    if ($result) {
        echo "<script>window.location.href='blogcontent.php';</script>";
    } else {
        echo "Error updating article.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<?php include 'components/head.php' ?>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include 'components/meun.php' ?>
            <div class="layout-page">
                <?php include 'components/navbar.php' ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card mb-4">
                            <div class="card-header text-center">
                                <h5 class="mb-0">Edit Article</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $articleDetails['id']; ?>">
                                    
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label" for="title">Title:</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="title" value="<?php echo $articleDetails['title']; ?>" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label" for="category">Category:</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" name="category" value="<?php echo $articleDetails['category']; ?>" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label" for="content">Content:</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="content" rows="5" required><?php echo $articleDetails['content']; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label" for="image">Image:</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="file" name="image" id="image">
                                            <img src="<?php echo $articleDetails['image']; ?>" alt="Current Image" width="100">
                                        </div>
                                    </div>

                                    <div class="row justify-content-end">
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-primary">Update Article</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'components/script.php' ?>
</body>
</html>
