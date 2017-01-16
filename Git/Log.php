<?php
namespace Weysan\Phpclg\Git;


class Log implements GitOperationInterface
{
    protected $tagFrom;

    protected $tagTo;

    protected $parameters = array();

    /**
     * Get the git operation to construct the git CLI
     * @return string
     */
    public function getOperation()
    {
        return "log";
    }

    /**
     * Get alle the request parameters
     * @return array
     */
    public function getParameters()
    {
        return array();
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
}