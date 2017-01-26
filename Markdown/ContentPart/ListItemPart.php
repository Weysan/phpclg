<?php
namespace Weysan\Phpclg\Markdown\ContentPart;

use Weysan\Phpclg\Markdown\MarkdownContentPartInterface;

class ListItemPart implements MarkdownContentPartInterface
{
    protected $content;

    protected $description;

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function __toString()
    {
        $string = "-";

        if (!empty($this->content)) {
            $string .= " **" . $this->content . "** \n\n";
        }

        if (!empty($this->description)) {
            $string .= $this->description . "\n\n";
        }

        if ("-" === $string) {
            $string .= " n/a";
        }

        return $string;
    }
}