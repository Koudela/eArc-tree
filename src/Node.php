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

use eArc\Tree\Exceptions\NodeOverwriteException;

/**
 * Node defines the tree structure of the composite
 */
class Node
{
    /** @var Node */
    protected $root;

    /** @var Node */
    protected $parent;

    /** @var array */
    protected $children = [];

    /** @var string */
    protected $name;

    /**
     * @param Node|null $parent
     * @param null|string $name
     */
    public function __construct(?Node $parent = null, ?string $name = null)
    {
        $this->name = $name ?? spl_object_hash($this);

        if (!$parent) {
            $this->root = $this;
            $this->parent = $this;
        } else {
            $this->root = $parent->getRoot();
            $this->parent = $parent;
            $parent->addChild($this);
        }
    }

    /**
     * Add an instance to the composite as child of this node.
     *
     * @param Node $node
     */
    public function addChild(Node $node): void
    {
        if ($node->getRoot() !== $this->getRoot()) {
            throw new \RuntimeException("The instance does not belong to this tree.");
        }

        if ($this !== $node->parent) {
            throw new \RuntimeException("The instance does not belong to this parent.");
        }

        if (isset($this->children[$node->getName()])) {
            throw new NodeOverwriteException("A child with the name '{$node->getName()}' already exists.'");
        }

        $this->children[$node->getName()] = $node;
    }

    /**
     * Get the name of the node.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the parent of the node or the node itself if it's a root node.
     *
     * @return Node
     */
    public function getParent(): Node
    {
        return $this->parent;
    }

    /**
     * Get the children of the node.
     *
     * @return array
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * Get a child by its name.
     *
     * @param string $name
     *
     * @return Node
     */
    public function getChild(string $name): Node
    {
        return $this->children[$name];
    }

    /**
     * Checks whether a child named alike exists
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasChild(string $name): bool
    {
        return isset($this->children[$name]);
    }

    /**
     * Get the child at the end of the path or null if it does not exists
     *
     * @param array $path
     *
     * @return Node|null
     */
    public function getPathChild(array $path): ?Node
    {
        $child = $this;

        foreach ($path as $name) {
            if (!$child->hasChild($name))
            {
                return null;
            }
            $child = $child->getChild($name);
        }

        return $child;
    }

    /**
     * Get the root of the node.
     *
     * @return Node
     */
    public function getRoot(): Node
    {
        return $this->root;
    }

    /**
     * Transforms the composite into a string representation.
     *
     * @return string
     */
    public function toString(): string
    {
        return $this->root->nodeToString();
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
        $str = $indent . "--{$this->name}--\n";

        foreach ($this->children as $child)
        {
            $str .= $child->nodeToString($indent . '  ');
        }

        return $str;
    }
}
