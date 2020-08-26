<?php

namespace MayIFit\Core\Permission\Exceptions;

use Exception;
use Nuwave\Lighthouse\Exceptions\RendersErrorsExtensions;

/**
 * Class MisMatchedAuthorizationRequest
 *
 * @package MayIFit\Core\Permission
 */
class MisMatchedAuthorizationRequest extends Exception implements RendersErrorsExtensions
{
    /**
    * @var @string
    */
    private $validation;

    public function __construct(string $message, string $validation)
    {
        parent::__construct($message);

        $this->validation = $validation;
    }

    /**
     * Returns true when exception message is safe to be displayed to a client.
     *
     * @api
     * @return bool
     */
    public function isClientSafe(): bool
    {
        return true;
    }

    /**
     * Returns string describing a category of the error.
     *
     * Value "graphql" is reserved for errors produced by query parsing or validation, do not use it.
     *
     * @api
     * @return string
     */
    public function getCategory(): string
    {
        return 'userAuthentication';
    }

    /**
     * Return the content that is put in the "extensions" part
     * of the returned error.
     *
     * @return array
     */
    public function extensionsContent(): array
    {
        return [
            'validation' => [
                $this->message => [$this->validation]
            ],
        ];
    }
}