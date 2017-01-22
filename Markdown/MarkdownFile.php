<?php
namespace Weysan\Phpclg\Markdown;


class MarkdownFile
{

    /**
     * @var MarkdownFile[]
     */
    static protected $fileInstances = array();

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
    {}

    protected function __wakeup()
    {}

    /**
     * save the current file
     * @return $this
     */
    public function save()
    {
        foreach ($this->file_part_contents as $part_content) {
            fputs($this->resource, (string)$part_content);
        }

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
     * Get the instance
     * @param $filename
     * @return MarkdownFile
     */
    static public function getManager($filename)
    {
        if (!isset(self::$fileInstances[$filename])) {
            self::$fileInstances[$filename] = new MarkdownFile($filename);
        }

        return self::$fileInstances[$filename];
    }
}