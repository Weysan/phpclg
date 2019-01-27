<?php
namespace Weysan\Phpclg\Git\Parser;

class Commit
{
    protected $hash;

    protected $author;

    protected $author_email;

    protected $message;

    protected $date;

    protected $merge;

    const GIT_COMMIT_MESSAGE_DATE_FORMAT = "D M j H:m:s Y O";

    public function __construct(array $commit)
    {
        if (isset($commit['hash'])) {
            $this->hash = $commit['hash'];
        }

        if (isset($commit['message'])) {
            $this->message = array_values(
                array_filter($commit['message'], function ($value) {
                    return (!empty($value));
                })
            );
        }

        if (isset($commit['author'])) {
            preg_match("/([^<]+) <([^>]+)>/i", $commit['author'], $matches);
            $this->author = $matches[1];
            $this->author_email = $matches[2];
        }

        if (isset($commit['date'])) {
            $this->date = \Datetime::createFromFormat(self::GIT_COMMIT_MESSAGE_DATE_FORMAT, $commit['date']);
        }

        if (isset($commit['merge'])) {
            $this->merge = $commit['merge'];
        }
    }

    /**
     * get the author name
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * get the commit message
     * @return string
     */
    public function getMessage()
    {
        return join("\n", $this->message);
    }

    /**
     * get the commit hash
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Get the merge request title
     * @return string|false
     */
    public function getMergeTitle()
    {
        if (isset($this->message[1])) {
            return $this->message[1];
        }

        return false;
    }

    /**
     * Get the merge message description
     * @return string
     */
    public function getMergeDescription()
    {
        if (count($this->message) <= 2) {
            return false;
        }

        $merge_message = join(
            "\n",
            array_slice(
                $this->message,
                2,
                (count($this->message) - 2) - 1
            )
        );

        return $merge_message;
    }

    /**
     * Get the author email
     * @return string
     */
    public function getAuthorEmail()
    {
        return $this->author_email;
    }

    /**
     * Re construct the Commit log message
     * @return string
     */
    public function __toString()
    {
        $message = "commit " . $this->getHash() . "\n";
        $message .= "Date: " . $this->date->format(self::GIT_COMMIT_MESSAGE_DATE_FORMAT) . "\n";
        $message .= "Author: " . $this->getAuthor() . "<" . $this->getAuthorEmail() . ">" . "\n";
        $message .= $this->getMessage() . "\n";

        return $message;
    }

    /**
     * Check if the current commit is a merge or not.
     * @return bool
     */
    public function isMerge()
    {
        if (isset($this->merge) && !empty($this->merge)) {
            return true;
        }
        return false;
    }
}
