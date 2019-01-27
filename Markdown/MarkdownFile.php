<?php
namespace Weysan\Phpclg\Markdown;

class MarkdownFile
{

    /**
     * @var MarkdownFile[]
     */
    protected static $fileInstances = array();

    protected $resource;

    protected $file_part_contents = array();

    protected $filename;

    /**
     * MarkdownFile constructor.
     * @param string $filename
     */
    protected function __construct($filename)
    {
        $this->resource = fopen($filename, 'a+');

        $this->filename = $filename;
    }

    protected function __clone()
    {
    }

    protected function __wakeup()
    {
    }

    /**
     * save the current file
     * @return $this
     */
    public function save()
    {
        $this->cleanFileContent();

        foreach ($this->file_part_contents as $part_content) {
            fputs($this->resource, (string)$part_content);
        }

        return $this;
    }

    /**
     * Erase all content
     * @return $this
     */
    public function cleanFileContent()
    {
        ftruncate($this->resource, 0);
        return $this;
    }

    /**
     * delete the current markdown file
     * @return $this
     */
    public function remove()
    {
        unlink($this->filename);
        return $this;
    }

    /**
     * close the file
     */
    public function __destruct()
    {
        fclose($this->resource);
    }

    /**
     * Add a markdown content
     * @param MarkdownContentPartInterface $markdownContentPart
     * @return $this
     */
    public function addContent(MarkdownContentPartInterface $markdownContentPart)
    {
        $this->file_part_contents[] = $markdownContentPart;
        return $this;
    }

    /**
     * Get the instance
     * @param $filename
     * @return MarkdownFile
     */
    public static function getManager($filename)
    {
        if (!isset(self::$fileInstances[$filename])) {
            self::$fileInstances[$filename] = new MarkdownFile($filename);
        }

        return self::$fileInstances[$filename];
    }
}
