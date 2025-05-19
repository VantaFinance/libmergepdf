<?php

declare(strict_types=1);

namespace iio\libmergepdf\Source;

use iio\libmergepdf\Exception;
use iio\libmergepdf\Pages;
use iio\libmergepdf\PagesInterface;

/**
 * Pdf source from file
 */
final class FileSource implements SourceInterface
{
    private string $filename;

    private PagesInterface $pages;

    /**
     * @throws Exception
     */
    public function __construct(string $filename, ?PagesInterface $pages = null)
    {
        if (!is_file($filename) || !is_readable($filename)) {
            throw new Exception("Invalid file '$filename'");
        }

        $this->filename = $filename;
        $this->pages    = $pages ?: new Pages();
    }

    public function getName(): string
    {
        return $this->filename;
    }

    public function getContents(): string
    {
        return (string)file_get_contents($this->filename);
    }

    public function getPages(): PagesInterface
    {
        return $this->pages;
    }
}
