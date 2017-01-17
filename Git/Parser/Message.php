<?php
namespace Weysan\Phpclg\Git\Parser;


class Message
{
    protected $hash;

    protected $author;

    protected $message;

    protected $date;

    public function __construct(array $data)
    {
        if (isset($commit['hash'])) {
            $this->hash = $commit['hash'];
        }

        if (isset($commit['message'])) {
            $this->message = $commit['message'];
        }

        if (isset($commit['author'])) {
            $this->author = $commit['author'];
        }

        if (isset($commit['date'])) {
            $this->date = date_create_from_format($commit['date'], "D M j H:m:s O");
        }
    }
}