<?php

declare(strict_types=1);

namespace iio\libmergepdf\Driver;

use iio\libmergepdf\Source\SourceInterface;

use function PHPUnit\Framework\assertInstanceOf;

class DefaultDriverTest extends \PHPUnit\Framework\TestCase
{
    public function testMerge(): void
    {
        $wrapped = $this->prophesize(DriverInterface::class);

        $source1 = $this->createMock(SourceInterface::class);
        $source2 = $this->createMock(SourceInterface::class);

        $wrapped->merge($source1, $source2)->willReturn('foo')->shouldBeCalled();

        $newDriver = $wrapped->reveal();

        assertInstanceOf(DriverInterface::class, $newDriver);

        $driver = new DefaultDriver($newDriver);

        $this->assertEquals(
            'foo',
            $driver->merge($source1, $source2)
        );
    }
}
