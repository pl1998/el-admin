<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Enum;

class MethodEnum
{
    /** @var string */
    const GET = 'get';
    /** @var string */
    const HEAD = 'head';
    /** @var string */
    const POST = 'post';
    /** @var string */
    const PATCH = 'patch';
    /** @var string */
    const PUT = 'put';
    /** @var string */
    const DELETE = 'delete';

    /**
     * @var int[]
     */
    public const  METHOD = [
        MethodEnum::HEAD => 0,
        MethodEnum::GET => 1,
        MethodEnum::POST => 2,
        MethodEnum::PUT => 3,
        MethodEnum::PATCH => 4,
        MethodEnum::DELETE => 5,
    ];
}
