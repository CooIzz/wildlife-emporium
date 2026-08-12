window.addEventListener("pageshow", event => {
	
	if(event.persisted)
	{
		document.querySelectAll("input[type='radio']").forEach(line => {
			
			line.checked = false;
			
		});
	}
	
});