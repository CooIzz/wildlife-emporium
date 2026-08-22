//Extract html elements from the document

const form = document.getElementById("quizCrudForm");

const submit = document.getElementById("submit");

//Add event listener to prevent form from being 
//submitted in case of any errors

form.addEventListener("submit", e => {
	
	if(!validateForm())
	{
		e.preventDefault();
	}
	
});

//Add event listener to validate form 
//after clicking the submit Button

submit.addEventListener("click", validateForm);

//Function to validate the form

function validateForm()
{
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
