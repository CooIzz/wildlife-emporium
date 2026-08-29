<?php

session_start();


//connect to wildlife emporium database
require_once("../includes/database.php");
require_once("../includes/auth.php");


//require administrator access
requireAdmin();


//this section is for deleting an enquiry

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["deleteEnquiry"])
)
{

    $messageID = filter_input(
        INPUT_POST,
        "messageID",
        FILTER_VALIDATE_INT
    );


    if ($messageID !== false && $messageID !== null)
    {

        $deleteQuery = "
            DELETE FROM contact_messages
            WHERE messageID = ?
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
                $messageID
            );


            mysqli_stmt_execute($statement);


            mysqli_stmt_close($statement);

        }

    }


    //redirect after deletion to prevent duplicate submission
    header("Location: manageEnquiries.php");
    exit();

}


//this section is for retrieving all enquiries

$enquiriesQuery = "
    SELECT
        cm.messageID,
        cm.enquiryType,
        cm.subject,
        cm.message,
        cm.createdAt,
        u.username,
        u.email
    FROM contact_messages cm
    INNER JOIN users u
        ON cm.userID = u.userID
    ORDER BY cm.createdAt DESC
";


$statement = mysqli_prepare(
    $connection,
    $enquiriesQuery
);


$enquiries = [];


if ($statement)
{

    mysqli_stmt_execute($statement);


    mysqli_stmt_bind_result(
        $statement,
        $messageID,
        $enquiryType,
        $subject,
        $message,
        $createdAt,
        $username,
        $email
    );


    while (mysqli_stmt_fetch($statement))
    {

        $enquiries[] = [
            "messageID" => $messageID,
            "enquiryType" => $enquiryType,
            "subject" => $subject,
            "message" => $message,
            "createdAt" => $createdAt,
            "username" => $username,
            "email" => $email
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


    <title>
        Manage Enquiries | Wildlife Emporium
    </title>


    <link
        rel="stylesheet"
        href="../css/style.css"
    >


    <link
        rel="stylesheet"
        href="../css/manageEnquiries.css"
    >

</head>


<body>


<?php include("../includes/header.php"); ?>

<?php include("../includes/navigation.php"); ?>


<main>

    <div class="manage-enquiries-page">


        <!--this section is for the page header-->

        <section class="manage-enquiries-header">

            <p class="manage-enquiries-label">
                ADMINISTRATION
            </p>


            <h1>
                Manage Enquiries
            </h1>


            <p>
                View and manage enquiries submitted by
                Wildlife Emporium users.
            </p>

        </section>


        <!--this section is for the existing enquiries-->

        <section
            class="existing-enquiries"
            id="existing-enquiries"
        >


            <div class="existing-enquiries-header">

                <div>

                    <p class="management-section-label">
                        CONTACT ENQUIRIES
                    </p>


                    <h2>
                        Existing Enquiries
                    </h2>

                </div>


                <p>
                    Review enquiries submitted through
                    the Contact Us page.
                </p>

            </div>


            <!--this section is for the enquiry table-->

            <div class="enquiries-table-container">

                <table class="enquiries-table">


                    <thead>

                        <tr>

                            <th>
                                User
                            </th>


                            <th>
                                Enquiry Type
                            </th>


                            <th>
                                Subject
                            </th>


                            <th>
                                Message
                            </th>


                            <th>
                                Submitted
                            </th>


                            <th>
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        <?php if (!empty($enquiries)): ?>


                            <!--this section is for displaying existing enquiries-->

                            <?php foreach ($enquiries as $enquiry): ?>

                                <tr>


                                    <td class="enquiry-user">

                                        <strong>

                                            <?php echo htmlspecialchars(
                                                $enquiry["username"],
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ); ?>

                                        </strong>


                                        <span>

                                            <?php echo htmlspecialchars(
                                                $enquiry["email"],
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ); ?>

                                        </span>

                                    </td>


                                    <td class="enquiry-type">

                                        <?php echo htmlspecialchars(
                                            $enquiry["enquiryType"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ); ?>

                                    </td>


                                    <td class="enquiry-subject">

                                        <?php echo htmlspecialchars(
                                            $enquiry["subject"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ); ?>

                                    </td>


                                    <td class="enquiry-message">

                                        <?php echo nl2br(
                                            htmlspecialchars(
                                                $enquiry["message"],
                                                ENT_QUOTES,
                                                "UTF-8"
                                            )
                                        ); ?>

                                    </td>


                                    <td class="enquiry-date">

                                        <?php echo date(
                                            "F j, Y H:i",
                                            strtotime(
                                                $enquiry["createdAt"]
                                            )
                                        ); ?>

                                    </td>


                                    <td class="enquiry-actions">


                                        <!--this section is for deleting an enquiry-->

                                        <form
                                            method="POST"
                                            action="manageEnquiries.php"
                                            onsubmit="return confirm('Are you sure you want to delete this enquiry?');"
                                        >

                                            <input
                                                type="hidden"
                                                name="messageID"
                                                value="<?php echo (int)$enquiry["messageID"]; ?>"
                                            >


                                            <button
                                                type="submit"
                                                name="deleteEnquiry"
                                                class="enquiry-action-delete"
                                            >
                                                Delete
                                            </button>

                                        </form>


                                    </td>


                                </tr>

                            <?php endforeach; ?>


                        <?php else: ?>


                            <!--this section is for when there are no enquiries-->

                            <tr>

                                <td
                                    colspan="6"
                                    class="no-enquiries"
                                >

                                    <p>
                                        No enquiries available.
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