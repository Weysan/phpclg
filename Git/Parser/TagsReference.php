<?php
namespace Weysan\Phpclg\Git\Parser;


class TagsReference
{
    protected $ref_tags = array();

    public function __construct(array $ref_tags)
    {
        $this->ref_tags = $ref_tags;
    }

    /**
     * Check if a commit reference to a tag.
     * @param Commit $commit
     * @return bool|mixed
     */
    public function isCommitReferencedTag(Commit $commit)
    {
        if ($commit->getHash()) {
            if (isset($this->ref_tags[$commit->getHash()])) {
                return $this->parseTagFromRef($this->ref_tags[$commit->getHash()]);
            }
        }
        return false;
    }

    /**
     * Parse the ref to get the tag
     * @param string $ref
     * @return bool|string
     */
    public function parseTagFromRef($ref)
    {
        if (is_string($ref)) {
            return str_replace("refs/tags/", "", $ref);
        }
        return false;
    }
}