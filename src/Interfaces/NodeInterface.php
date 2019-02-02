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

namespace eArc\Tree\Interfaces;

use eArc\Tree\Exceptions\DoesNotBelongToParentException;
use eArc\Tree\Exceptions\NodeOverwriteException;
use eArc\Tree\Exceptions\NotFoundException;
use eArc\Tree\Exceptions\NotPartOfTreeException;

/**
 * Interface for composites defining a tree structure.
 */
interface NodeInterface
{
    /**
     * Add an instance to the composite as child of this node.
     *
     * @param NodeInterface $node
     *
     * @throws DoesNotBelongToParentException
     * @throws NodeOverwriteException
     * @throws NotPartOfTreeException
     */
    public function addChild(NodeInterface $node): void;

    /**
     * Get the name of the node.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the parent of the node or the node itself if it's a root node.
     *
     * @return static
     */
    public function getParent(): NodeInterface;

    /**
     * Get the children of the node.
     *
     * @return static[]
     */
    public function getChildren(): array;

    /**
     * Get a child by its name.
     *
     * @param string $name
     *
     * @return static
     *
     * @throws NotFoundException
     */
    public function getChild(string $name): NodeInterface;

    /**
     * Checks whether a child named alike exists
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasChild(string $name): bool;

    /**
     * Get the child at the end of the path.
     *
     * @param string[] $path
     *
     * @return static
     *
     * @throws NotFoundException
     */
    public function getPathChild(array $path): NodeInterface;

    /**
     * Get the root of the node.
     *
     * @return static
     */
    public function getRoot(): NodeInterface;
}
