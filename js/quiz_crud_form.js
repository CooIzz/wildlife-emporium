/*

--------------------For quiz_crud.php page--------------------

*/

//Extract html elements from document

const crudForm = document.getElementById("crudForm");

const crudSubmit = document.getElementById("crudSubmit");

//Checking the type CRUD operation selected

const urlParams = new URLSearchParams(window.location.search);
const crudOperation = urlParams.get('crudOperation'); 

if(crudOperation !== null)
{
	switch(crudOperation)
	{
		case "Create":
			changeForm();
			break;
		
		case "Read":
			readForm();
			break;
			
		case "Update":
			changeForm();
			break;
			
		case "Delete":
			deleteForm();
			break;
			
		default:
			alert("Invalid option!");
			break;
	}
}

/*
	-----Function for CREATE and UPDATE operation-----
*/
function changeForm()
{
	
	const animals = ["African Lion", "Orang Utan", "Penguin", "Tiger", "Giant Panda", "Raccoon", "Snow Leopard", "Polar Bear", "Lynx", "Cheetah"];

	const difficulties = ["easy", "medium", "difficult"];

	const ansOptions = ["A", "B", "C", "D"];
	
	//Creating hidden input element for back-end database interaction
	const crudInput = document.createElement("input");
	crudInput.type = "hidden";
	crudInput.id = "crudInput";
	crudInput.name = "crudInput";
	crudInput.setAttribute("value", crudOperation);
	
	crudForm.appendChild(crudInput);
	
	//Creating form header
	const h1 = document.createElement("h1");
	h1.innerHTML = (crudOperation === "Create") ? "Quiz Create" : "Quiz Update";
	
	const strong = document.createElement("strong");
	strong.innerHTML = "Please fill up following fields.";
	
	//Appending created html elements to crudForm
	crudForm.appendChild(h1);
	crudForm.appendChild(strong);
	
	/*----------Question to choose animal choice----------*/
	
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(document.createElement("br"));
	
	//Creating label element
	const animalLabel = document.createElement("label");
	animalLabel.innerHTML = "Animal Choice:";
	animalLabel.setAttribute("for", "animal");
	
	crudForm.appendChild(animalLabel);
	crudForm.appendChild(document.createElement("br"));
			
	//Creating select(drop-down list) element
	const animalSelect = document.createElement("select");
	animalSelect.id = "animal";
	animalSelect.name = "animal";
		
	//Creating option elements
	const animalDefaultOption = document.createElement("option");
	animalDefaultOption.innerHTML = "--Select the Animal of Your Choice--";
	animalDefaultOption.setAttribute("value", "");
	animalDefaultOption.disabled = true;
	animalDefaultOption.selected = true;
	animalSelect.appendChild(animalDefaultOption);
	
	animals.forEach(animal => {
		
		let option = document.createElement("option");
		option.setAttribute("value", animal);
		option.innerHTML = animal;
		animalSelect.appendChild(option);
		
	});

	crudForm.appendChild(animalSelect);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating div element to store error message
	const animalErrorDiv = document.createElement("div");
	animalErrorDiv.id = "animalError";
	animalErrorDiv.classList.add("error");
	
	crudForm.appendChild(animalErrorDiv);
	
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(document.createElement("br"));
	
	/*----------Question for difficulty level----------*/
	
	//Creating label element
	const difficultyLabel = document.createElement("label");
	difficultyLabel.innerHTML = "Difficulty Level:";
	difficultyLabel.setAttribute("for", "difficulty");
	
	crudForm.appendChild(difficultyLabel);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating select(drop-down list) element
	const difficultySelect = document.createElement("select");
	difficultySelect.id = "difficulty";
	difficultySelect.name = "difficulty";
	
	
	//Creating option elements
	const difficultyDefaultOption = document.createElement("option");
	difficultyDefaultOption.innerHTML = "--Select the Difficulty Level--";
	difficultyDefaultOption.setAttribute("value", "");
	difficultyDefaultOption.disabled = true;
	difficultyDefaultOption.selected = true;
	difficultySelect.appendChild(difficultyDefaultOption);	
	
	difficulties.forEach(difficulty => {
		
		const option = document.createElement("option");
		option.setAttribute("value", difficulty);
		option.innerHTML = difficulty;
		difficultySelect.appendChild(option);
		
	});
	
	crudForm.appendChild(difficultySelect);
	crudForm.appendChild(document.createElement("br"));
	
	
	//Creating div element to store error message
	const difficultyErrorDiv = document.createElement("div");
	difficultyErrorDiv.id = "difficultyError";
	difficultyErrorDiv.classList.add("error");
	
	crudForm.appendChild(difficultyErrorDiv);
	
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(document.createElement("br"));
	
	/*----------Question for new Quiz Question Number----------*/
	
	//Creating label element
	const queNumLabel = document.createElement("label");
	queNumLabel.innerHTML = "Please enter the Question Number:";
	queNumLabel.setAttribute("for", "queNum");
	
	crudForm.appendChild(queNumLabel);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating input element
	const queNumInput = document.createElement("input");
	queNumInput.type = "number";
	queNumInput.id = "queNum";
	queNumInput.name = "queNum";
	
	crudForm.appendChild(queNumInput);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating div element to store error message
	const queNumErrorDiv = document.createElement("div");
	queNumErrorDiv.id = "queNumError";
	queNumErrorDiv.classList.add("error");
	
	crudForm.appendChild(queNumErrorDiv);
	
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(document.createElement("br"));
	
	/*----------Question for Quiz Question text----------*/
	
	//Creating label element
	const quizQueLabel = document.createElement("label");
	quizQueLabel.innerHTML = "Question:";
	quizQueLabel.setAttribute("for", "quizQuestion");
	
	crudForm.appendChild(quizQueLabel);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating textarea element
	const quizQueTextArea = document.createElement("textarea");
	quizQueTextArea.id = "quizQuestion";
	quizQueTextArea.name = "quizQuestion";
	quizQueTextArea.placeholder = "Please enter the quiz question here.";
	
	crudForm.appendChild(quizQueTextArea);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating div element to store error message
	const quizQueTextError = document.createElement("div");
	quizQueTextError.id = "queError";
	quizQueTextError.classList.add("error");
	
	crudForm.appendChild(quizQueTextError);
	
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(document.createElement("br"));
	
	const ansChoices = document.createElement("strong");
	ansChoices.innerHTML = "Answer Choices:";
	
	crudForm.appendChild(ansChoices);
	
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(document.createElement("br"));
	
	/*----------Option A answer----------*/
	
	//Creating label element
	const optionALabel = document.createElement("label");
	optionALabel.innerHTML = "Option A:";
	optionALabel.setAttribute("for", "optionA");
	
	crudForm.appendChild(optionALabel);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating input element
	const optionAInput = document.createElement("input");
	optionAInput.type = "text";
	optionAInput.id = "optionA";
	optionAInput.name = "optionA";
	
	crudForm.appendChild(optionAInput);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating div element to store error message
	const optionAErrorDiv = document.createElement("div");
	optionAErrorDiv.id = "aError";
	optionAErrorDiv.classList.add("error");
	
	crudForm.appendChild(optionAErrorDiv);
	
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(document.createElement("br"));
	
	/*----------Option B answer----------*/
	
	//Creating label element
	const optionBLabel = document.createElement("label");
	optionBLabel.innerHTML = "Option B:";
	optionBLabel.setAttribute("for", "optionB");
	
	crudForm.appendChild(optionBLabel);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating input element
	const optionBInput = document.createElement("input");
	optionBInput.type = "text";
	optionBInput.id = "optionB";
	optionBInput.name = "optionB";
	
	crudForm.appendChild(optionBInput);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating div element to store error message
	const optionBErrorDiv = document.createElement("div");
	optionBErrorDiv.id = "bError";
	optionBErrorDiv.classList.add("error");
	
	crudForm.appendChild(optionBErrorDiv);
	
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(document.createElement("br"));
	
	/*----------Option C answer----------*/
	
	//Creating label element
	const optionCLabel = document.createElement("label");
	optionCLabel.innerHTML = "Option C:";
	optionCLabel.setAttribute("for", "optionC");
	
	crudForm.appendChild(optionCLabel);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating input element
	const optionCInput = document.createElement("input");
	optionCInput.type = "text";
	optionCInput.id = "optionC";
	optionCInput.name = "optionC";
	
	crudForm.appendChild(optionCInput);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating div element to store error message
	const optionCErrorDiv = document.createElement("div");
	optionCErrorDiv.id = "cError";
	optionCErrorDiv.classList.add("error");
	
	crudForm.appendChild(optionCErrorDiv);
	
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(document.createElement("br"));
	
	/*----------Option D answer----------*/
	
	//Creating label element
	const optionDLabel = document.createElement("label");
	optionDLabel.innerHTML = "Option D:";
	optionDLabel.setAttribute("for", "optionD");
	
	crudForm.appendChild(optionDLabel);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating input element
	const optionDInput = document.createElement("input");
	optionDInput.type = "text";
	optionDInput.id = "optionD";
	optionDInput.name = "optionD";
	
	crudForm.appendChild(optionDInput);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating div element to store error message
	const optionDErrorDiv = document.createElement("div");
	optionDErrorDiv.id = "dError";
	optionDErrorDiv.classList.add("error");
	
	crudForm.appendChild(optionDErrorDiv);
	
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(document.createElement("br"));
	
	/*----------Correct Answer Choice----------*/
	
	//Creating label element
	const corAnsLabel = document.createElement("label");
	corAnsLabel.innerHTML = "Correct Answer:";
	corAnsLabel.setAttribute("for", "cor_ans");
	
	crudForm.appendChild(corAnsLabel);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating select(drop-down list) element
	const corAnsSelect = document.createElement("select");
	corAnsSelect.id = "cor_ans";
	corAnsSelect.name = "cor_ans";
	
	//Creating option elements
	const corAnsDefaultOption = document.createElement("option");
	corAnsDefaultOption.innerHTML = "--Select the Correct Answer--";
	corAnsDefaultOption.setAttribute("value", "");
	corAnsDefaultOption.disabled = true;
	corAnsDefaultOption.selected = true;
	
	corAnsSelect.appendChild(corAnsDefaultOption);
	
	ansOptions.forEach(ansOption => {
		
		const option = document.createElement("option");	
		option.innerHTML = `Option ${ansOption}`;
		option.setAttribute("value", ansOption);
		corAnsSelect.appendChild(option);
		
	});
	
	crudForm.appendChild(corAnsSelect);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating div element to store error message
	const corAnsErrorDiv = document.createElement("div");
	corAnsErrorDiv.id = "corAnsError";
	corAnsErrorDiv.classList.add("error");
	
	crudForm.appendChild(corAnsErrorDiv);
	
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(document.createElement("br"));
	
	/*----------Submit-type input for form submission----------*/
	const crudSubmit = document.createElement("input");
	crudSubmit.type = "submit";
	crudSubmit.id = "crudSubmit";
	crudSubmit.name = "crudSubmit";
	crudSubmit.classList.add("submitButtons");
	crudSubmit.setAttribute("value", "submit");
	
	crudForm.appendChild(crudSubmit);
	
}



