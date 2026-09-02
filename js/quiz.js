window.addEventListener("pageshow", event => {
	
	if(event.persisted)
	{
		document.querySelectorAll("input[type='radio']").forEach(line => {
			
			line.checked = false;
			
		});
	}
	
});


/*
---------------For quiz/index.php page---------------
*/


//Calling the anchor elements from the quiz index page
//and adding eventListeners to them for "click" events

if(typeof quizAnimals !== "undefined")
{
	quizAnimals.forEach(animal => {
	
	const element = document.getElementById(animal['js_id']);
	
	if(!element)
	{
		return;
	}
	
	//If the user has already been logged in
	if(userID !== "")
	{
		element.addEventListener("click", function() {
		
		//Letting user choose difficulty level upon clicking
		let choice = parseInt(prompt("Please choose the difficulty level:\n\n1. Easy\n2. Medium\n3. Difficult\n\nEnter 1, 2 or 3:"));
		
		//If user did not enter any option
		if(isNaN(choice))
		{
			alert("No choice made.");
			element.setAttribute("href", `#${animal['js_id']}`);
			return;
		}
		
		switch(choice) {
			
			case 1:
					element.setAttribute("href", animal['easy_url']);
					break;
			
			case 2:
					element.setAttribute("href", animal['medium_url']);
					break;
					
			case 3:
					element.setAttribute("href", animal['difficult_url']);
					break;

			default:
					alert("Invalid Option!");
					element.setAttribute("href", `#${animal['js_id']}`);
					return;
			
		};
		
	});
	} else//If the user has not logged in yet
	{
		element.addEventListener("click", function() {
			
			alert("Please login before proceeding to partake in the quiz");
			window.location.href = loginURL;
			
		});
		
		
	}
		
})

}


/*
---------------For quiz/leaderboard.php page---------------
*/

const scoreboard_expand = document.getElementById('scoreboard_expand');

//Function to toggle CSS display property of table
//based on whether user is logged in or not
scoreboard_expand.addEventListener("click", event => {
	
	if(user_id !== 0)
	{		
		const scoreboard = document.getElementById('scoreboard');
		scoreboard.classList.toggle('hidden');
	}else
	{
		alert("Please login before proceeding!");
		window.location.href = loginURL;
		
	}
	
});
