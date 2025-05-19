<?php

declare(strict_types=1);

namespace iio\libmergepdf\Source;

use iio\libmergepdf\Exception;
use iio\libmergepdf\PagesInterface;

class FileSourceTest extends \PHPUnit\Framework\TestCase
{
    public function testExceptionOnInvalidName(): void
    {
        $this->expectException(Exception::class);
        new FileSource('this-file-does-not-exist');
    }

    public function testGetName(): void
    {
        $this->assertSame(
            __FILE__,
            (new FileSource(__FILE__))->getName()
        );
    }

    public function testgetContents(): void
    {
        $this->assertSame(
            file_get_contents(__FILE__),
            (new FileSource(__FILE__))->getContents()
        );
    }

    public function testGetPages(): void
    {
        $pages = $this->createMock(PagesInterface::class);
        $this->assertSame(
            $pages,
            (new FileSource(__FILE__, $pages))->getPages()
        );
    }
}
