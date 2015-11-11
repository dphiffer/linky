<?php

$index  = file_get_contents('txt/index.json');
$index  = json_decode($index);
$title  = 'Linky';
$url    = 'https://phiffer.org/linky/';

$og_title = 'Linky';
$og_description = 'Great novels serialized into tiny texts.';
$og_image = 'https://phiffer.org/linky/img/linky-facebook.jpg';
$twitter_image = 'https://phiffer.org/linky/img/linky-twitter.jpg';
$twitter_title = "Linky: $og_description";

$source = '';
if (preg_match('#linky/([^/]+)#', $_SERVER['REQUEST_URI'], $matches)) {
	$id = $matches[1];
	if (!empty($index->$id)) {
		$title  = "{$index->$id->title} by {$index->$id->author}";
		$url .= $id;
		$source = ", source: <a href=\"{$index->$id->source}\">Project Gutenberg</a>";
		$og_title = $title;
		$og_description = "Linky: $og_description";
	} else {
		header('Location: /linky/');
		exit;
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $title; ?></title>
		<meta property="og:title" content="<?php echo $og_title; ?>">
		<meta property="og:site_name" content="Linky">
		<meta property="og:url" content="<?php echo $url; ?>">
		<meta property="og:description" content="<?php echo $og_description; ?>">
		<meta property="og:type" content="article">
		<meta property="og:image" content="<?php echo $og_image; ?>">
		<meta name="twitter:card" content="photo">
		<meta name="twitter:site" content="@dphiffer">
		<meta name="twitter:title" content="<?php echo $twitter_title; ?>">
		<meta name="twitter:image" content="<?php echo $twitter_image; ?>">
		<meta name="twitter:url" content="<?php echo $url; ?>">
		<link rel="stylesheet" href="/linky/linky.css">
		<script src="/mint/?js&amp;ver=2.18"></script>
	</head>
	<body>
		<?php
		
		if ($title == 'Linky') {
			echo "<div id=\"txt\"><div class=\"title\"><h1><a href=\"https://github.com/dphiffer/linky\">Linky</a></h1><h2>Great novels serialized into tiny texts</h2></div><ul>";
			foreach (get_object_vars($index) as $id => $txt) {
				echo "<li><h1><a href=\"/linky/$id\">{$txt->title}</a></h1> <h2>by {$txt->author}</h2></li>";
			}
			echo '</ul></div>';
		} else {
			echo '<a href="#" id="txt"></a>';
		}
		
		?>

		<div id="about">With apologies to <a href="http://barackobamaisyournewbicycle.com/">BOIYNB</a>, more info on <a href="https://github.com/dphiffer/linky">GitHub</a><?php echo $source; ?></div>
		<script src="/linky/jquery-1.11.3.min.js"></script>
		<script src="/linky/linky.js"></script>
	</body>
</html>
