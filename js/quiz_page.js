window.addEventListener("pageshow", event => {
	
	if(event.persisted)
	{
		document.querySelectorAll("input[type='radio']").forEach(line => {
			
			line.checked = false;
			
		});
	}
	
});