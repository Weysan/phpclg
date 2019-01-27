<?php
namespace Weysan\Phpclg\Git\Operation;

use Weysan\Phpclg\Git\GitOperationInterface;

/**
 * Implement the git command to show tags according to a commit id
 * git show-ref --tags
 * @package Weysan\Phpclg\Git\Operation
 */
class ShowRefTags implements GitOperationInterface
{
    const COMMAND_OPERATION_NAME = "show-ref";

    /**
     * Get alle the request parameters
     * @return array
     */
    public function getCommandParameters()
    {
        return array("tags");
    }

    /**
     * get the value of the command
     * @return bool
     */
    public function getCommandValue()
    {
        return false;
    }

    /**
     * Get the git operation to construct the git CLI
     * @return string
     */
    public function getCommandOperation()
    {
        return self::COMMAND_OPERATION_NAME;
    }
}
