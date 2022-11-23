<?php

function listExistingTags() {
	exec('git fetch --tags --quiet');

	exec('git tag --list', $output);

	$tags = [];
	foreach($output as $line) {
		$tags[] = trim($line);
	}

	sort($tags);

	return $tags;
}
