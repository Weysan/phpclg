<?php
namespace Weysan\Phpclg\Git;


use Weysan\Phpclg\Git\Exception\GitOperationNotFoundException;
use Weysan\Phpclg\Git\Operation\Log;
use Weysan\Phpclg\Git\Operation\ShowRefTags;

class GitCommand
{
    const GIT_COMMAND_EXECUTABLE = "git";

    static public function createCommand(GitOperationInterface $gitOperation)
    {
        return self::GIT_COMMAND_EXECUTABLE . " " . $gitOperation->getCommandOperation() . " " . $gitOperation->getCommandValue() . " --" . join(" --", $gitOperation->getCommandParameters());
    }

    /**
     * Exec the command line operation
     * @param string $cmd
     * @return mixed
     */
    static public function exec($cmd)
    {
        $output = shell_exec($cmd . " 2>&1");
        return $output;
    }

    /**
     * Generate automatically a git operation according to parameters
     * @param string $operation
     * @param array $parameters
     * @return GitOperationInterface
     * @throws GitOperationNotFoundException
     */
    static function getOperation($operation, array $parameters)
    {
        switch ($operation) {
            case Log::COMMAND_OPERATION_NAME:
                $operation = new Log();
                break;
            case ShowRefTags::COMMAND_OPERATION_NAME:
                $operation = new ShowRefTags();
                break;
            default:
                throw new GitOperationNotFoundException("git $operation not implemented.");
                break;
        }

        foreach ($parameters as $method => $value) {
            $operation->$method($value);
        }

        return $operation;
    }
}