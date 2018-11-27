<?php
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/tree
 * @link https://github.com/Koudela/earc-tree/
 * @copyright Copyright (c) 2018 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Tree\Exceptions;

/**
 * Gets thrown if a node is added to a parent where the same child node name
 * already exists.
 */
class NodeOverwriteException extends \RuntimeException
{
}
