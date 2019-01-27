<?php
namespace Weysan\Phpclg\Markdown;

interface MarkdownContentPartInterface
{
    /**
     * Add the content to be converted in markdown format
     * @param string $content
     * @return $this
     */
    public function setContent($content);

    /**
     * use that method to transform content into a markdown content
     * @return string
     */
    public function __toString();
}
