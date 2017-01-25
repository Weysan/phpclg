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
        if (!empty($this->content) && !empty($this->description)) {
            return "- **" . $this->content . "** \n\n" . $this->description . "\n\n";
        }
        return "";
    }
}