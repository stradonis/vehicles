<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BaseKernelTestCase extends KernelTestCase
{
    protected ?KernelBrowser $client = null;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
    }
}