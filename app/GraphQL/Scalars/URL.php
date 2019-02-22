<?php

namespace App\GraphQL\Scalars;

use GraphQL\Error\Error;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;

/**
 * Read more about scalars here http://webonyx.github.io/graphql-php/type-system/scalar-types/
 */
class URL extends ScalarType
{
    /**
     * Serializes an internal value to include in a response.
     *
     * @param  mixed $value
     * @return mixed
     */
    public function serialize($value)
    {
        // Assuming the internal representation of the value is always correct
        return $value;
    }

    /**
     * Parses an externally provided value (query variable) to use as an input
     *
     * @param  mixed $value
     * @return mixed
     */
    public function parseValue($value)
    {
        return $value;
    }

    /**
     * Parses an externally provided literal value (hardcoded in GraphQL query) to use as an input.
     *
     * E.g.
     * {
     *   user(email: "user@example.com")
     * }
     *
     * @param  \GraphQL\Language\AST\Node $valueNode
     * @param  mixed[]|null $variables
     * @return mixed
     * @throws Error
     */
    public function parseLiteral($valueNode, ?array $variables = null)
    {
        if (!$valueNode instanceof StringValueNode) {
            throw new Error(
                "Query error: Can only parse strings, got {$valueNode->kind}",
                [$valueNode]
            );
        }


        return $this->tryParsingUrl($valueNode->value, Error::class);
    }

    /**
     * @param $value
     * @param string $exceptionClass
     * @return string
     */
    public function tryParsingUrl($value, string $exceptionClass): string
    {

        if (filter_var($value, FILTER_VALIDATE_URL)) {
            throw new $exceptionClass(
                'The value is not URL'
            );
        }
    }
}
