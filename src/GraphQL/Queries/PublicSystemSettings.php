<?php

namespace App\GraphQL\Queries\Core;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

use MayIFit\Core\Permission\Models\SystemSetting;

class PublicSystemSettings
{
    /**
     * Return all publicly available settings
     * 
     * @return SystemSetting
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {
        return SystemSetting::where('public', true)->get();
    }
}