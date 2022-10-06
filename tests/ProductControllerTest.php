<?php

namespace App\Tests;

use App\Controller\ProductController;
use PHPUnit\Framework\TestCase;

/**
 * Class ProductControllerTest.
 *
 * @covers \App\Controller\ProductController
 */
final class ProductControllerTest extends TestCase
{
    private ProductController $productController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->productController = new ProductController();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->productController);
    }

    public function testIndex(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testCreate(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testShow(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
