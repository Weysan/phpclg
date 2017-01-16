<?php
namespace Weysan\Phpclg\Git;


use Weysan\Phpclg\Git\Exception\GitCommandException;
use Weysan\Phpclg\Git\Exception\GitOutputMissingException;

class GitOutputCommandParser
{
    protected $output;

    public function __construct($output)
    {
        $this->output = $output;
    }

    /**
     * Parse the git return
     * @return $this
     * @throws GitCommandException
     * @throws GitOutputMissingException
     */
    public function parse()
    {
        //no output
        if (!isset($this->output) || empty($this->output)) {
            throw new GitOutputMissingException("Git output is missing or empty.");
        }
        //fatal errors from git
        if (preg_match('/^fatal:/i', $this->output)) {
            $lines = explode("\n", $this->output);
            throw new GitCommandException($lines[0]);
        }
        var_dump($this->output);
        return $this;
    }
}