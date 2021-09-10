<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use DevMakerLab\MyMine\Exceptions\ExistingFilterKeyException;
use DevMakerLab\MyMine\Exceptions\NonExistingFilterKeyException;

class AbstractServiceTest extends TestCase
{
    public function testCanAddFilter(): void
    {
        $abstractService = $this->getAbstractService();
        $abstractService->addFilter('foo', 'bar');

        $this->assertCount(1, $abstractService->getFilters());
        $this->assertSame(['foo' => 'bar'], $abstractService->getFilters());
    }

    public function testCannotAddExistingFilter(): void
    {
        $abstractService = $this->getAbstractService();
        $abstractService->addFilter('foo', 'bar');

        $this->expectException(ExistingFilterKeyException::class);

        $abstractService->addFilter('foo', 'baz');
    }

    public function testCanUpdateExistingFilter(): void
    {
        $abstractService = $this->getAbstractService();
        $abstractService->addFilter('foo', 'bar');

        $abstractService->updateFilter('foo', 'baz');
        $this->assertSame(['foo' => 'baz'], $abstractService->getFilters());
    }

    public function testCannotUpdateNonExistingFilter(): void
    {
        $abstractService = $this->getAbstractService();

        $this->expectException(NonExistingFilterKeyException::class);

        $abstractService->updateFilter('foo', 'baz');

        $this->assertSame([], $abstractService->getFilters());
    }

    public function testCanResetFilters(): void
    {
        $abstractService = $this->getAbstractService();
        $abstractService->addFilter('foo', 'bar');
        $this->assertCount(1, $abstractService->getFilters());

        $abstractService->resetFilters();
        $this->assertCount(0, $abstractService->getFilters());
    }

    public function testCanSpecifyLimit(): void
    {
        $abstractService = $this->getAbstractService();
        $this->assertArrayNotHasKey('limit', $abstractService->getFilters());

        $abstractService->setLimit(10);

        $this->assertArrayHasKey('limit', $abstractService->getFilters());
        $this->assertSame(10, $abstractService->getFilters()['limit']);
    }

    public function testCanSpecifyOffset(): void
    {
        $abstractService = $this->getAbstractService();
        $this->assertArrayNotHasKey('offset', $abstractService->getFilters());

        $abstractService->setOffset(10);

        $this->assertArrayHasKey('offset', $abstractService->getFilters());
        $this->assertSame(10, $abstractService->getFilters()['offset']);
    }
}
