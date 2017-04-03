<?php
namespace Weysan\Phpclg\Changelog;

use Weysan\Phpclg\Git\GitCommand;
use Weysan\Phpclg\Git\GitOutputCommandParser;
use Weysan\Phpclg\Git\Operation\Log;
use Weysan\Phpclg\Git\Operation\ShowRefTags;
use Weysan\Phpclg\Git\Parser\TagsReference;

class GitLogManager
{
    /**
     * @param $request_options
     * @return \Weysan\Phpclg\Git\Parser\Commit[]
     */
    public function getCommitsCollection($request_options)
    {
        $git_log_cmd = GitCommand::createCommand(
            GitCommand::getOperation(
                Log::COMMAND_OPERATION_NAME,
                array(
                    'setMergesOnly' => true,
                    'setTags' => true,
                    'setFromTag' => isset($request_options['f'])?$request_options['f']:$request_options['from'],
                    'setToTag' => isset($request_options['t'])?$request_options['t']:$request_options['to']
                )
            )
        );

        $parser = new GitOutputCommandParser(
            GitCommand::exec($git_log_cmd)
        );
        return $parser->parse()->getCommits();
    }

    /**
     * @return TagsReference
     */
    public function getTagsReference()
    {
        $git_showrefs_cmd = GitCommand::createCommand(
            GitCommand::getOperation(
                ShowRefTags::COMMAND_OPERATION_NAME,
                array()
            )
        );

        $tags = GitCommand::exec($git_showrefs_cmd);
        $array_tags = explode("\n", $tags);

        $tags_parsed = array();
        foreach ($array_tags as $tag_ref) {
            if (empty($tag_ref)) {
                continue;
            }
            $array_ref = explode(" ", $tag_ref);
            $tags_parsed[$array_ref[0]] = $array_ref[1];
        }

        return new TagsReference($tags_parsed);
    }
}