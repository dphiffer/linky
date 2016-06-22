jQuery(document).ready(function($) {
	var txt = null;
	var max = 0;
	var waitInterval;
	$.get('/linky/txt/index.json', function(index) {
		var txtMatch = location.pathname.match(/linky\/([^\/]+)/);
		if (txtMatch) {
			txt = txtMatch[1];
		}
		if (txt && index[txt]) {
			max = index[txt].max;
			window.addEventListener('hashchange', update, false);
			update();
		}
		var wait = location.search.match(/wait=(\d+)/);
		if (wait) {
			wait = parseInt(wait[1]);
			waitInterval = setInterval(function() {
				var num = parseInt(location.hash.substr(1));
				if (isNaN(num)) {
					num = 0;
				}
				num++;
				if (num < max) {
					window.location = '#' + num;
				} else {
					window.location = '#0';
				}
			}, wait * 1000);
		}
	});
	function update() {
		var num = parseInt(location.hash.substr(1));
		if (isNaN(num)) {
			num = 0;
		}
		$.get('/linky/txt/' + txt + '/' + num + '.txt', function(txt) {
			$('#txt').html(txt);
			if (num < max) {
				$('#txt').attr('href', '#' + (num + 1));
			} else {
				$('#txt').attr('href', '#0');
			}
			window.scrollTo(0, 0);
		});
	}
	$('#txt').click(function(e) {
		if (waitInterval) {
			clearInterval(waitInterval);
		}
	});
});
