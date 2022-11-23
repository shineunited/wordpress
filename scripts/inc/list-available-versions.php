<?php

function listAvailableVersions() {
	$versionsJson = file_get_contents("https://packagist.org/packages/roots/wordpress-no-content.json");
	$versionsData = json_decode($versionsJson, true);

	$versions = [];
	foreach(array_keys($versionsData['package']['versions']) as $version) {
		if(preg_match("/^[0-9.]+$/", $version)) {
			$versions[] = trim($version);
		}
	}

	sort($versions);

	return $versions;
}
