$(document).ready(function() {
	var addCauses = $("#add_causes");
	var addSyms = $("#add_syms");
	var causesContainer = $("#causes_container");
	var symsContainer = $("#syms_container");

	$(addCauses).click(function(e) {
		e.preventDefault();
		var html = "<input type='text' name='causes[]' placeholder='Add Cause'/><br>";
		$(causesContainer).append(html);
	});
	$(addSyms).click(function(e) {
		e.preventDefault();
		var html = "<input type='text' name='syms[]' placeholder='Add Symptom'/><br>";
		$(symsContainer).append(html);
	});
});