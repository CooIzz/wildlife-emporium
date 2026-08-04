//Calling the anchor elements from the quiz index page
//and adding eventListeners to them for "click" events

//For African Lion
const africanLion = document.getElementById("africanLion");
africanLion.addEventListener("click", africanLionLevelDec);

//For Orang Utan
const orangUtan = document.getElementById("orangUtan");
orangUtan.addEventListener("click", orangUtanLevelDec);

//For Penguin
const penguin = document.getElementById("penguin");
penguin.addEventListener("click", penguinLevelDec);

//For Tiger
const tiger = document.getElementById("tiger");
tiger.addEventListener("click", tigerLevelDec);

//Giant Panda
const giantPanda = document.getElementById("giantPanda");
giantPanda.addEventListener("click", giantPandaLevelDec);

//Raccoon
const raccoon = document.getElementById("raccoon");
raccoon.addEventListener("click", raccoonLevelDec);

//Snow Leopard
const snowLeopard = document.getElementById("snowLeopard");
snowLeopard.addEventListener("click", snowLeopardLevelDec);

//Polar Bear
const polarBear = document.getElementById("polarBear");
polarBear.addEventListener("click", polarBearLevelDec);

//Lynx
const lynx = document.getElementById("lynx");
lynx.addEventListener("click", lynxLevelDec);

//Cheetah
const cheetah = document.getElementById("cheetah");
cheetah.addEventListener("click", cheetahLevelDec);


//Functions that facilitate user decision making in choosing
//the difficulty level

//Function for African Lion
function africanLionLevelDec() {
	
	let choice = parseInt(prompt("Please choose the difficulty level:\n\n1. Easy\n2. Medium\n3. Difficult\n\nEnter 1, 2 or 3:"));
	
	if (isNaN(choice)) {
        alert("No choice made.");
		africanLion.setAttribute("href", "#africanLion");
        return;
    }
	
	switch(choice) {
		
		case 1:
				africanLion.setAttribute("href", "./easy/AfricanLion.php");
				break;
		
		case 2:
				africanLion.setAttribute("href", "./medium/AfricanLion.php");
				break;
		
		case 3:
				africanLion.setAttribute("href", "./difficult/AfricanLion.php");
				break;
				
		default:
				alert("Invalid Option!!!");
				africanLion.setAttribute("href", "#africanLion");
				return;
	
	}

}



//Function for Orang Utan
function orangUtanLevelDec() {
	
	let choice = parseInt(prompt("Please choose the difficulty level:\n\n1. Easy\n2. Medium\n3. Difficult\n\nEnter 1, 2 or 3:"));
	
	if (isNaN(choice)) {
        alert("No choice made.");
		orangUtan.setAttribute("href", "#orangUtan");
        return;
    }
	
	switch(choice) {
		
		case 1:
				orangUtan.setAttribute("href", "./easy/OrangUtan.php");
				break;
		
		case 2:
				orangUtan.setAttribute("href", "./medium/OrangUtan.php");
				break;
		
		case 3:
				orangUtan.setAttribute("href", "./difficult/OrangUtan.php");
				break;
				
		default:
				alert("Invalid Option!!!");
				orangUtan.setAttribute("href", "#orangUtan");
				return;
	
	}
	
}



//Function for Penguin
function penguinLevelDec() {
	
	let choice = parseInt(prompt("Please choose the difficulty level:\n\n1. Easy\n2. Medium\n3. Difficult\n\nEnter 1, 2 or 3:"));
	
	if (isNaN(choice)) {
        alert("No choice made.");
		penguin.setAttribute("href", "#penguin");
        return;
    }
	
	switch(choice) {
		
		case 1:
				penguin.setAttribute("href", "./easy/Penguin.php");
				break;
		
		case 2:
				penguin.setAttribute("href", "./medium/Penguin.php");
				break;
		
		case 3:
				penguin.setAttribute("href", "./difficult/Penguin.php");
				break;
				
		default:
				alert("Invalid Option!!!");
				penguin.setAttribute("href", "#penguin");
				return;
		
	}
	
}



//Function for Tiger
function tigerLevelDec() {
	
	let choice = parseInt(prompt("Please choose the difficulty level:\n\n1. Easy\n2. Medium\n3. Difficult\n\nEnter 1, 2 or 3:"));
	
	if (isNaN(choice)) {
        alert("No choice made.");
		tiger.setAttribute("href", "#tiger");
        return;
    }
	
	switch(choice) {
		
		case 1:
				tiger.setAttribute("href", "./easy/Tiger.php");
				break;
		
		case 2:
				tiger.setAttribute("href", "./medium/Tiger.php");
				break;
		
		case 3:
				tiger.setAttribute("href", "./difficult/Tiger.php");
				break;
				
		default:
				alert("Invalid Option!!!");
				tiger.setAttribute("href", "#tiger");
				return;
		
	}
	
}



