const baseInput = document.getElementById("xpBase");
const powerInput = document.getElementById("xpPower");
const maxLevelInput = document.getElementById("maxLevel");

const baseValue = document.getElementById("xpBaseValue");
const powerValue = document.getElementById("xpPowerValue");
const maxLevelValue = document.getElementById("maxLevelValue");

const level10XP = document.getElementById("level10XP");
const level50XP = document.getElementById("level50XP");
const level100XP = document.getElementById("level100XP");

const canvas = document.getElementById("xpCurve");
const context = canvas.getContext("2d");
const tooltip = document.getElementById("xpTooltip");

function getXPForPreview(level)
{
    const base = Number(baseInput.value);
    const power = Number(powerInput.value);

    if (level <= 1)
    {
        return 0;
    }

    return Math.round(base * Math.pow(level - 1,power));
}

function getPreviewData()
{
    const maxLevel = Number(maxLevelInput.value);
    const data = [];

    for (let level = 1; level <= maxLevel; level++)
    {
        data.push({
            level: level,
            xp: getXPForPreview(level)
        });
    }

    return data;
}

function formatXP(xp)
{
    return Math.round(xp).toLocaleString() + " XP";
}

function updateValues()
{
    baseValue.textContent = baseInput.value;
    powerValue.textContent = Number(powerInput.value).toFixed(2);
    maxLevelValue.textContent = maxLevelInput.value;

    level10XP.textContent = formatXP(getXPForPreview(10));
    level50XP.textContent = formatXP(getXPForPreview(50));

    if (Number(maxLevelInput.value) >= 100)
    {
        level100XP.textContent = formatXP(getXPForPreview(100));
    }
    else
    {
        level100XP.textContent = "N/A";
    }

    drawCurve();
}

function resizeCanvas()
{
    const ratio = window.devicePixelRatio || 1;

    const width = canvas.clientWidth;
    const height = canvas.clientHeight;

    canvas.width = width * ratio;
    canvas.height = height * ratio;

    context.setTransform(ratio,0,0,ratio,0,0);

    drawCurve();
}

function drawCurve()
{
    const width = canvas.clientWidth;
    const height = canvas.clientHeight;

    context.clearRect(0,0,width,height);

    const padding = {
        top: 25,
        right: 25,
        bottom: 45,
        left: 75
    };

    const graphWidth = width - padding.left - padding.right;
    const graphHeight = height - padding.top - padding.bottom;

    const xpData = getPreviewData();

    if (xpData.length === 0)
    {
        return;
    }

    const maxXP = xpData[xpData.length - 1].xp;

    if (maxXP <= 0)
    {
        return;
    }

    drawGrid(
        width,
        padding,
        graphWidth,
        graphHeight
    );

    drawAxes(
        width,
        height,
        padding,
        graphWidth,
        graphHeight
    );

    drawCurveLine(
        xpData,
        width,
        height,
        padding,
        graphWidth,
        graphHeight,
        maxXP
    );

    drawLevelLabels(
        xpData,
        padding,
        graphWidth,
        height
    );

    drawXPLabels(
        maxXP,
        padding,
        graphHeight
    );
}

function drawGrid(width,padding,graphWidth,graphHeight)
{
    context.beginPath();

    for (let i = 0; i <= 5; i++)
    {
        const y = padding.top + (graphHeight / 5) * i;

        context.moveTo(padding.left,y);
        context.lineTo(width - padding.right,y);
    }

    context.strokeStyle = "#dddddd";
    context.lineWidth = 1;
    context.stroke();
}

function drawAxes(width,height,padding)
{
    context.beginPath();

    context.moveTo(padding.left,padding.top);
    context.lineTo(padding.left,height - padding.bottom);

    context.lineTo(width - padding.right,height - padding.bottom);

    context.strokeStyle = "#777777";
    context.lineWidth = 1.5;
    context.stroke();
}

