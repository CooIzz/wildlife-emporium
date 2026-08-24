/*

---------------For quiz_crud.php page---------------

*/

//Extract html elements from the document

const form = document.getElementById("quizCrudForm");

const submit = document.getElementById("submit");

//Adding event listener to prevent form from being 
//submitted in case of any errors

form.addEventListener("submit", e => {
	
	if(!validateForm())
	{
		e.preventDefault();
	}
	
});

//Adding event listener to validate form 
//after clicking the submit Button

submit.addEventListener("click", validateForm);

	//Function to validate the form

	function validateForm()
	{

	//Clearing previous error messages

	const errors = document.querySelectorAll(".error");

	errors.forEach(error => {
		
		error.innerHTML = "";
		
	});

	let isValid = true;
	
	if(form['crudOperation'].value.trim() === "")
	{
		document.getElementById("crudError").innerHTML = "Please select your desired operation.";
		isValid = false;
	}
	else if(form['crudOperation'].value.trim() === "Create")
	{
		form.setAttribute("action", "quiz_create.php");
	}
	else if(form['crudOperation'].value.trim() === "Read")
	{
		form.setAttribute("action", "quiz_read.php");
	}
	else if(form['crudOperation'].value.trim() === "Update")
	{
		form.setAttribute("action", "quiz_update.php");
	}
	else if(form['crudOperation'].value.trim() === "Delete")
	{
		form.setAttribute("action", "quiz_delete.php");
	}
	
	return isValid;
		
}


/*

---------------For quiz_create.php page---------------

*/

//Extract html elements from the document

const createForm = document.getElementById("createForm");

const createSubmit = document.getElementById("createSubmit");

//Adding event listener to prevent form from being 
//submitted in case of any errors

createForm.addEventListener("submit", event=> {
	
	if(!validateCreateForm())
	{
		event.preventDefault();
	}
	
});

//Adding event listener to validate createForm
//after clicking submit button

createSubmit.addEventListener("click", validateCreateForm);

//Function to validate create form

function validateCreateForm()
{
	//Clearing previous error messages

	const errors = document.querySelectorAll(".error");

	errors.forEach(error => {
		
		error.innerHTML = "";
		
	});
	
	let isValid = true;
	
	if(createForm['animal'].value.trim() === "")
	{
		document.getElementById("animalError").innerHTML = "Please select an animal.";
		isValid = false;
	}
	
	if(createForm['difficulty'].value.trim() === "")
	{
		document.getElementById("difficultyError").innerHTML = "Please select the difficulty level.";
		isValid = false;
	}
	
	if(createForm['queNum'].value.trim() === "")
	{
		document.getElementById("queNumError").innerHTML = "Please enter the question number.";
		isValid = false;
	}
	else if(parseInt(createForm['queNum'].value.trim(), 10) <= 0)
	{
		document.getElementById("queNumError").innerHTML = "Question number must be greater than 0.";
		isValid = false;
	}
	
	if(createForm['quizQuestion'].value.trim() === "")
	{
		document.getElementById("queError").innerHTML = "Please provide the question.";
		isValid = false;
	}
	
	if(createForm['optionA'].value.trim() === "")
	{
		document.getElementById("aError").innerHTML = "Please provide the option A answer to the question.";
		isValid = false;
	}
	
	if(createForm['optionB'].value.trim() === "")
	{
		document.getElementById("bError").innerHTML = "Please provide the option B answer to the question.";
		isValid = false;
	}
	
	if(createForm['optionC'].value.trim() === "")
	{
		document.getElementById("cError").innerHTML = "Please provide the option C answer to the question.";
		isValid = false;
	}
	
	if(createForm['optionD'].value.trim() === "")
	{
		document.getElementById("dError").innerHTML = "Please provide the option D answer to the question.";
		isValid = false;
	}
	
	if(createForm['cor_ans'].value.trim() === "")
	{
		document.getElementById("corAnsError").innerHTML = "Please select the correct answer to the question.";
		isValid = false;
	}
	
	return isValid;
	
}

/*

---------------For quiz_read.php page---------------

*/







