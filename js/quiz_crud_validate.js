//Adding event listener to validate form after
//clicking the submit button

crudForm.addEventListener("submit", validateCrudForm);

//Adding event listener to prevent form from being 
//submitted in case of any errors

crudForm.addEventListener("submit", event => {
	
	if(!validateCrudForm())
	{
		event.preventDefault();
	}
	
});

//Function to validate the crudForm

function validateCrudForm()
{
	if(crudOperation !== null)
	{
		//Clearing previous error messages

		let errors = document.querySelectorAll(".error");

		errors.forEach(error => {
			
			error.innerHTML = "";
			
		});
		
		let isValid = true;
		
		if(crudForm['animal'].value.trim() === "")
			{
				document.getElementById("animalError").innerHTML = "Please select an animal.";
				isValid = false;
			}
			
		if(crudForm['difficulty'].value.trim() === "")
			{
				document.getElementById("difficultyError").innerHTML = "Please select the difficulty level.";
				isValid = false;
			}
		
		if(crudOperation === "Create" || crudOperation === "Update")
		{
		
			
			if(crudForm['queNum'].value.trim() === "")
			{
				document.getElementById("queNumError").innerHTML = "Please enter the question number.";
				isValid = false;
			}
			else if(parseInt(crudForm['queNum'].value.trim(), 10) <= 0)
			{
				document.getElementById("queNumError").innerHTML = "Question number must be greater than 0.";
				isValid = false;
			}
			
			if(crudForm['quizQuestion'].value.trim() === "")
			{
				document.getElementById("queError").innerHTML = "Please provide the question.";
				isValid = false;
			}
			
			if(crudForm['optionA'].value.trim() === "")
			{
				document.getElementById("aError").innerHTML = "Please provide the option A answer to the question.";
				isValid = false;
			}
			
			if(crudForm['optionB'].value.trim() === "")
			{
				document.getElementById("bError").innerHTML = "Please provide the option B answer to the question.";
				isValid = false;
			}
			
			if(crudForm['optionC'].value.trim() === "")
			{
				document.getElementById("cError").innerHTML = "Please provide the option C answer to the question.";
				isValid = false;
			}
			
			if(crudForm['optionD'].value.trim() === "")
			{
				document.getElementById("dError").innerHTML = "Please provide the option D answer to the question.";
				isValid = false;
			}
			
			if(crudForm['cor_ans'].value.trim() === "")
			{
				document.getElementById("corAnsError").innerHTML = "Please select the correct answer to the question.";
				isValid = false;
			}
		}
		else if(crudOperation === "Read")
		{
			
			if(crudForm['numOfQue'].value.trim() === "")
			{
				document.getElementById("numOfQueError").innerHTML = "Please select the number of questions you wish to be displayed.";
				isValid = false;
			}
			else if(parseInt(crudForm['numOfQue'].value.trim(), 10) < 1)
			{
				document.getElementById("numOfQueError").innerHTML = "The number of questions to be displayed must be greater than 0.";
				isValid = false;
			}
			
			if(crudForm['firstQue'].value.trim() === "")
			{
				document.getElementById("firstQueError").innerHTML = "Please enter the number of the first question to be displayed.";
				isValid = false;
			}
			else if(isNaN(parseInt(crudForm['firstQue'].value.trim(), 10)))
			{
				document.getElementById("firstQueError").innerHTML = "Please enter a numeric value.";
				isValid = false;
			}
			else if(parseInt(crudForm['firstQue'].value.trim(), 10) < 1)
			{
				document.getElementById("firstQueError").innerHTML = "The numeric value must be greater than 0.";
				isValid = false;
			}
		}
		else if(crudOperation === "Delete")
		{
			if(crudForm['queNum'].value.trim() === "")
			{
				document.getElementById("queNumError").innerHTML = "Please enter the question number to be deleted.";
				isValid = false;
			}
			else if(isNaN(parseInt(crudForm['queNum'].value.trim(), 10)))
			{
				document.getElementById("queNumError").innerHTML = "Input must be a numeric value.";
				isValid = false;
			}
			else if(parseInt(crudForm['queNum'].value.trim(), 10) < 1)
			{
				document.getElementById("queNumError").innerHTML = "Number must be greater than 0.";
				isValid = false;
			}
		}
		
		return isValid;
	}
}



