<?php
namespace Weysan\Phpclg\Tests\Markdown;

use PHPUnit\Framework\TestCase;
use Weysan\Phpclg\Markdown\MarkdownContentPartInterface;
use Weysan\Phpclg\Markdown\MarkdownFile;

class MarkdownFileTest extends TestCase
{

    const BASE_TEST_FILES_DIR = "/testfiles";


    public function setUp()
    {
        if (!is_dir(__DIR__ . self::BASE_TEST_FILES_DIR)) {
            mkdir(__DIR__ . self::BASE_TEST_FILES_DIR);
        }
    }

    /**
     * remove all files from the test directory
     */
    public function tearDown()
    {
        $files = scandir(__DIR__ . self::BASE_TEST_FILES_DIR);

        foreach ($files as $file) {
            if (!is_dir(__DIR__ . self::BASE_TEST_FILES_DIR . '/' . $file)) {
                unlink(__DIR__ . self::BASE_TEST_FILES_DIR . '/' . $file);
            }
        }

        rmdir(__DIR__ . self::BASE_TEST_FILES_DIR);
    }

    /**
     * Test Creation and delete the file
     */
    public function testFileCreationAndDeletion()
    {
        $file = MarkdownFile::getManager(__DIR__ . self::BASE_TEST_FILES_DIR . '/' . 'test.md');

        $this->assertTrue(file_exists(__DIR__ . self::BASE_TEST_FILES_DIR . '/' . 'test.md'));

        $file->remove();

        $this->assertFalse(file_exists(__DIR__ . self::BASE_TEST_FILES_DIR . '/' . 'test.md'));
    }

    /**
     * Test with a simple command
     */
    public function testFileSaveWithContent()
    {
        $mockContent = $this->getMockBuilder(MarkdownContentPartInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockContent->method('__toString')
            ->willReturn("test content.");

        $file = MarkdownFile::getManager(__DIR__ . self::BASE_TEST_FILES_DIR . '/test-content.md');
        $file->addContent($mockContent);
        $file->save();

        $content_file = file_get_contents(__DIR__ . self::BASE_TEST_FILES_DIR . '/test-content.md');

        $this->assertEquals("test content.", $content_file);
    }

    public function testFileWithSeveralContent()
    {
        $mockContent = $this->getMockBuilder(MarkdownContentPartInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockContent->method('__toString')
            ->willReturn("test content.");

        $mockContent1 = $this->getMockBuilder(MarkdownContentPartInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockContent1->method('__toString')
            ->willReturn("\n\n" . "Another paragraph" . "\n\n");

        $file = MarkdownFile::getManager(__DIR__ . self::BASE_TEST_FILES_DIR . '/test-content-2.md');
        $file->addContent($mockContent);
        $file->addContent($mockContent1);
        $file->save();

        $content_file = file_get_contents(__DIR__ . self::BASE_TEST_FILES_DIR . '/test-content-2.md');

        $this->assertEquals("test content." . "\n\n" . "Another paragraph" . "\n\n", $content_file);
    }
}