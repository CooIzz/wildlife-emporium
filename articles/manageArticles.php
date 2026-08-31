<?php

//connect to wildlife emporium database
session_start();
require_once("../includes/auth.php");
require_once("../includes/database.php");

requireAdmin();


//this section is for deleting an article

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["deleteArticle"]))
{

    $articleID = filter_input(
        INPUT_POST,
        "articleID",
        FILTER_VALIDATE_INT
    );


    if ($articleID !== false && $articleID !== null)
    {

        $deleteQuery = "
            DELETE FROM articles
            WHERE article_id = ?
        ";


        $statement = mysqli_prepare(
            $connection,
            $deleteQuery
        );


        if ($statement)
        {

            mysqli_stmt_bind_param(
                $statement,
                "i",
                $articleID
            );

            mysqli_stmt_execute($statement);

            mysqli_stmt_close($statement);

        }

    }


    //redirect after deletion to prevent duplicate submission
    header("Location: manageArticles.php");
    exit();

}


//this section is for retrieving all articles

$articlesQuery = "
    SELECT
        article_id,
        title,
        author,
        creation_at
    FROM articles
    ORDER BY creation_at DESC
";


$statement = mysqli_prepare(
    $connection,
    $articlesQuery
);


$articles = [];


if ($statement)
{

    mysqli_stmt_execute($statement);


    mysqli_stmt_bind_result(
        $statement,
        $articleID,
        $title,
        $author,
        $creationAt
    );


    while (mysqli_stmt_fetch($statement))
    {

        $articles[] = [
            "article_id" => $articleID,
            "title" => $title,
            "author" => $author,
            "creation_at" => $creationAt
        ];

    }


    mysqli_stmt_close($statement);

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

    <title>Manage Articles | Wildlife Emporium</title>

    <link
        rel="stylesheet"
        href="../css/style.css"
    >

    <link
        rel="stylesheet"
        href="../css/manageArticles.css"
    >

</head>

<body>

<?php include("../includes/header.php"); ?>

<?php include("../includes/navigation.php"); ?>


<main>

    <div class="manage-articles-page">


        <!--this section is for the page header-->

        <section class="manage-articles-header">

            <p class="manage-articles-label">
                ADMINISTRATION
            </p>

            <h1>
                Manage Articles
            </h1>

            <p>
                Create, edit, and delete articles published on
                Wildlife Daily.
            </p>

        </section>


        <!--this section is for the existing articles-->

        <section
            class="existing-articles"
            id="existing-articles"
        >

            <div class="existing-articles-header">

                <div>

                    <p class="management-section-label">
                        ARTICLE LIBRARY
                    </p>

                    <h2>
                        Existing Articles
                    </h2>

                </div>

                <p>
                    Select an article to edit or delete it.
                </p>

            </div>


            <!--this section is for the article table-->

            <div class="articles-table-container">

                <table class="articles-table">

                    <thead>

                        <tr>

                            <th>
                                Article
                            </th>

                            <th>
                                Author
                            </th>

                            <th>
                                Published
                            </th>

                            <th>
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        <!--this section is for creating a new article-->

                        <tr class="create-article-row">

                            <td colspan="4">

                                <a
                                    href="createArticle.php"
                                    class="create-article-button"
                                >
                                    + Create New Article
                                </a>

                            </td>

                        </tr>


                        <?php if (!empty($articles)): ?>


                            <!--this section is for displaying existing articles-->

                            <?php foreach ($articles as $article): ?>

                                <tr>

                                    <td class="article-title">

                                        <?php echo htmlspecialchars(
                                            $article["title"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ); ?>

                                    </td>


                                    <td class="article-author">

                                        <?php echo htmlspecialchars(
                                            $article["author"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ); ?>

                                    </td>


                                    <td class="article-date">

                                        <?php echo date(
                                            "F j, Y",
                                            strtotime($article["creation_at"])
                                        ); ?>

                                    </td>


                                    <td class="article-actions">


                                        <!--this section is for editing an article-->

                                        <a
                                            href="editArticle.php?id=<?php echo (int)$article["article_id"]; ?>"
                                            class="article-action-edit"
                                        >
                                            Edit
                                        </a>


                                        <!--this section is for deleting an article-->

                                        <form
                                            method="POST"
                                            action="manageArticles.php"
                                            onsubmit="return confirm('Are you sure you want to delete this article?');"
                                        >

                                            <input
                                                type="hidden"
                                                name="articleID"
                                                value="<?php echo (int)$article["article_id"]; ?>"
                                            >

                                            <button
                                                type="submit"
                                                name="deleteArticle"
                                                class="article-action-delete"
                                            >
                                                Delete
                                            </button>

                                        </form>


                                    </td>

                                </tr>

                            <?php endforeach; ?>


                        <?php else: ?>


                            <!--this section is for when there are no articles-->

                            <tr>

                                <td
                                    colspan="4"
                                    class="no-articles"
                                >

                                    <p>
                                        No articles available.
                                    </p>

                                </td>

                            </tr>


                        <?php endif; ?>


                    </tbody>

                </table>

            </div>

        </section>

    </div>

</main>


<?php include("../includes/footer.php"); ?>


<script src="../js/script.js"></script>


</body>

</html>