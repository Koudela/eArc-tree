<?php
/**
 * e-Arc Framework - the explicit Architecture Framework
 * tree composite component
 *
 * @package earc/tree
 * @link https://github.com/Koudela/eArc-tree/
 * @copyright Copyright (c) 2018-2019 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Tree;

use eArc\Tree\Exceptions\DoesNotBelongToParentException;
use eArc\Tree\Exceptions\NodeOverwriteException;
use eArc\Tree\Exceptions\NotPartOfTreeException;
use eArc\Tree\Interfaces\NodeInterface;
use eArc\Tree\Traits\NodeTrait;

/**
 * Node implements the node interface to define a tree structured composite.
 */
class Node implements NodeInterface
{
    use NodeTrait;

    /**
     * @param NodeInterface|null $node
     * @param string|null        $name
     *
     * @throws DoesNotBelongToParentException
     * @throws NodeOverwriteException
     * @throws NotPartOfTreeException
     */
    public function __construct(?NodeInterface $node = null, ?string $name = null)
    {
        $this->initNodeTrait($node, $name);
    }

    /**
     * Transforms the composite into a string representation.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getRoot()->nodeToString();
    }

    /**
     * Transforms the instance and its children into a string representation.
     *
     * @param string $indent
     *
     * @return string
     */
    protected function nodeToString($indent = ''): string
    {
        $str = $indent . "--{$this->getName()}--\n";

        foreach ($this->getChildren() as $child)
        {
            $str .= $child->nodeToString($indent . '  ');
        }

        return $str;
    }
}
