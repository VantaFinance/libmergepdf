<?php

declare(strict_types=1);

namespace iio\libmergepdf\Driver;

use iio\libmergepdf\Source\SourceInterface;
use Prophecy\PhpUnit\ProphecyTrait;

class DefaultDriverTest extends \PHPUnit\Framework\TestCase
{
    use ProphecyTrait;

    public function testMerge(): void
    {
        $wrapped = $this->prophesize(DriverInterface::class);

        $source1 = $this->createMock(SourceInterface::class);
        $source2 = $this->createMock(SourceInterface::class);

        $wrapped->merge($source1, $source2)->willReturn('foo')->shouldBeCalled();

        $driver = new DefaultDriver($wrapped->reveal());

        $this->assertEquals(
            'foo',
            $driver->merge($source1, $source2)
        );
    }
}
