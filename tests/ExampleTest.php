<?php

declare(strict_types=1);

use Latent\ElAdmin\Support\Helpers;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * 基础测试样例.
     *
     * @return void
     */
    public function test_basic_test()
    {
        $config = Helpers::ElConfig('controller');
        dump($config);
    }
}
