<?php

declare(strict_types=1);

namespace iio\libmergepdf\Driver;

use iio\libmergepdf\Exception;
use iio\libmergepdf\Source\SourceInterface;

final class DefaultDriver implements DriverInterface
{
    private DriverInterface $wrapped;

    public function __construct(?DriverInterface $wrapped = null)
    {
        $this->wrapped = $wrapped ?: new Fpdi2Driver();
    }

    /**
     * @throws Exception
     */
    public function merge(SourceInterface ...$sources): string
    {
        return $this->wrapped->merge(...$sources);
    }
}
