<?php
namespace Weysan\Phpclg\Git;

interface GitOperationInterface
{
    public function getCommandParameters();

    public function getCommandOperation();

    public function getCommandValue();
}
