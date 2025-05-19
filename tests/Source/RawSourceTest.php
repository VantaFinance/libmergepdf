<?php

declare(strict_types=1);

namespace iio\libmergepdf\Source;

use iio\libmergepdf\PagesInterface;

class RawSourceTest extends \PHPUnit\Framework\TestCase
{
    public function testGetName(): void
    {
        $this->assertSame(
            'raw-content',
            (new RawSource(''))->getName()
        );
    }

    public function testgetContents(): void
    {
        $this->assertSame(
            'foobar',
            (new RawSource('foobar'))->getContents()
        );
    }

    public function testGetPages(): void
    {
        $pages = $this->createMock(PagesInterface::class);
        $this->assertSame(
            $pages,
            (new RawSource('', $pages))->getPages()
        );
    }
}
