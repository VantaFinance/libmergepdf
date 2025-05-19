<?php

declare(strict_types=1);

namespace iio\libmergepdf;

interface PagesInterface
{
    /**
     * @return int[]
     */
    public function getPageNumbers(): array;
}
