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

    let isDragging = false;
    let startX = 0;
    let currentX = 0;


    /* ---------------- DIMENSIONS ---------------- */

    function updateDimensions()
    {
        const cardStyle = window.getComputedStyle(cards[0]);

        cardWidth = cards[0].offsetWidth;
        gap = parseFloat(window.getComputedStyle(row).gap) || 0;

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
        const position = currentIndex * (cardWidth + gap);

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


    /* ---------------- DRAGGING ---------------- */

    function startDrag(event)
    {
        if (event.pointerType === "mouse" && event.button !== 0)
        {
            return;
        }

        isDragging = true;

        startX = event.clientX;
        currentX = startX;

        row.classList.add("dragging");

        row.setPointerCapture(event.pointerId);
    }


    function moveDrag(event)
    {
        if (!isDragging)
        {
            return;
        }

        currentX = event.clientX;

        const distance = currentX - startX;

        const basePosition =
            currentIndex * (cardWidth + gap);

        const dragPosition =
            basePosition - distance;

        row.style.transform =
            "translateX(-" + dragPosition + "px)";
    }


    function endDrag(event)
    {
        if (!isDragging)
        {
            return;
        }

        isDragging = false;

        row.classList.remove("dragging");

        const distance = currentX - startX;

        const threshold =
            Math.max(50, cardWidth * 0.15);


        if (distance < -threshold)
        {
            next();
        }
        else if (distance > threshold)
        {
            previous();
        }
        else
        {
            updatePosition();
        }


        if (row.hasPointerCapture(event.pointerId))
        {
            row.releasePointerCapture(event.pointerId);
        }
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


    /* ---------------- POINTER EVENTS ---------------- */

    row.addEventListener(
        "pointerdown",
        startDrag
    );

    row.addEventListener(
        "pointermove",
        moveDrag
    );

    row.addEventListener(
        "pointerup",
        endDrag
    );

    row.addEventListener(
        "pointercancel",
        endDrag
    );


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