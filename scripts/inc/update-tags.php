<?php

function updateTags($changes) {
	// configure user info
	$commands[] = 'git config --global user.name "Shine Admin"';
	$commands[] = 'git config --global user.email "admin@shineunited.com"';

	// update tags
	$changedTags = [];
	$changedTags['create'] = [];
	$changedTags['update'] = [];
	$changedTags['delete'] = [];
	$tagCommands = [];
	foreach($changes as $version => $change) {
		$changedTags[$change][] = $version;

		switch($change) {
			case 'create':
			case 'update':
				$tagCommands[] = 'git tag --force "' . $version . '"';
				break;
			case 'delete':
				$tagCommands[] = 'git push origin :refs/tags/' . $version;
				$tagCommands[] = 'git tag --delete "' . $version . '"';
				break;
			default:
				break;
		}
	}

	$changelog = [];
	$changelog[] = '## ' . date('r') . ' ##';
	if(count($changedTags['create']) > 0) {
		$changelog[] = 'Created: ' . implode(', ', $changedTags['create']);
	}
	if(count($changedTags['update']) > 0) {
		$changelog[] = 'Updated: ' . implode(', ', $changedTags['update']);
	}
	if(count($changedTags['delete']) > 0) {
		$changelog[] = 'Deleted: ' . implode(', ', $changedTags['delete']);
	}
	$changelog[] = "\n";

	$message = count($changedTags['create']) . ' Created, ' . count($changedTags['update']) . ' Updated, ' . count($changedTags['delete']) . ' Deleted.';

	$commands[] = 'git add "CHANGELOG"';
	$commands[] = 'git commit --message="' . $message . '"';
	$commands = array_merge($commands, $tagCommands);
	$commands[] = 'git push --quiet';
	$commands[] = 'git push --force --tags --quiet';

	file_put_contents('CHANGELOG', implode("\n", $changelog), FILE_APPEND);

	foreach($commands as $command) {
		exec($command);
	}

	echo $message . "\n";
}
