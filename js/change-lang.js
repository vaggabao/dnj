$(function() {
	$(document).on('click', '.lang-switch', function() {
		var lang = $(this).data('lang');
		var data = "lang=" + lang;
		$.ajax({
			data: data,
			type: 'POST',
			url: 'includes/change-lang.php'
		});
	});
});