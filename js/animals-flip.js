document.addEventListener("DOMContentLoaded", function()
{
    const cards = document.querySelectorAll(".animal-card");

    cards.forEach(function(card)
    {
        let hoverTimer;

        card.addEventListener("mouseenter", function()
        {
            hoverTimer = setTimeout(function()
            {
                card.classList.add("flipped");
            }, 1000);
        });

        card.addEventListener("mouseleave", function()
        {
            clearTimeout(hoverTimer);
            card.classList.remove("flipped");
        });
    });
});