//Function for Giant Panda
function giantPandaLevelDec() {
	
	let choice = parseInt(prompt("Please choose the difficulty level:\n\n1. Easy\n2. Medium\n3. Difficult\n\nEnter 1, 2 or 3:"));
	
	if (isNaN(choice)) {
        alert("No choice made.");
		giantPanda.setAttribute("href", "#giantPanda");
        return;
    }
	
	switch(choice) {
		
		case 1:
				giantPanda.setAttribute("href", "./easy/Panda.php");
				break;
		
		case 2:
				giantPanda.setAttribute("href", "./medium/Panda.php");
				break;
		
		case 3:
				giantPanda.setAttribute("href", "./difficult/Panda.php");
				break;
				
		default:
				alert("Invalid Option!!!");
				giantPanda.setAttribute("href", "#giantPanda");
				return;
		
	}
	
}



//Function for Raccoon
function raccoonLevelDec() {
	
	let choice = parseInt(prompt("Please choose the difficulty level:\n\n1. Easy\n2. Medium\n3. Difficult\n\nEnter 1, 2 or 3:"));
	
	if (isNaN(choice)) {
        alert("No choice made.");
		raccoon.setAttribute("href", "#raccoon");
        return;
    }
	
	switch(choice) {
		
		case 1:
				raccoon.setAttribute("href", "./easy/Raccoon.php");
				break;
		
		case 2:
				raccoon.setAttribute("href", "./medium/Raccoon.php");
				break;
		
		case 3:
				raccoon.setAttribute("href", "./difficult/Raccoon.php");
				break;
				
		default:
				alert("Invalid Option!!!");
				raccoon.setAttribute("href", "#raccoon");
				return;
		
	}
	
}



//Function for Snow Leopard 
function snowLeopardLevelDec() {
	
	let choice = parseInt(prompt("Please choose the difficulty level:\n\n1. Easy\n2. Medium\n3. Difficult\n\nEnter 1, 2 or 3:"));
	
	if (isNaN(choice)) {
        alert("No choice made.");
		snowLeopard.setAttribute("href", "#snowLeopard");
        return;
    }
	
	switch(choice) {
		
		case 1:
				snowLeopard.setAttribute("href", "./easy/SnowLeopard.php");
				break;
		
		case 2:
				snowLeopard.setAttribute("href", "./medium/SnowLeopard.php");
				break;
		
		case 3:
				snowLeopard.setAttribute("href", "./difficult/SnowLeopard.php");
				break;
				
		default:
				alert("Invalid Option!!!");
				snowLeopard.setAttribute("href", "#snowLeopard");
				return;
		
	}
	
}

function polarBearLevelDec() {
	
	let choice = parseInt(prompt("Please choose the difficulty level:\n\n1. Easy\n2. Medium\n3. Difficult\n\nEnter 1, 2 or 3:"));
	
	if (isNaN(choice)) {
        alert("No choice made.");
		polarBear.setAttribute("href", "#spolarBear");
        return;
    }
	
	switch(choice) {
		
		case 1:
				polarBear.setAttribute("href", "./easy/PolarBear.php");
				break;
		
		case 2:
				polarBear.setAttribute("href", "./medium/PolarBear.php");
				break;
		
		case 3:
				polarBear.setAttribute("href", "./difficult/PolarBear.php");
				break;
				
		default:
				alert("Invalid Option!!!");
				polarBear.setAttribute("href", "#polarBear");
				return;
		
	}
	
}

function lynxLevelDec() {
	
	let choice = parseInt(prompt("Please choose the difficulty level:\n\n1. Easy\n2. Medium\n3. Difficult\n\nEnter 1, 2 or 3:"));
	
	if (isNaN(choice)) {
        alert("No choice made.");
		lynx.setAttribute("href", "#lynx");
        return;
    }
	
	switch(choice) {
		
		case 1:
				lynx.setAttribute("href", "./easy/Lynx.php");
				break;
		
		case 2:
				lynx.setAttribute("href", "./medium/Lynx.php");
				break;
		
		case 3:
				lynx.setAttribute("href", "./difficult/Lynx.php");
				break;
				
		default:
				alert("Invalid Option!!!");
				lynx.setAttribute("href", "#lynx");
				return;
		
	}
	
}

function cheetahLevelDec() {
	
	let choice = parseInt(prompt("Please choose the difficulty level:\n\n1. Easy\n2. Medium\n3. Difficult\n\nEnter 1, 2 or 3:"));
	
	if (isNaN(choice)) {
        alert("No choice made.");
		cheetah.setAttribute("href", "#cheetah");
        return;
    }
	
	switch(choice) {
		
		case 1:
				cheetah.setAttribute("href", "./easy/Cheetah.php");
				break;
		
		case 2:
				cheetah.setAttribute("href", "./medium/Cheetah.php");
				break;
		
		case 3:
				cheetah.setAttribute("href", "./difficult/Cheetah.php");
				break;
				
		default:
				alert("Invalid Option!!!");
				cheetah.setAttribute("href", "#cheetah");
				return;
		
	}
	
}