<form
    class="contact-form"
    action=""
    method="POST"
>


    <!-- Username -->

    <div class="contact-input-group">

        <label for="name">
            Username
        </label>


        <input
            type="text"
            id="name"
            value="<?php echo htmlspecialchars(
                $username,
                ENT_QUOTES,
                "UTF-8"
            ); ?>"
            readonly
        >

    </div>


    <!-- Email -->

    <div class="contact-input-group">

        <label for="email">
            Email Address
        </label>


        <input
            type="email"
            id="email"
            value="<?php echo htmlspecialchars(
                $email,
                ENT_QUOTES,
                "UTF-8"
            ); ?>"
            readonly
        >

    </div>


    <!-- Enquiry Type -->

    <div class="contact-input-group">

        <label for="enquiryType">
            Enquiry Type
        </label>


        <select
            id="enquiryType"
            name="enquiryType"
        >

            <option value="">
                Select an enquiry type
            </option>


            <option
                value="General Enquiry"
                <?php echo $enquiryType === "General Enquiry"
                    ? "selected"
                    : ""; ?>
            >
                General Enquiry
            </option>


            <option
                value="Animal Information"
                <?php echo $enquiryType === "Animal Information"
                    ? "selected"
                    : ""; ?>
            >
                Animal Information
            </option>


            <option
                value="Website Feedback"
                <?php echo $enquiryType === "Website Feedback"
                    ? "selected"
                    : ""; ?>
            >
                Website Feedback
            </option>


            <option
                value="Technical Support"
                <?php echo $enquiryType === "Technical Support"
                    ? "selected"
                    : ""; ?>
            >
                Technical Support
            </option>


            <option
                value="Other"
                <?php echo $enquiryType === "Other"
                    ? "selected"
                    : ""; ?>
            >
                Other
            </option>

        </select>


        <?php if (isset($errors["enquiryType"])) { ?>

            <p class="contact-form-error">

                <?php echo htmlspecialchars(
                    $errors["enquiryType"],
                    ENT_QUOTES,
                    "UTF-8"
                ); ?>

            </p>

        <?php } ?>

    </div>


    <!-- Subject -->

    <div class="contact-input-group">

        <label for="subject">
            Subject
        </label>


        <input
            type="text"
            id="subject"
            name="subject"
            value="<?php echo htmlspecialchars(
                $subject,
                ENT_QUOTES,
                "UTF-8"
            ); ?>"
        >


        <?php if (isset($errors["subject"])) { ?>

            <p class="contact-form-error">

                <?php echo htmlspecialchars(
                    $errors["subject"],
                    ENT_QUOTES,
                    "UTF-8"
                ); ?>

            </p>

        <?php } ?>

    </div>


    <!-- Message -->

    <div class="contact-input-group">

        <label for="message">
            Message
        </label>


        <textarea
            id="message"
            name="message"
            rows="7"
        ><?php echo htmlspecialchars(
            $message,
            ENT_QUOTES,
            "UTF-8"
        ); ?></textarea>


        <?php if (isset($errors["message"])) { ?>

            <p class="contact-form-error">

                <?php echo htmlspecialchars(
                    $errors["message"],
                    ENT_QUOTES,
                    "UTF-8"
                ); ?>

            </p>

        <?php } ?>

    </div>


    <!-- Submit -->

    <button
        type="submit"
        class="contact-button"
    >
        Send Message
    </button>


</form>