/*
	-----Function for READ operation-----
*/

function readForm()
{
	
	const animals = ["African Lion", "Orang Utan", "Penguin", "Tiger", "Giant Panda", "Raccoon", "Snow Leopard", "Polar Bear", "Lynx", "Cheetah"];

	const difficulties = ["easy", "medium", "difficult"];

	const ansOptions = ["A", "B", "C", "D"];
	
	//Creating hidden input element for back-end database interaction
	const crudInput = document.createElement("input");
	crudInput.type = "hidden";
	crudInput.id = "crudInput";
	crudInput.name = "crudInput";
	crudInput.setAttribute("value", crudOperation);
	
	crudForm.appendChild(crudInput);
	
	//Creating form header
	const h1 = document.createElement("h1");
	h1.innerHTML = "Quiz Read";
	
	const strong = document.createElement("strong");
	strong.innerHTML = "Please fill up following fields.";
	
	//Appending created html elements to crudForm
	crudForm.appendChild(h1);
	crudForm.appendChild(strong);
	
	/*----------Question to choose animal choice----------*/
	
	//Creating label element
	const animalLabel = document.createElement("label");
	animalLabel.innerHTML = "Animal Choice:";
	animalLabel.setAttribute("for", "animal");
			
	//Creating select(drop-down list) element
	const animalSelect = document.createElement("select");
	animalSelect.id = "animal";
	animalSelect.name = "animal";
		
	//Creating option elements
	const animalDefaultOption = document.createElement("option");
	animalDefaultOption.innerHTML = "--Select the Animal of Your Choice--";
	animalDefaultOption.setAttribute("value", "");
	animalDefaultOption.disabled = true;
	animalDefaultOption.selected = true;
	animalSelect.appendChild(animalDefaultOption);
	
	animals.forEach(animal => {
		
		const option = document.createElement("option");
		option.setAttribute("value", animal);
		option.innerHTML = animal;
		animalSelect.appendChild(option);
		
	});
	
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(document.createElement("br"));

	crudForm.appendChild(animalLabel);
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(animalSelect);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating div element to store error message
	const animalErrorDiv = document.createElement("div");
	animalErrorDiv.id = "animalError";
	animalErrorDiv.classList.add("error");
	
	crudForm.appendChild(animalErrorDiv);
	
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(document.createElement("br"));
	
	/*----------Question for difficulty level----------*/
	
	//Creating label element
	const difficultyLabel = document.createElement("label");
	difficultyLabel.innerHTML = "Difficulty Level:";
	difficultyLabel.setAttribute("for", "difficulty");
	
	//Creating select(drop-down list) element
	const difficultySelect = document.createElement("select");
	difficultySelect.id = "difficulty";
	difficultySelect.name = "difficulty";
	
	
	//Creating option elements
	const difficultyDefaultOption = document.createElement("option");
	difficultyDefaultOption.innerHTML = "--Select the Difficulty Level--";
	difficultyDefaultOption.setAttribute("value", "");
	difficultyDefaultOption.disabled = true;
	difficultyDefaultOption.selected = true;
	difficultySelect.appendChild(difficultyDefaultOption);	
	
	difficulties.forEach(difficulty => {
		
		const option = document.createElement("option");
		option.setAttribute("value", difficulty);
		option.innerHTML = difficulty;
		difficultySelect.appendChild(option);
		
	});
	
	
	crudForm.appendChild(difficultyLabel);
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(difficultySelect);
	crudForm.appendChild(document.createElement("br"));
	
	
	//Creating div element to store error message
	const difficultyErrorDiv = document.createElement("div");
	difficultyErrorDiv.id = "difficultyError";
	difficultyErrorDiv.classList.add("error");
	
	crudForm.appendChild(difficultyErrorDiv);
	
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(document.createElement("br"));
	
	/*----------Question to determine number of quiz questions to be displayed----------*/
	
	//Creating label element
	const numOfQueLabel = document.createElement("label");
	numOfQueLabel.innerHTML = "Please enter the number of questions you wish to view::";
	numOfQueLabel.setAttribute("for", "numOfQue");
	
	//Creating input element
	const numOfQueInput = document.createElement("input");
	numOfQueInput.type = "number";
	numOfQueInput.id = "numOfQue";
	numOfQueInput.name = "numOfQue";
	
	crudForm.appendChild(numOfQueLabel);
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(numOfQueInput);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating div element to store error message
	const numOfQueErrorDiv = document.createElement("div");
	numOfQueErrorDiv.id = "numOfQueError";
	numOfQueErrorDiv.classList.add("error");
	
	crudForm.appendChild(numOfQueErrorDiv);
	
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(document.createElement("br"));
	
	/*----------Question to determine the 1st question to be displayed----------*/
	
	//Creating label element
	const firstQueLabel = document.createElement("label");
	firstQueLabel.innerHTML = "Please enter the number of the first question to be displayed:";
	firstQueLabel.setAttribute("for", "firstQue");
	
	//Creating input element
	const firstQueInput = document.createElement("input");
	firstQueInput.type = "number";
	firstQueInput.id = "firstQue";
	firstQueInput.name = "firstQue";
	
	crudForm.appendChild(firstQueLabel);
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(firstQueInput);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating div element to store error message
	const firstQueErrorDiv = document.createElement("div");
	firstQueErrorDiv.id = "firstQueError";
	firstQueErrorDiv.classList.add("error");
	
	crudForm.appendChild(firstQueErrorDiv);
	
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(document.createElement("br"));
	
	/*----------Submit-type input for form submission----------*/
	const crudSubmit = document.createElement("input");
	crudSubmit.type = "submit";
	crudSubmit.id = "crudSubmit";
	crudSubmit.name = "crudSubmit";
	crudSubmit.classList.add("submitButtons");
	crudSubmit.setAttribute("value", "submit");
	
	crudForm.appendChild(crudSubmit);
}




