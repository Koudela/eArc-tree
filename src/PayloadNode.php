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

use eArc\Payload\Interfaces\PayloadCarrierInterface;
use eArc\Tree\Exceptions\DoesNotBelongToParentException;
use eArc\Tree\Exceptions\NodeOverwriteException;
use eArc\Tree\Exceptions\NotPartOfTreeException;
use eArc\Tree\Interfaces\NodeInterface;

/**
* Defines a tree structured composite that has a payload.
*/
class PayloadNode extends Node implements PayloadCarrierInterface
{
    /** @var mixed */
    protected $payload;

    /** @var callable */
    protected $initializer;

    /**
     * @param NodeInterface|null $parent
     * @param string|null        $name
     * @param null               $payload
     * @param callable|null      $initializer
     *
     * @throws DoesNotBelongToParentException
     * @throws NodeOverwriteException
     * @throws NotPartOfTreeException
     */
    public function __construct(?NodeInterface $parent = null, ?string $name = null, $payload = null, ?callable $initializer = null)
    {
        parent::__construct($parent, $name);

        $this->payload = $payload;
        $this->initializer = $initializer;

        if (!$this->has()) {
            $this->init();
        }
    }

    /**
     * @inheritdoc
     */
    public function has()
    {
        return null !== $this->payload;
    }


    /**
     * @inheritdoc
     */
    public function get()
    {
        return $this->payload;
    }

    /**
     * @inheritdoc
     */
    public function set($payload)
    {
        $oldPayload = $this->payload;

        $this->payload = $payload;

        return $oldPayload;
    }

    /**
     * @inheritdoc
     */
    public function reset()
    {
        $oldPayload = $this->payload;

        $this->init();

        return $oldPayload;
    }

    /**
     * Initialises the payload.
     */
    protected function init()
    {
        if (null === $this->initializer) {
            $this->payload = null;
            return;
        }

        $this->payload = ($this->initializer)();
    }
}
