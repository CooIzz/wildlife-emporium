const donationSlider = document.getElementById("donationSlider");
const donationAmount = document.getElementById("donationAmount");
const buttonAmount = document.getElementById("buttonAmount");
const donationButton = document.getElementById("donateButton");
const donationForm = document.getElementById("donationForm");

//this section updates the displayed donation amount
function updateDonationAmount()
{
    const amount = Number(donationSlider.value);
    const formattedAmount = amount.toLocaleString("en-MY");

    donationAmount.textContent = formattedAmount;
    buttonAmount.textContent = formattedAmount;

    //this section disables the button when RM0 is selected
    donationButton.disabled = amount < 1;

    //this section updates the selected portion of the slider
    const percentage =
        (amount / Number(donationSlider.max)) * 100;

    donationSlider.style.setProperty(
        "--slider-progress",
        percentage + "%"
    );
}

//this section updates the slider while it is being dragged
donationSlider.addEventListener(
    "input",
    updateDonationAmount
);

//this section prevents an invalid RM0 donation from being submitted
donationForm.addEventListener(
    "submit",
    function(event)
    {
        const amount = Number(donationSlider.value);

        if (amount < 1)
        {
            event.preventDefault();

            alert(
                "Please select a donation amount of at least RM1."
            );
        }
    }
);

//this section initializes the slider when the page loads
updateDonationAmount();