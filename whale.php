<?php

// This is going to run for a long while
set_time_limit(0);
$start_time = time();

// Unicode, aww yiss
mb_internal_encoding('UTF-8');
header('Content-Type: text/plain; charset=utf-8');

// Load the full contents of Moby Dick
$source = file_get_contents('whale.txt');
$break_chars = '.,;!?—';

// Set up state variables
$source_index = 0;
$txt_num = 0;
$curr_txt = '';

// Save $curr_txt to a file, reset state variables
function save_txt() {
	global $curr_txt, $txt_num;
	$curr_txt = preg_replace('/\s+/', ' ', $curr_txt);
	$curr_txt = trim($curr_txt);
	if (!empty($curr_txt)) {
		echo "$txt_num\n---------\n$curr_txt\n\n";
		flush();
		if (!file_exists('txt')) {
			mkdir('txt');
		}
		file_put_contents("txt/$txt_num.txt", $curr_txt);
		$txt_num++;
		$curr_txt = '';
	}
}

// Iterate over the full text, one character at a time
while ($source_index < mb_strlen($source)) {
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
