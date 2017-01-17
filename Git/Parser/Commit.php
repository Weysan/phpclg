<?php
namespace Weysan\Phpclg\Git\Parser;


class Commit
{
    protected $hash;

    protected $author;

    protected $author_email;

    protected $message;

    protected $date;

    const GIT_COMMIT_MESSAGE_DATE_FORMAT = "D M j H:m:s Y O";

    public function __construct(array $commit)
    {
        if (isset($commit['hash'])) {
            $this->hash = $commit['hash'];
        }

        if (isset($commit['message'])) {
            $this->message = $commit['message'];
        }

        if (isset($commit['author'])) {
            preg_match("/([^<]+) <([^>]+)>/i", $commit['author'], $matches);
            $this->author = $matches[1];
            $this->author_email = $matches[2];
        }

        if (isset($commit['date'])) {
            $this->date = \Datetime::createFromFormat(self::GIT_COMMIT_MESSAGE_DATE_FORMAT, $commit['date']);
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
     * Get the author email
     * @return string
     */
    public function getAuthorEmail()
    {
        return $this->author_email;
    }

    public function __toString()
    {
        $message = "commit " . $this->getHash() . "\n";
        $message .= "Date: " . $this->date->format(self::GIT_COMMIT_MESSAGE_DATE_FORMAT) . "\n";
        $message .= "Author: " . $this->getAuthor() . "<" . $this->getAuthorEmail() . ">" . "\n";
        $message .= $this->getMessage() . "\n";

        return $message;
    }
}