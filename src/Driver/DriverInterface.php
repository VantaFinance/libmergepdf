<?php

declare(strict_types=1);

namespace iio\libmergepdf\Driver;

use iio\libmergepdf\Source\SourceInterface;

interface DriverInterface
{
    /**
     * Merge multiple sources
     */
    public function merge(SourceInterface ...$sources): string;
}
