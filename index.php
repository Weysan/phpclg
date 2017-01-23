<?php
/**
 * PHP Changelog Generator v0.1
 *
 * @author Raphael GONCALVES <contact@raphael-goncalves.fr>
 */
require_once __DIR__ . '/autoload.php';

$request_options = getopt("dft:", ["dir:", "from:", "to:"]);
if (empty($request_options) || in_array(false, $request_options)) {
    throw new RuntimeException("Parameters are not facultative.");
}
$directory = isset($request_options['d'])?$request_options['d']:$request_options['dir'];
chdir($directory); //working directory

$git_log_cmd = \Weysan\Phpclg\Git\GitCommand::createCommand(
    \Weysan\Phpclg\Git\GitCommand::getOperation(
        \Weysan\Phpclg\Git\Operation\Log::COMMAND_OPERATION_NAME,
        array(
            'setMergesOnly' => true,
            'setFromTag' => isset($request_options['f'])?$request_options['f']:$request_options['from'],
            'setToTag' => isset($request_options['t'])?$request_options['t']:$request_options['to']
        )
    )
);

$parser = new \Weysan\Phpclg\Git\GitOutputCommandParser(
    \Weysan\Phpclg\Git\GitCommand::exec($git_log_cmd)
);
$commits = $parser->parse()->getCommits();

if ($commits) {
    $changelog_manager = \Weysan\Phpclg\Markdown\MarkdownFile::getManager('./CHANGELOG.md');

    $title = new \Weysan\Phpclg\Markdown\ContentPart\TitlePart();
    $title->setContent("Changelog");

    $changelog_manager->addContent($title);

    foreach ($commits as $index => $commit) {
        $listPart = new \Weysan\Phpclg\Markdown\ContentPart\ListItemPart();
        $listPart->setContent("titre $index");
        $listPart->setDescription($commit->getMessage());
        $changelog_manager->addContent($listPart);
    }

    $changelog_manager->save();
}