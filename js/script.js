function updateMalaysiaTime()
{
    const now = new Date();

    const malaysiaTime = now.toLocaleString("en-MY", {
        timeZone: "Asia/Kuala_Lumpur",
        dateStyle: "medium",
        timeStyle: "medium"
    });

    document.getElementById("malaysia-time").textContent = malaysiaTime;
}

updateMalaysiaTime();

setInterval(updateMalaysiaTime, 1000);