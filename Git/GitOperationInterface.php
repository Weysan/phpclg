<?php
namespace Weysan\Phpclg\Git;


interface GitOperationInterface
{
    public function getParameters();

    public function getOperation();
}