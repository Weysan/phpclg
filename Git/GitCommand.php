<?php
namespace Weysan\Phpclg\Git;


class GitCommand
{
    const GIT_COMMAND_EXECUTABLE = "git";

    static public function createCommand(GitOperationInterface $gitOperation)
    {
        return self::GIT_COMMAND_EXECUTABLE . " " . $gitOperation->getOperation() . join(" --", $gitOperation->getParameters());
    }

    /**
     * Exec the command line operation
     * @param string $cmd
     * @return mixed
     */
    static public function exec($cmd)
    {
        exec($cmd, $output);
        return $output;
    }
}