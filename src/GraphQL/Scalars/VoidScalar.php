<?php

namespace MayIFit\Core\Permission\GraphQL\Scalars;

use GraphQL\Type\Definition\ScalarType;

/**
 * Class VoidScalar
 *
 * @package MayIFit\Core\Permission
 */
class VoidScalar extends ScalarType
{
    public function serialize($value)
    {
        return null;
    }

    public function parseValue($value)
    {
        return null;
    }

    public function parseLiteral($valueNode, ?array $variables = null)
    {
        return null;
    }
}
