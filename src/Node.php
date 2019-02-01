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
use eArc\Tree\Exceptions\NotFoundException;
use eArc\Tree\Exceptions\NotPartOfTreeException;
use eArc\Tree\Interfaces\NodeInterface;

/**
 * Node defines the tree structure of the composite
 */
class Node implements NodeInterface
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
     * @param NodeInterface|null   $parent
     * @param string|null $name
     *
     * @throws DoesNotBelongToParentException
     * @throws NodeOverwriteException
     * @throws NotPartOfTreeException
     */
    public function __construct(?NodeInterface $parent = null, ?string $name = null)
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
     * @inheritdoc
     */
    public function addChild(NodeInterface $node): void
    {
        if ($node->getRoot() !== $this->getRoot()) {
            throw new NotPartOfTreeException("The instance does not belong to this tree.");
        }

        if ($this !== $node->getParent()) {
            throw new DoesNotBelongToParentException("The instance does not belong to this parent.");
        }

        if (isset($this->children[$node->getName()])) {
            throw new NodeOverwriteException("A child with the name '{$node->getName()}' already exists.'");
        }

        $this->children[$node->getName()] = $node;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     *
     * @return static
     */
    public function getParent(): NodeInterface
    {
        return $this->parent;
    }

    /**
     * @inheritdoc
     *
     * @return static[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @inheritdoc
     *
     * @return static
     */
    public function getChild(string $name): NodeInterface
    {
        if (!isset($this->children[$name])) {
            throw new NotFoundException($name);
        }

        return $this->children[$name];
    }

    /**
     * @inheritdoc
     */
    public function hasChild(string $name): bool
    {
        return isset($this->children[$name]);
    }

    /**
     * @inheritdoc
     *
     * @return static
     */
    public function getPathChild(array $path): NodeInterface
    {
        $child = $this;

        foreach ($path as $name) {
            $child = $child->getChild($name);
        }

        return $child;
    }

    /**
     * @inheritdoc
     *
     * @return static
     */
    public function getRoot(): NodeInterface
    {
        return $this->root;
    }

    /**
     * Transforms the composite into a string representation.
     *
     * @return string
     */
    public function __toString(): string
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
