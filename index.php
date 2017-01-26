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
            'setTags' => true,
            'setFromTag' => isset($request_options['f'])?$request_options['f']:$request_options['from'],
            'setToTag' => isset($request_options['t'])?$request_options['t']:$request_options['to']
        )
    )
);

$git_showrefs_cmd = \Weysan\Phpclg\Git\GitCommand::createCommand(
    \Weysan\Phpclg\Git\GitCommand::getOperation(
        \Weysan\Phpclg\Git\Operation\ShowRefTags::COMMAND_OPERATION_NAME,
        array()
    )
);

$parser = new \Weysan\Phpclg\Git\GitOutputCommandParser(
    \Weysan\Phpclg\Git\GitCommand::exec($git_log_cmd)
);
$commits = $parser->parse()->getCommits();


$tags = \Weysan\Phpclg\Git\GitCommand::exec($git_showrefs_cmd);
$array_tags = explode("\n", $tags);

$tags_parsed = array();
foreach ($array_tags as $tag_ref) {
    if (empty($tag_ref)) {
        continue;
    }
    $array_ref = explode(" ", $tag_ref);
    $tags_parsed[$array_ref[0]] = $array_ref[1];
}

$tagsRefs = new \Weysan\Phpclg\Git\Parser\TagsReference($tags_parsed);


if ($commits) {
    $changelog_manager = \Weysan\Phpclg\Markdown\MarkdownFile::getManager('./CHANGELOG.md');

    $title = new \Weysan\Phpclg\Markdown\ContentPart\TitlePart();
    $title->setContent("Changelog");

    $changelog_manager->addContent($title);

    foreach ($commits as $index => $commit) {
        if ($tagsRefs->isCommitReferencedTag($commit)) {
            $tag = new \Weysan\Phpclg\Markdown\ContentPart\TitlePart();
            $tag->setTitleLevel(\Weysan\Phpclg\Markdown\ContentPart\TitlePart::SUB_TITLE_LEVEL);
            $tag->setContent($tagsRefs->isCommitReferencedTag($commit));

            $changelog_manager->addContent($tag);
        }

        if ($commit->getMergeTitle() && $commit->isMerge()) {
            $listPart = new \Weysan\Phpclg\Markdown\ContentPart\ListItemPart();
            $listPart->setContent($commit->getMergeTitle());
            $listPart->setDescription($commit->getMergeDescription());
            $changelog_manager->addContent($listPart);
        }
    }

    $changelog_manager->save();
}