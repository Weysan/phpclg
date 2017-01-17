<?php
namespace Weysan\Phpclg\Git;


use Weysan\Phpclg\Git\Exception\GitCommandException;
use Weysan\Phpclg\Git\Exception\GitOutputMissingException;
use Weysan\Phpclg\Git\Parser\Message;

class GitOutputCommandParser
{
    protected $output;

    protected $commits;

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

        $this->parseCommitMessages();

        return $this;
    }

    protected function parseCommitMessages()
    {
        $output = explode("\n", $this->output);

        $commit = array();
        foreach($output as $line){
            if(strpos($line, 'commit')===0){
                if(!empty($commit)){
                    array_push($history, $commit);
                    $commit = array();
                }
                $commit['hash']   = substr($line, strlen('commit'));
            }
            else if(strpos($line, 'Author')===0){
                $commit['author'] = substr($line, strlen('Author:'));
            }
            else if(strpos($line, 'Date')===0){
                $commit['date']   = substr($line, strlen('Date:'));
            }
            else{
                $commit['message']  .= $line;
            }

            if (!empty($commit)) {
                $this->commits[] = new Message($commit);
            }
        }

        return $this;
    }
}