document.addEventListener("DOMContentLoaded", function()
{
    const carousel = document.querySelector(".home-article-carousel");

    if (!carousel)
    {
        return;
    }


    const viewport = carousel.querySelector(".home-article-viewport");
    const row = carousel.querySelector(".home-article-row");
    const cards = Array.from(row.querySelectorAll(".home-article-card"));
    const previousButton = carousel.querySelector(".home-article-previous");
    const nextButton = carousel.querySelector(".home-article-next");


    if (!viewport || !row || cards.length === 0)
    {
        return;
    }


    let currentIndex = 0;
    let cardWidth = 0;
    let gap = 0;
    let visibleCards = 1;


    /* ---------------- DIMENSIONS ---------------- */

    function updateDimensions()
    {
        cardWidth = cards[0].offsetWidth;

        gap = parseFloat(
            window.getComputedStyle(row).gap
        ) || 0;


        visibleCards = Math.max(
            1,
            Math.floor(
                (viewport.clientWidth + gap) /
                (cardWidth + gap)
            )
        );


        const maximumIndex = Math.max(
            0,
            cards.length - visibleCards
        );


        if (currentIndex > maximumIndex)
        {
            currentIndex = maximumIndex;
        }
    }


    /* ---------------- POSITION ---------------- */

    function updatePosition()
    {
        const position =
            currentIndex * (cardWidth + gap);


        row.style.transform =
            "translateX(-" + position + "px)";
    }


    /* ---------------- NEXT ---------------- */

    function next()
    {
        const maximumIndex = Math.max(
            0,
            cards.length - visibleCards
        );


        currentIndex++;


        if (currentIndex > maximumIndex)
        {
            currentIndex = 0;
        }


        updatePosition();
    }


    /* ---------------- PREVIOUS ---------------- */

    function previous()
    {
        const maximumIndex = Math.max(
            0,
            cards.length - visibleCards
        );


        currentIndex--;


        if (currentIndex < 0)
        {
            currentIndex = maximumIndex;
        }


        updatePosition();
    }


    /* ---------------- BUTTONS ---------------- */

    if (previousButton)
    {
        previousButton.addEventListener(
            "click",
            function()
            {
                previous();
            }
        );
    }


    if (nextButton)
    {
        nextButton.addEventListener(
            "click",
            function()
            {
                next();
            }
        );
    }


    /* ---------------- RESIZE ---------------- */

    window.addEventListener(
        "resize",
        function()
        {
            updateDimensions();
            updatePosition();
        }
    );


    /* ---------------- INITIALISE ---------------- */

    updateDimensions();
    updatePosition();

});