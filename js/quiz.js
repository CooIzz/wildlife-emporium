window.addEventListener("pageshow", event => {
	
	if(event.persisted)
	{
		document.querySelectorAll("input[type='radio']").forEach(line => {
			
			line.checked = false;
			
		});
	}
	
});

//Calling the anchor elements from the quiz index page
//and adding eventListeners to them for "click" events

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
