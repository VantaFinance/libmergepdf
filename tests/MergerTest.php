<?php

declare(strict_types=1);

namespace iio\libmergepdf;

use iio\libmergepdf\Driver\DriverInterface;
use iio\libmergepdf\Source\FileSource;
use iio\libmergepdf\Source\RawSource;
use Prophecy\PhpUnit\ProphecyTrait;

class MergerTest extends \PHPUnit\Framework\TestCase
{
    use ProphecyTrait;

    public function testAddRaw(): void
    {
        $pages = $this->createMock(PagesInterface::class);

        $driver = $this->prophesize(DriverInterface::class);
        $driver->merge(new RawSource('foo', $pages))->willReturn('')->shouldBeCalled();

        $merger = new Merger($driver->reveal());
        $merger->addRaw('foo', $pages);
        $merger->merge();
    }

    public function testAddFile(): void
    {
        $pages = $this->createMock(PagesInterface::class);

        $driver = $this->prophesize(DriverInterface::class);
        $driver->merge(new FileSource(__FILE__, $pages))->willReturn('')->shouldBeCalled();


        $merger = new Merger($driver->reveal());
        $merger->addFile(__FILE__, $pages);
        $merger->merge();
    }

    public function testAddIterator(): void
    {
        $pages = $this->createMock(PagesInterface::class);

        $driver = $this->prophesize(DriverInterface::class);
        $driver->merge(new FileSource(__FILE__, $pages))->willReturn('')->shouldBeCalled();


        $merger = new Merger($driver->reveal());
        $merger->addIterator([__FILE__], $pages);
        $merger->merge();
    }

    public function testReset(): void
    {
        $pages = $this->createMock(PagesInterface::class);

        $driver = $this->prophesize(DriverInterface::class);
        $driver->merge()->willReturn('')->shouldBeCalled();


        $merger = new Merger($driver->reveal());
        $merger->addRaw('foo', $pages);
        $merger->reset();
        $merger->merge();
    }
}
