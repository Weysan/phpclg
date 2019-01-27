<?php
namespace Weysan\Phpclg\Changelog;

use Weysan\Phpclg\Git\Parser\Commit;
use Weysan\Phpclg\Git\Parser\TagsReference;
use Weysan\Phpclg\Markdown\ContentPart\ListItemPart;
use Weysan\Phpclg\Markdown\ContentPart\TitlePart;
use Weysan\Phpclg\Markdown\MarkdownFile;

/**
 * Generate the Changelog file
 * @package Weysan\Phpclg\Changelog
 */
class GeneratorManager
{
    protected $markdown;

    public function __construct($changelogFileName)
    {
        $this->markdown = MarkdownFile::getManager($changelogFileName);

        $title = new TitlePart();
        $title->setContent("Changelog");

        $this->markdown->addContent($title);
    }

    /**
     * @param Commit[] $commits
     * @param TagsReference $tagsReference
     * @return true
     */
    public function createFileFromCommitListAndTagsRef(array $commits, TagsReference $tagsReference)
    {
        foreach ($commits as $index => $commit) {
            $this->addCommitTitleToFile($commit, $tagsReference)
                ->addCommitDescriptionToFile($commit);
        }
        $this->markdown->save();
        return true;
    }

    /**
     * @param Commit $commit
     * @param TagsReference $tagsReference
     * @return $this
     */
    protected function addCommitTitleToFile(Commit $commit, TagsReference $tagsReference)
    {
        if ($tagsReference->isCommitReferencedTag($commit)) {
            $tag = new TitlePart();
            $tag->setTitleLevel(TitlePart::SUB_TITLE_LEVEL);
            $tag->setContent($tagsReference->isCommitReferencedTag($commit));

            $this->markdown->addContent($tag);
        }
        return $this;
    }

    /**
     * @param Commit $commit
     * @return $this
     */
    protected function addCommitDescriptionToFile(Commit $commit)
    {
        if ($commit->getMergeTitle() && $commit->isMerge()) {
            $listPart = new ListItemPart();
            $listPart->setContent($commit->getMergeTitle());
            $listPart->setDescription($commit->getMergeDescription());
            $this->markdown->addContent($listPart);
        }
        return $this;
    }
}
