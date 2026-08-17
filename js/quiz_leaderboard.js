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