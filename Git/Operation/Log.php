<?php
namespace Weysan\Phpclg\Git\Operation;

use Weysan\Phpclg\Git\GitOperationInterface;

class Log implements GitOperationInterface
{
    protected $tagFrom;

    protected $tagTo;

    protected $parameters = array();

    const COMMAND_OPERATION_NAME = "log";

    /**
     * Get the git operation to construct the git CLI
     * @return string
     */
    public function getCommandOperation()
    {
        return self::COMMAND_OPERATION_NAME;
    }

    /**
     * Get alle the request parameters
     * @return array
     */
    public function getCommandParameters()
    {
        return $this->parameters;
    }

    public function getCommandValue()
    {
        return "";
    }

    /**
     * @param string $tagFrom
     * @return $this
     */
    public function setFromTag($tagFrom)
    {
        $this->tagFrom = $tagFrom;
        return $this;
    }

    /**
     * @param $tagTo
     * @return $this
     */
    public function setToTag($tagTo)
    {
        $this->tagTo = $tagTo;
        return $this;
    }

    /**
     * @param bool $onlyMerges
     * @return $this
     */
    public function setMergesOnly($onlyMerges = false)
    {
        if ($onlyMerges === true) {
            $this->parameters[] = "merges";
        } else {
            $key = array_search("merges", $this->parameters);
            unset($this->parameters[$key]);
        }
        return $this;
    }

    /**
     * @param bool $tags
     * @return $this
     */
    public function setTags($tags = true)
    {
        if ($tags === true) {
            $this->parameters[] = "tags";
        } else {
            $key = array_search("tags", $this->parameters);
            unset($this->parameters[$key]);
        }
        return $this;
    }
}
