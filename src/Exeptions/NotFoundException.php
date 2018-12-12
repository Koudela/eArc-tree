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

use Psr\Container\NotFoundExceptionInterface;

/**
 * No child was found for the identifier.
 */
class NotFoundException extends \RuntimeException implements NotFoundExceptionInterface
{
}
