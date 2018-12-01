<?php
/**
* e-Arc Framework - the explicit Architecture Framework
*
* @package earc/tree
* @link https://github.com/Koudela/eArc-tree/
* @copyright Copyright (c) 2018 Thomas Koudela
* @license http://opensource.org/licenses/MIT MIT License
*/

namespace eArc\Tree;

/**
* Defines a tree structured composite that has a content payload.
*/
class ContentNode extends Node
{
    /** @var mixed */
    protected $content;

    public function __construct(?Node $parent = null, ?string $name = null, $content = null)
    {
        parent::__construct($parent, $name);

        $this->content = $content;
    }

    /**
     * Set the content payload of the node.
     *
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * Get the content payload of the node.
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }
}