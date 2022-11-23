<?php

function findChanges($versions, $tags) {
	$changes = [];

	foreach($versions as $version) {
		if(in_array($version, $tags)) {
			$changes[$version] = 'update';
		} else {
			$changes[$version] = 'create';
		}
	}

	foreach($tags as $tag) {
		if(!in_array($tag, $versions)) {
			$changes[$tag] = 'delete';
		}
	}

	ksort($changes);

	return $changes;
}
