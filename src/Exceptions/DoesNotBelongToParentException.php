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

namespace eArc\Tree\Exceptions;

/**
 * A node is added to a parent it does not belong to.
 */
class DoesNotBelongToParentException extends NodeException
{
}
