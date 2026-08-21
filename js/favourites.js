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

            fetch("favourites.php",{
                method:"POST",
                body:formData
            })
            .then(function(response)
            {
                if (!response.ok)
                {
                    throw new Error("Favourite request failed.");
                }

                return response.text();
            })
            .then(function(result)
            {
                if (result === "added")
                {
                    image.src = "../images/animals/favourite-filled.png";
                }
                else if (result === "removed")
                {
                    image.src = "../images/animals/favourite-empty.png";
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