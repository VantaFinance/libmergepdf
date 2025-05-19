<?php

declare(strict_types=1);

namespace iio\libmergepdf;

use iio\libmergepdf\Driver\DriverInterface;
use iio\libmergepdf\Source\FileSource;
use iio\libmergepdf\Source\RawSource;

use function PHPUnit\Framework\assertInstanceOf;

class MergerTest extends \PHPUnit\Framework\TestCase
{
    public function testAddRaw(): void
    {
        $pages = $this->createMock(PagesInterface::class);

        $driver = $this->prophesize(DriverInterface::class);
        $driver->merge(new RawSource('foo', $pages))->willReturn('')->shouldBeCalled();

        $newDriver = $driver->reveal();

        assertInstanceOf(DriverInterface::class, $newDriver);

        $merger = new Merger($newDriver);
        $merger->addRaw('foo', $pages);
        $merger->merge();
    }

    public function testAddFile(): void
    {
        $pages = $this->createMock(PagesInterface::class);

        $driver = $this->prophesize(DriverInterface::class);
        $driver->merge(new FileSource(__FILE__, $pages))->willReturn('')->shouldBeCalled();


        $newDriver = $driver->reveal();

        assertInstanceOf(DriverInterface::class, $newDriver);

        $merger = new Merger($newDriver);
        $merger->addFile(__FILE__, $pages);
        $merger->merge();
    }

    public function testAddIterator(): void
    {
        $pages = $this->createMock(PagesInterface::class);

        $driver = $this->prophesize(DriverInterface::class);
        $driver->merge(new FileSource(__FILE__, $pages))->willReturn('')->shouldBeCalled();


        $newDriver = $driver->reveal();

        assertInstanceOf(DriverInterface::class, $newDriver);

        $merger = new Merger($newDriver);
        $merger->addIterator([__FILE__], $pages);
        $merger->merge();
    }

    public function testReset(): void
    {
        $pages = $this->createMock(PagesInterface::class);

        $driver = $this->prophesize(DriverInterface::class);
        $driver->merge()->willReturn('')->shouldBeCalled();


        $newDriver = $driver->reveal();

        assertInstanceOf(DriverInterface::class, $newDriver);

        $merger = new Merger($newDriver);
        $merger->addRaw('foo', $pages);
        $merger->reset();
        $merger->merge();
    }
}
