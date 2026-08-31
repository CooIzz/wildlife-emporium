/*

---------------For index.php page---------------

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

	let errors = document.querySelectorAll(".error");

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

	let errors = document.querySelectorAll(".error");

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

//Extract html elements from the form

const readForm = document.getElementById("readForm");

const readSubmit = document.getElementById("readSubmit");

//Adding event listener to prevent form from being submitted
//in case of any errors

readForm.addEventListener("submit", event => {
	
	if(!validateReadForm())
	{
		event.preventDefault();
	}
	
});

//Addingg event listener to validate form after user clicks
//the submit button

readSubmit.addEventListener("click", validateReadForm);

//Function to validate read form

function validateReadForm()
{		
	//Clearing previous error messages
	
	let errors = document.querySelecterAll(".error");
	
	errors.forEach(error => {
		
		error.innerHTML = "";
		
	});
	
	let isValid = true;
	
	if(readForm['animal'].value.trim() === "")
	{
		document.getElementById("animalError").innerHTML = "Please select an animal";
		isValid = false;
	}
	
	if(readForm['difficulty'].value.trim() === "")
	{
		document.getElementById("difficultyError").innerHTML = "Please select the difficulty level.";
		isValid = false;
	}
	
	if(readForm['numOfQue'].value.trim() === "")
	{
		document.getElementById("numOfQueError").innerHTML = "Please select the number of questions you wish to be displayed.";
		isValid = false;
	}
	else if(parseInt(readForm['numOfQue'].value.trim(), 10) < 1)
	{
		document.getElementById("numOfQueError").innerHTML = "The number of questions to be displayed must be greater than 0.";
		isValid = false;
	}
	
	if(readForm['firstQue'].value.trim() === "")
	{
		document.getElementById("firstQueError").innerHTML = "Please enter the number of the first question to be displayed.";
		isValid = false;
	}
	else if(isNaN(parseInt(readForm['firstQue'].value.trim(), 10)))
	{
		document.getElementById("firstQueError").innerHTML = "Please enter a numeric value.";
		isValid = false;
	}
	else if(parseInt(readForm['firstQue'].value.trim(), 10) < 1 || parseInt(readForm['firstQue'].value.trim(), 10) > 10)
	{
		document.getElementById("firstQueError").innerHTML = "The numeric value must be between 1 and 10.";
		isValid = false;
	}
	
	return isValid;
	
}

/*

---------------For quiz_update.php page---------------

*/

//Extract html elements from the form

const updateForm = document.getElementById("updateForm");

const updateSubmit = document.getElementById("updateSubmit");

//Adding event listener to prevent form from being submitted
//in case of any errors

updateForm.addEventListener("submit", event => {
	
	if(!validateUpdateForm())
	{
		event.preventDefault();
	}
	
});

//Adding event listener to validate the form
//upon clicking the submit button

updateSubmit.addEventListener("click", validateUpdateForm);

//Function to validate the Update form

function validateUpdateForm()
{
	//Clearing all previous error messages
	
	let errors = document.querySelectorAll(".error");
	errors.forEach(error => {
		
		error.innerHTML = "";
		
	});
	
	let isValid = true;
	
	if(updateForm['animal'].value.trim() === "")
	{
		document.getElementById("animalError").innerHTML = "Please select an animal of your choice.";
		isValid = false;
	}
	
	if(updateForm['difficulty'].value.trim() === "")
	{
		document.getElementById("difficultyError").innerHTML = "Please select the difficulty option.";
		isValid = false;
	}
	
	if(updateForm['queNum'].value.trim() === "")
	{
		document.getElementById("queNumError").innerHTML = "Please enter the question number to be updated.";
		isValid = false;
	}
	else if(parseInt(updateForm['queNum'].value.trim(), 10) < 1)
	{
		document.getElementById("queNumError").innerHTML = "The question number must be greater than 0.";
		isValid = false;
	}
	
	if(updateForm['updatedQuizQue'].value.trim() === "")
	{
		document.getElementById("updatedQuizQueError").innerHTML = "Please enter the updated the updated quiz question.";
		isValid = false;
	}
	
	if(updateForm['optionA'].value.trim() === "")
	{
		document.getElementById("aError").innerHTML = "Please enter the optionA answer.";
		isValid = false;
	}
	
	if(updateForm['optionB'].value.trim() === "")
	{
		document.getElementById("bError").innerHTML = "Please enter the optionB answer..";
		isValid = false;
	}
	
	if(updateForm['optionC'].value.trim() === "")
	{
		document.getElementById("cError").innerHTML = "Please enter the optionC answer..";
		isValid = false;
	}
	
	if(updateForm['optionD'].value.trim() === "")
	{
		document.getElementById("dError").innerHTML = "Please enter the optionD answer..";
		isValid = false;
	}
	
	if(updateForm['cor_ans'].value.trim() === "")
	{
		document.getElementById("corAnsError").innerHTML = "Please choose the correct answer among the options you provided.";
		isValid = false;
	}
	
	return isValid;
	
}

/*

---------------For quiz_delete.php page---------------

*/

//Extracting HTMl elements from the document

const deleteForm = document.getElementById("deleteForm");

const deleteSubmit = document.getElementById("deleteSubmit");

//Adding event listener to prevent form from being
//submitted in case of any errors

deleteForm.addEventListener("submit", event => {
	
	if(!validateDeleteForm())
	{
		event.preventDefault();
	}
	
});

//Adding event listener to validate form upon
//clicking the submit button

deleteSubmit.addEventListener("click", validateDeleteForm);

//Function to validate the Delete form

function validateDeleteForm()
{
	//Clearing previous error messages
	let errors = document.querySelectorAll(".error");
	errors.forEach(error => {
		
		error.innerHTML = "";
		
	});
	
	let isValid = true;
	
	if(deleteForm['animal'].value.trim() === "")
	{
		document.getElementById("animalError").innerHTML = "Please select the animal of your choice.";
		isValid = false;
	}
	
	if(deleteForm['difficulty'].value.trim() === "")
	{
		document.getElementById("difficultyError").innerHTML = "Please select the difficulty level of your choice.";
		isValid = false;
	}
	
	if(deleteForm['queNum'].value.trim() === "")
	{
		document.getElementById("queNumError").innerHTML = "Please enter the question number to be deleted.";
		isValid = false;
	}
	else if(parseInt(deleteForm['queNum'].value.trim(), 10) < 1)
	{
		document.getElementById("queNumError").innerHTML = "Question number must be greater than 1.";
		isValid = false;
	}
	
	return isValid;
}

