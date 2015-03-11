jQuery(document).ready(function(){
	$('#start-button').on('click', function(ev){
		ev.preventDefault();
		var btn = $('#start-button').parent();
		btn.addClass('loader');
		var vals = {
			method : 'user::create'	
		};
		$.each($('#contact').serializeArray(), function(){
			vals[this.name] = this.value;
		});
		$.post(
			'/endpoint.php',
			vals
		)
		.done(function(res) {
			var result = $.parseJSON(res);
			if (result.success && result.message) {
				window.location.href = result.message;
			}
			else {
				alert(result.message);
				if(result.message) {
					btn.removeClass('loader');
				}
			}
		})
		.fail(function (res) {
			btn.removeClass('loader');
			console.log(res);
		});
	});
});