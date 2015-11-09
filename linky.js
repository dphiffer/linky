jQuery(document).ready(function($) {
	var txt = null;
	var max = 0;
	$.get('txt/index.json', function(index) {
		var txtMatch = location.pathname.match(/linky\/([^\/]+)$/);
		if (txtMatch) {
			txt = txtMatch[1];
		}
		if (txt && index[txt]) {
			max = index[txt].max;
			window.addEventListener('hashchange', update, false);
			update();
			document.title = index[txt].title;
		} else {
			var texts = [];
			for (txt in index) {
				texts.push('<a href="' + txt + '">' + index[txt].title + '</a>');
			}
			$('#txt').remove();
			$(document.body).append('<div id="txt">Linky / ' + texts.join(' / ') + '</div>');
		}
	});
	function update() {
		var num = parseInt(location.hash.substr(1));
		if (isNaN(num)) {
			num = 0;
		}
		$.get('txt/' + txt + '/' + num + '.txt', function(txt) {
			$('#txt').html(txt);
			if (num < max) {
				$('#txt').attr('href', '#' + (num + 1));
			} else {
				$('#txt').attr('href', '#0');
			}
			window.scrollTo(0, 0);
		});
	}
});
