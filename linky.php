<?php

// This is going to run for a long while
set_time_limit(0);
$start_time = time();
$sources = glob('txt/*.txt');

if (!empty($argc)) {
	// Run from the command line
	if (empty($argv[1])) {
		$sources = implode("\n", $sources);
		die("Usage: php linky.php txt/source.txt\n\nSources:\n$sources\n");
	}
} else if (empty($_GET['source'])) {
	// Or from a web browser
	foreach ($sources as $source) {
		echo "<a href=\"linky.php?source=$source\">$source</a><br>\n";
	}
	exit;
}

// Unicode, aww yiss
mb_internal_encoding('UTF-8');
header('Content-Type: text/plain; charset=utf-8');

// Load the full contents of source text
if (!empty($argv[1])) {
	$filename = $argv[1];
} else {
	$filename = str_replace('..', '', $_GET['source']);
}
if (!file_exists($filename)) {
	die("Not found: $filename\n");
}
$source = file_get_contents($filename);
$source_length = mb_strlen($source);
$break_chars = '.,;!?—';
$dir = str_replace('.txt', '', $filename);
if (!file_exists($dir)) {
	mkdir($dir);
}

// Set up state variables
$source_index = 0;
$txt_num = 0;
$curr_txt = '';

// Save $curr_txt to a file, reset state variables
function save_txt() {
	global $dir, $curr_txt, $txt_num, $source_index, $source_length;
	$curr_txt = preg_replace('/\s+/', ' ', $curr_txt);
	$curr_txt = trim($curr_txt);
	$time = elapsed_time();
	$percent = round(100 * $source_index / $source_length) . '%';
	if (!empty($curr_txt)) {
		echo "$txt_num.txt ($time $percent)\n----------------------------\n$curr_txt\n\n";
		flush();
		file_put_contents("$dir/$txt_num.txt", $curr_txt);
		$txt_num++;
		$curr_txt = '';
	}
}

// How long since $start_time?
function elapsed_time() {
	global $start_time;
	$elapsed = time() - $start_time;
	$hh = floor($elapsed / 3600);
	if ($hh < 10) {
		$hh = "0$hh";
	}
	$mm = floor($elapsed / 60);
	if ($mm < 10) {
		$mm = "0$mm";
	}
	$ss = $elapsed % 60;
	if ($ss < 10) {
		$ss = "0$ss";
	}
	return "$hh:$mm:$ss";
}

// Iterate over the full text, one character at a time
while ($source_index < $source_length) {
	$char = mb_substr($source, $source_index, 1);

	// If we reach a break character, and we have at least 25 characters...
	if (mb_strpos($break_chars, $char) !== false &&
	    mb_strlen($curr_txt) > 25) {

		// Append the character
		$curr_txt .= $char;

		// Include trailing quotation marks
		if (mb_substr($source, $source_index + 1, 1) == '"') {
			$curr_txt .= '"';
			$source_index++;
		}
		
		// Save the text
		save_txt();

	// If we reach two consecutive line breaks...
	} else if ($char == "\n" &&
	           mb_substr($source, $source_index, 2) == "\n\n") {
		
		// Save the text
		save_txt();

		// Skip the second line break
		$source_index++;

	// Still not ready to save, keep adding to the current text
	} else {
		$curr_txt .= $char;
	}

	// Next char
	$source_index++;
}

?>