/*
	-----Function for DELETE operation-----
*/

function deleteForm()
{
	const animals = ["African Lion", "Orang Utan", "Penguin", "Tiger", "Giant Panda", "Raccoon", "Snow Leopard", "Polar Bear", "Lynx", "Cheetah"];

	const difficulties = ["easy", "medium", "difficult"];

	const ansOptions = ["A", "B", "C", "D"];
	
	//Creating hidden input element for back-end database interaction
	const crudInput = document.createElement("input");
	crudInput.type = "hidden";
	crudInput.id = "crudInput";
	crudInput.name = "crudInput";
	crudInput.setAttribute("value", crudOperation);
	
	crudForm.appendChild(crudInput);
	
	//Creating form header
	const h1 = document.createElement("h1");
	h1.innerHTML = "Quiz Delete";
	
	const strong = document.createElement("strong");
	strong.innerHTML = "Please fill up following fields.";
	
	//Appending created html elements to crudForm
	crudForm.appendChild(h1);
	crudForm.appendChild(strong);
	
	/*----------Question to choose animal choice----------*/
	
	//Creating label element
	const animalLabel = document.createElement("label");
	animalLabel.innerHTML = "Animal Choice:";
	animalLabel.setAttribute("for", "animal");
			
	//Creating select(drop-down list) element
	const animalSelect = document.createElement("select");
	animalSelect.id = "animal";
	animalSelect.name = "animal";
		
	//Creating option elements
	const animalDefaultOption = document.createElement("option");
	animalDefaultOption.innerHTML = "--Select the Animal of Your Choice--";
	animalDefaultOption.setAttribute("value", "");
	animalDefaultOption.disabled = true;
	animalDefaultOption.selected = true;
	animalSelect.appendChild(animalDefaultOption);
	
	animals.forEach(animal => {
		
		const option = document.createElement("option");
		option.setAttribute("value", animal);
		option.innerHTML = animal;
		animalSelect.appendChild(option);
		
	});
	
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(document.createElement("br"));

	crudForm.appendChild(animalLabel);
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(animalSelect);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating div element to store error message
	const animalErrorDiv = document.createElement("div");
	animalErrorDiv.id = "animalError";
	animalErrorDiv.classList.add("error");
	
	crudForm.appendChild(animalErrorDiv);
	
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(document.createElement("br"));
	
	/*----------Question for difficulty level----------*/
	
	//Creating label element
	const difficultyLabel = document.createElement("label");
	difficultyLabel.innerHTML = "Difficulty Level:";
	difficultyLabel.setAttribute("for", "difficulty");
	
	//Creating select(drop-down list) element
	const difficultySelect = document.createElement("select");
	difficultySelect.id = "difficulty";
	difficultySelect.name = "difficulty";
	
	
	//Creating option elements
	const difficultyDefaultOption = document.createElement("option");
	difficultyDefaultOption.innerHTML = "--Select the Difficulty Level--";
	difficultyDefaultOption.setAttribute("value", "");
	difficultyDefaultOption.disabled = true;
	difficultyDefaultOption.selected = true;
	difficultySelect.appendChild(difficultyDefaultOption);	
	
	difficulties.forEach(difficulty => {
		
		const option = document.createElement("option");
		option.setAttribute("value", difficulty);
		option.innerHTML = difficulty;
		difficultySelect.appendChild(option);
		
	});
	
	
	crudForm.appendChild(difficultyLabel);
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(difficultySelect);
	crudForm.appendChild(document.createElement("br"));
	
	
	//Creating div element to store error message
	const difficultyErrorDiv = document.createElement("div");
	difficultyErrorDiv.id = "difficultyError";
	difficultyErrorDiv.classList.add("error");
	
	crudForm.appendChild(difficultyErrorDiv);
	
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(document.createElement("br"));
	
	/*----------Question for Quiz Question Number----------*/
	
	//Creating label element
	const queNumLabel = document.createElement("label");
	queNumLabel.innerHTML = "Please enter the Question Number to be Deleted:";
	queNumLabel.setAttribute("for", "queNum");
	
	//Creating input element
	const queNumInput = document.createElement("input");
	queNumInput.type = "number";
	queNumInput.id = "queNum";
	queNumInput.name = "queNum";
	queNumInput.min = "1";
	
	crudForm.appendChild(queNumLabel);
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(queNumInput);
	crudForm.appendChild(document.createElement("br"));
	
	//Creating div element to store error message
	const queNumErrorDiv = document.createElement("div");
	queNumErrorDiv.id = "queNumError";
	queNumErrorDiv.classList.add("error");
	
	crudForm.appendChild(queNumErrorDiv);
	
	crudForm.appendChild(document.createElement("br"));
	crudForm.appendChild(document.createElement("br"));	
	
	/*----------Submit-type input for form submission----------*/
	const crudSubmit = document.createElement("input");
	crudSubmit.type = "submit";
	crudSubmit.id = "crudSubmit";
	crudSubmit.name = "crudSubmit";
	crudSubmit.classList.add("submitButtons");
	crudSubmit.setAttribute("value", "submit");
	
	crudForm.appendChild(crudSubmit);
}


