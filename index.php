<?php
/**
 * PHP Changelog Generator v0.1
 *
 * @author Raphael GONCALVES <contact@raphael-goncalves.fr>
 */

$git_log_cmd = \Weysan\Phpclg\Git\GitCommand::createCommand(
    new \Weysan\Phpclg\Git\Log()
);

\Weysan\Phpclg\Git\GitCommand::exec($git_log_cmd);