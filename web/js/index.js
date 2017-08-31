$(function(){

	$('.menu .item')
	.tab()
	;

	$('select').on('change', function(){
		$('form').submit();
	});

	var ctx = document.getElementById("users").getContext("2d");
	new Chart(ctx).Bar(users);
	var ctx2 = document.getElementById("files").getContext("2d");
	new Chart(ctx2).Bar(files);
	var ctx3 = document.getElementById("ratio").getContext("2d");
	new Chart(ctx3).Bar(ratio);
});
