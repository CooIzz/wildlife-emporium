/*

--------------------For manageQuiz.php page--------------------

*/

window.addEventListener("pageshow", event => {
	
	if(event.persisted)
	{
		const quizCrudForm = document.getElementById("quizCrudForm");
        if (quizCrudForm) {
            quizCrudForm.reset();
        }
	}
	
});

//Extract html elements from the document

const form = document.getElementById("quizCrudForm");

const submit = document.getElementById("submit");

//Adding event listener to prevent form from being 
//submitted in case of any errors

form.addEventListener("submit", e => {
	
	if(!validateMainForm())
	{
		e.preventDefault();
	}
	
});

//Adding event listener to validate form 
//after clicking the submit Button

submit.addEventListener("click", validateMainForm);

//Function to validate the mainForm

function validateMainForm()
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

	return isValid;
		
}



