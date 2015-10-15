jQuery(document).ready(function($) {
	function update() {
		var num = parseInt(location.hash.substr(1));
		if (isNaN(num)) {
			num = 0;
		}
		$.get('/whale/txt/' + num + '.txt', function(txt) {
			$('#txt').html(txt);
			if (num < 23013) {
				$('#txt').attr('href', '#' + (num + 1));
			} else {
				$('#txt').attr('href', '#0');
			}
			window.scrollTo(0, 0);
		});
	}
	window.addEventListener('hashchange', update, false);
	update();
});
