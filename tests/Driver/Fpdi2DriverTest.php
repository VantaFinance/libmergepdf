<?php

declare(strict_types=1);

namespace iio\libmergepdf\Driver;

use iio\libmergepdf\Exception;
use iio\libmergepdf\Pages;
use iio\libmergepdf\Source\SourceInterface;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use setasign\Fpdi\Tcpdf\Fpdi;

class Fpdi2DriverTest extends \PHPUnit\Framework\TestCase
{
    use ProphecyTrait;

    public function testExceptionOnFailure(): void
    {
        // Tcpdf generates warnings due to argument ordering with php 8
        // suppressing errors is a dirty hack until tcpdf is patched
        $fpdi = @$this->prophesize(Fpdi::class);

        $fpdi->setSourceFile(Argument::any())->willThrow(new \Exception('message'));

        $source = $this->prophesize(SourceInterface::class);
        $source->getName()->willReturn('file');
        $source->getContents()->willReturn('');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("'message' in 'file'");

        (new Fpdi2Driver($fpdi->reveal()))->merge($source->reveal());
    }

    public function testMerge(): void
    {
        $fpdi = $this->prophesize(Fpdi::class);

        $fpdi->setSourceFile(Argument::any())->willReturn(2);

        $fpdi->setPrintHeader(false)->shouldBeCalled();
        $fpdi->setPrintFooter(false)->shouldBeCalled();

        $fpdi->importPage(1)->willReturn('page_1');
        $fpdi->getTemplateSize('page_1')->willReturn(['width' => 1, 'height' => 2]);
        $fpdi->AddPage('P', [1, 2])->shouldBeCalled();
        $fpdi->useTemplate('page_1')->shouldBeCalled();

        $fpdi->importPage(2)->willReturn('page_2');
        $fpdi->getTemplateSize('page_2')->willReturn(['width' => 2, 'height' => 1]);
        $fpdi->AddPage('L', [2, 1])->shouldBeCalled();
        $fpdi->useTemplate('page_2')->shouldBeCalled();

        $fpdi->Output('', 'S')->willReturn('created-pdf');

        $source = $this->prophesize(SourceInterface::class);
        $source->getName()->willReturn('');
        $source->getContents()->willReturn('');
        $source->getPages()->willReturn(new Pages('1, 2'));


        $this->assertSame(
            'created-pdf',
            (new Fpdi2Driver($fpdi->reveal()))->merge($source->reveal())
        );
    }
}
