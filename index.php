<?php
/**
 * PHP Changelog Generator v0.1
 *
 * @author Raphael GONCALVES <contact@raphael-goncalves.fr>
 */
use Weysan\Phpclg\Changelog\GeneratorManager;
use Weysan\Phpclg\Changelog\GitLogManager;

require_once __DIR__ . '/autoload.php';

$request_options = getopt("dft:", ["dir:", "from:", "to:"]);
if (empty($request_options) || in_array(false, $request_options)) {
    throw new RuntimeException("Parameters are not facultative.");
}
$directory = isset($request_options['d'])?$request_options['d']:$request_options['dir'];
chdir($directory); //working directory

$gitLogManager = new GitLogManager();

$commits = $gitLogManager->getCommitsCollection($request_options);
$tagsRefs = $gitLogManager->getTagsReference();

$changelog_manager = new GeneratorManager('./CHANGELOG.md');
$changelog_manager->createFileFromCommitListAndTagsRef($commits, $tagsRefs);