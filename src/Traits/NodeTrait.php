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

namespace eArc\Tree\Traits;

use eArc\Tree\Exceptions\DoesNotBelongToParentException;
use eArc\Tree\Exceptions\NodeOverwriteException;
use eArc\Tree\Exceptions\NotFoundException;
use eArc\Tree\Exceptions\NotPartOfTreeException;
use eArc\Tree\Interfaces\NodeInterface;

/**
 * This trait implements the node interface. Use both or extend the Node class.
 */
trait NodeTrait
{
    /** @var NodeInterface */
    protected $nodeRoot;

    /** @var NodeInterface */
    protected $nodeParent;

    /** @var NodeInterface[] */
    protected $nodeChildren = [];

    /** @var string */
    protected $nodeName;

    /**
     * Call this function in the constructor.
     *
     * @param NodeInterface|null $parent
     * @param string|null        $name
     *
     * @throws DoesNotBelongToParentException
     * @throws NodeOverwriteException
     * @throws NotPartOfTreeException
     */
    protected function initNodeTrait(?NodeInterface $parent = null, ?string $name = null)
    {
        $this->nodeName = $name ?? spl_object_hash($this);

        if (!$parent) {
            $this->nodeRoot = $this;
            $this->nodeParent = $this;
        } else {
            $this->nodeRoot = $parent->getRoot();
            $this->nodeParent = $parent;
            /** @noinspection PhpParamsInspection */
            $parent->addChild($this);
        }
    }

    /**
     * @inheritdoc
     */
    public function addChild(NodeInterface $node): void
    {
        if ($node->getRoot() !== $this->getRoot()) {
            /** @noinspection PhpUnhandledExceptionInspection */
            throw new NotPartOfTreeException("The instance does not belong to this tree.");
        }

        if ($this !== $node->getParent()) {
            /** @noinspection PhpUnhandledExceptionInspection */
            throw new DoesNotBelongToParentException("The instance does not belong to this parent.");
        }

        if (isset($this->nodeChildren[$node->getName()])) {
            /** @noinspection PhpUnhandledExceptionInspection */
            throw new NodeOverwriteException("A child with the name '{$node->getName()}' already exists.'");
        }

        $this->nodeChildren[$node->getName()] = $node;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->nodeName;
    }

    /**
     * @inheritdoc
     *
     * @return static
     */
    public function getParent(): NodeInterface
    {
        return $this->nodeParent;
    }

    /**
     * @inheritdoc
     *
     * @return static[]
     */
    public function getChildren(): array
    {
        return $this->nodeChildren;
    }

    /**
     * @noinspection PhpDocMissingThrowsInspection
     *
     * @inheritdoc
     *
     * @return static
     */
    public function getChild(string $name): NodeInterface
    {
        if (!isset($this->nodeChildren[$name])) {
            /** @noinspection PhpUnhandledExceptionInspection */
            throw new NotFoundException($name);
        }

        return $this->nodeChildren[$name];
    }

    /**
     * @inheritdoc
     */
    public function hasChild(string $name): bool
    {
        return isset($this->nodeChildren[$name]);
    }

    /**
     * @noinspection PhpDocMissingThrowsInspection
     *
     * @inheritdoc
     *
     * @return static
     */
    public function getPathChild(array $path): NodeInterface
    {
        $child = $this;

        foreach ($path as $name) {
            /** @noinspection PhpUnhandledExceptionInspection */
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
        return $this->nodeRoot;
    }
}
