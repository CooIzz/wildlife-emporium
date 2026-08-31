<?php

session_start();

require_once("../includes/auth.php");
require_once("../includes/database.php");

requireAdmin();

//this section is for handling article creation

$errorMessage = "";

$article = [
    "title" => "",
    "subheading" => "",
    "author" => "",
    "keywords" => "",
    "summary" => "",
    "content" => "",
    "image_name" => "",
    "image_caption" => "",
    "image_name2" => "",
    "image_caption2" => ""
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //this section is for retrieving submitted values

    $title = trim($_POST["title"] ?? "");
    $subheading = trim($_POST["subheading"] ?? "");
    $author = trim($_POST["author"] ?? "");
    $keywords = trim($_POST["keywords"] ?? "");
    $summary = trim($_POST["summary"] ?? "");
    $content = trim($_POST["content"] ?? "");
    $imageName = trim($_POST["image_name"] ?? "");
    $imageCaption = trim($_POST["image_caption"] ?? "");
    $imageName2 = trim($_POST["image_name2"] ?? "");
    $imageCaption2 = trim($_POST["image_caption2"] ?? "");

    //this section is for validating required fields

    if (
        $title === "" ||
        $subheading === "" ||
        $author === "" ||
        $summary === "" ||
        $content === ""
    ) {
        $errorMessage = "Please fill in all required fields.";
    }

    //this section is for inserting the new article

    if ($errorMessage === "") {

        $insertQuery = "
            INSERT INTO articles
            (
                title,
                subheading,
                author,
                keywords,
                summary,
                content,
                image_name,
                image_caption,
                image_name2,
                image_caption2
            )
            VALUES
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $insertStatement = mysqli_prepare(
            $connection,
            $insertQuery
        );

        if (!$insertStatement) {

            $errorMessage = "Unable to create the article.";

        } else {

            mysqli_stmt_bind_param(
                $insertStatement,
                "ssssssssss",
                $title,
                $subheading,
                $author,
                $keywords,
                $summary,
                $content,
                $imageName,
                $imageCaption,
                $imageName2,
                $imageCaption2
            );

            if (mysqli_stmt_execute($insertStatement)) {

                mysqli_stmt_close($insertStatement);

                header(
                    "Location: manageArticles.php?message=created"
                );

                exit();

            } else {

                $errorMessage = "Unable to create the article.";

                mysqli_stmt_close($insertStatement);
            }
        }
    }

    //this section is for keeping submitted values after validation failure

    $article["title"] = $title;
    $article["subheading"] = $subheading;
    $article["author"] = $author;
    $article["keywords"] = $keywords;
    $article["summary"] = $summary;
    $article["content"] = $content;
    $article["image_name"] = $imageName;
    $article["image_caption"] = $imageCaption;
    $article["image_name2"] = $imageName2;
    $article["image_caption2"] = $imageCaption2;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Create Article | Wildlife Emporium
    </title>

    <link
        rel="stylesheet"
        href="../css/style.css"
    >

    <link
        rel="stylesheet"
        href="../css/createArticles.css"
    >

</head>

<body>

<?php include("../includes/header.php"); ?>

<?php include("../includes/navigation.php"); ?>


<main>

    <div class="create-article-page">

        <!--this section is for the page header-->

        <section class="create-article-header">

            <p class="create-article-label">
                ARTICLE MANAGEMENT
            </p>

            <h1>
                Create Article
            </h1>

            <p>
                Create and publish a new article for
                Wildlife Daily.
            </p>

        </section>


        <!--this section is for the error message-->

        <?php if ($errorMessage !== ""): ?>

            <div class="create-article-error">

                <?php echo htmlspecialchars(
                    $errorMessage,
                    ENT_QUOTES,
                    "UTF-8"
                ); ?>

            </div>

        <?php endif; ?>


        <!--this section is for the article form-->

        <section class="create-article-form-container">

            <form
                method="POST"
                action="createArticle.php"
                class="create-article-form"
            >

                <!--this section is for the basic article information-->

                <div class="create-article-section">

                    <p class="create-article-section-label">
                        ARTICLE INFORMATION
                    </p>

                    <h2>
                        Basic Information
                    </h2>


                    <div class="create-form-group">

                        <label for="title">
                            Title
                        </label>

                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="<?php echo htmlspecialchars(
                                $article["title"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            required
                        >

                    </div>


                    <div class="create-form-group">

                        <label for="subheading">
                            Subheading
                        </label>

                        <input
                            type="text"
                            id="subheading"
                            name="subheading"
                            value="<?php echo htmlspecialchars(
                                $article["subheading"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            required
                        >

                    </div>


                    <div class="create-form-group">

                        <label for="author">
                            Author
                        </label>

                        <input
                            type="text"
                            id="author"
                            name="author"
                            value="<?php echo htmlspecialchars(
                                $article["author"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            required
                        >

                    </div>


                    <div class="create-form-group">

                        <label for="keywords">
                            Keywords
                        </label>

                        <input
                            type="text"
                            id="keywords"
                            name="keywords"
                            value="<?php echo htmlspecialchars(
                                $article["keywords"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: wildlife, conservation, rainforest"
                        >

                        <p class="create-form-help">
                            Separate multiple keywords with commas.
                        </p>

                    </div>


                    <div class="create-form-group">

                        <label for="summary">
                            Summary
                        </label>

                        <textarea
                            id="summary"
                            name="summary"
                            rows="4"
                            required
                        ><?php echo htmlspecialchars(
                            $article["summary"],
                            ENT_QUOTES,
                            "UTF-8"
                        ); ?></textarea>

                    </div>

                </div>


                <!--this section is for the article content-->

                <div class="create-article-section">

                    <p class="create-article-section-label">
                        ARTICLE CONTENT
                    </p>

                    <h2>
                        Article Body
                    </h2>


                    <div class="create-form-group">

                        <label for="content">
                            Content
                        </label>

                        <textarea
                            id="content"
                            name="content"
                            rows="18"
                            required
                        ><?php echo htmlspecialchars(
                            $article["content"],
                            ENT_QUOTES,
                            "UTF-8"
                        ); ?></textarea>

                    </div>

                </div>


                <!--this section is for the article images-->

                <div class="create-article-section">

                    <p class="create-article-section-label">
                        ARTICLE MEDIA
                    </p>

                    <h2>
                        Images
                    </h2>


                    <div class="create-form-group">

                        <label for="image_name">
                            Main Image Filename
                        </label>

                        <input
                            type="text"
                            id="image_name"
                            name="image_name"
                            value="<?php echo htmlspecialchars(
                                $article["image_name"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: tiger.jpg"
                        >

                    </div>


                    <div class="create-form-group">

                        <label for="image_caption">
                            Main Image Caption
                        </label>

                        <input
                            type="text"
                            id="image_caption"
                            name="image_caption"
                            value="<?php echo htmlspecialchars(
                                $article["image_caption"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                        >

                    </div>


                    <div class="create-form-group">

                        <label for="image_name2">
                            Additional Image Filename
                        </label>

                        <input
                            type="text"
                            id="image_name2"
                            name="image_name2"
                            value="<?php echo htmlspecialchars(
                                $article["image_name2"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                            placeholder="Example: tiger-habitat.jpg"
                        >

                    </div>


                    <div class="create-form-group">

                        <label for="image_caption2">
                            Additional Image Caption
                        </label>

                        <input
                            type="text"
                            id="image_caption2"
                            name="image_caption2"
                            value="<?php echo htmlspecialchars(
                                $article["image_caption2"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                        >

                    </div>

                </div>


                <!--this section is for the form actions-->

                <div class="create-article-actions">

                    <a
                        href="manageArticles.php"
                        class="create-cancel-button"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="create-save-button"
                    >
                        Create Article
                    </button>

                </div>

            </form>

        </section>

    </div>

</main>


<?php include("../includes/footer.php"); ?>


<script src="../js/script.js"></script>


</body>

</html>