<?php
/**
 * PHP Changelog Generator v0.1
 *
 * @author Raphael GONCALVES <contact@raphael-goncalves.fr>
 */
require_once __DIR__ . '/autoload.php';

$git_log_cmd = \Weysan\Phpclg\Git\GitCommand::createCommand(
    \Weysan\Phpclg\Git\GitCommand::getOperation(
        \Weysan\Phpclg\Git\Operation\Log::COMMAND_OPERATION_NAME,
        array(
            'setMergesOnly' => true,
            'setFromTag' => 'tagA',
            'setToTag' => 'tagB'
        )
    )
);

$return = \Weysan\Phpclg\Git\GitCommand::exec($git_log_cmd);

$parser = new \Weysan\Phpclg\Git\GitOutputCommandParser($return);
$parser->parse();