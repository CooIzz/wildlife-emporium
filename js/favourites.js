document.addEventListener("DOMContentLoaded",function()
{
    const favouriteForms = document.querySelectorAll(".animal-card-favourite");

    favouriteForms.forEach(function(form)
    {
        form.addEventListener("submit",function(event)
        {
            event.preventDefault();

            const button = form.querySelector("button");
            const image = form.querySelector("img");
            const formData = new FormData(form);

            button.disabled = true;

            fetch("favourites.php",
            {
                method:"POST",
                headers:
                {
                    "X-Requested-With":"XMLHttpRequest"
                },
                body:formData
            })
            .then(function(response)
            {
                if (response.status === 401)
                {
                    window.location.href = "../account/login.php";
                    return null;
                }

                if (!response.ok)
                {
                    throw new Error("Favourite request failed.");
                }

                return response.text();
            })
            .then(function(result)
            {
                if (result === null)
                {
                    return;
                }

                if (result === "added")
                {
                    image.src = "../images/animals/favourite-filled.png";
                }
                else if (result === "removed")
                {
                    image.src = "../images/animals/favourite-empty.png";
                }
                else
                {
                    throw new Error("Unexpected favourite response.");
                }
            })
            .catch(function(error)
            {
                console.error(error);
            })
            .finally(function()
            {
                button.disabled = false;
            });
        });
    });
});