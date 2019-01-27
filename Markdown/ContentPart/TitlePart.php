<?php
namespace Weysan\Phpclg\Markdown\ContentPart;

use Weysan\Phpclg\Markdown\MarkdownContentPartInterface;

class TitlePart implements MarkdownContentPartInterface
{
    protected $content;

    protected $title_level = 1;

    const MAIN_TITLE_LEVEL = 1;

    const SUB_TITLE_LEVEL = 2;

    const PARAGRAPH_TITLE_LEVEL = 3;

    /**
     * Set the title level
     * @param int $level
     * @return $this
     * @throws \Exception
     */
    public function setTitleLevel($level = 1)
    {
        if (!is_numeric($level) || ($level < self::MAIN_TITLE_LEVEL || $level > self::PARAGRAPH_TITLE_LEVEL)) {
            throw new \Exception("Title level must be a number between 1 and 3.");
        }

        $this->title_level = $level;
        return $this;
    }

    /**
     * get the current level of the title
     * @return int
     */
    public function getLevel()
    {
        return $this->title_level;
    }

    /**
     * @inheritdoc
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        if (isset($this->content)) {
            return str_repeat("#", $this->title_level) . " " . $this->content . "\n\n";
        }
    }
}