function drawCurveLine(
    xpData,
    width,
    height,
    padding,
    graphWidth,
    graphHeight,
    maxXP
)
{
    context.beginPath();

    xpData.forEach((point,index) =>
    {
        const x = padding.left +
            ((point.level - 1) / (xpData.length - 1)) * graphWidth;

        const y = height -
            padding.bottom -
            (point.xp / maxXP) * graphHeight;

        if (index === 0)
        {
            context.moveTo(x,y);
        }
        else
        {
            context.lineTo(x,y);
        }
    });

    context.strokeStyle = "#333333";
    context.lineWidth = 3;
    context.stroke();
}

function getLabelLevels(maxLevel)
{
    const labels = [];

    if (maxLevel <= 10)
    {
        for (let level = 1; level <= maxLevel; level++)
        {
            labels.push(level);
        }

        return labels;
    }

    const numberOfLabels = 10;
    const interval = (maxLevel - 1) / (numberOfLabels - 1);

    for (let i = 0; i < numberOfLabels; i++)
    {
        labels.push(
            Math.round(1 + interval * i)
        );
    }

    return [...new Set(labels)];
}

function drawLevelLabels(xpData,padding,graphWidth,height)
{
    const maxLevel = xpData.length;
    const labelLevels = getLabelLevels(maxLevel);

    context.fillStyle = "#555555";
    context.font = "12px Arial";
    context.textAlign = "center";

    labelLevels.forEach(level =>
    {
        const point = xpData[level - 1];

        if (!point)
        {
            return;
        }

        const x = padding.left +
            ((point.level - 1) / (xpData.length - 1)) * graphWidth;

        context.fillText(
            "Lv " + point.level,
            x,
            height - padding.bottom + 22
        );
    });
}

function drawXPLabels(maxXP,padding,graphHeight)
{
    context.fillStyle = "#555555";
    context.font = "12px Arial";
    context.textAlign = "right";

    for (let i = 0; i <= 5; i++)
    {
        const xp = maxXP - (maxXP / 5) * i;
        const y = padding.top + (graphHeight / 5) * i;

        context.fillText(
            formatXP(xp),
            padding.left - 8,
            y + 4
        );
    }
}

function getMousePosition(event)
{
    const rectangle = canvas.getBoundingClientRect();

    return {
        x: event.clientX - rectangle.left,
        y: event.clientY - rectangle.top
    };
}

function findClosestPoint(mouseX)
{
    const padding = {
        left: 75,
        right: 25
    };

    const maxLevel = Number(maxLevelInput.value);

    const graphWidth =
        canvas.clientWidth -
        padding.left -
        padding.right;

    const level =
        1 +
        ((mouseX - padding.left) / graphWidth) *
        (maxLevel - 1);

    let closestLevel = Math.round(level);

    if (closestLevel < 1)
    {
        closestLevel = 1;
    }

    if (closestLevel > maxLevel)
    {
        closestLevel = maxLevel;
    }

    return {
        level: closestLevel,
        xp: getXPForPreview(closestLevel)
    };
}

canvas.addEventListener("mousemove",(event) =>
{
    const position = getMousePosition(event);

    const padding = {
        left: 75,
        right: 25
    };

    if (
        position.x < padding.left ||
        position.x > canvas.clientWidth - padding.right
    )
    {
        tooltip.style.display = "none";
        return;
    }

    const point = findClosestPoint(position.x);

    tooltip.innerHTML =
        "<strong>Level " +
        point.level +
        "</strong><br>" +
        "Required XP: " +
        formatXP(point.xp);

    tooltip.style.display = "block";

    const container = canvas.parentElement;

    let tooltipX = position.x + 15;
    let tooltipY = position.y + 15;

    if (tooltipX + tooltip.offsetWidth > container.clientWidth)
    {
        tooltipX = position.x - tooltip.offsetWidth - 15;
    }

    if (tooltipY + tooltip.offsetHeight > container.clientHeight)
    {
        tooltipY = position.y - tooltip.offsetHeight - 15;
    }

    tooltip.style.left = tooltipX + "px";
    tooltip.style.top = tooltipY + "px";
});

canvas.addEventListener("mouseleave",() =>
{
    tooltip.style.display = "none";
});

baseInput.addEventListener("input",updateValues);
powerInput.addEventListener("input",updateValues);
maxLevelInput.addEventListener("input",updateValues);

window.addEventListener("resize",resizeCanvas);

resizeCanvas();
updateValues();