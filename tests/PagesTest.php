<?php

declare(strict_types=1);

namespace iio\libmergepdf;

class PagesTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @param array<int> $expected
     *
     * @dataProvider pageNumbersProvider
     *
     * @throws Exception
     */
    public function testPageNumbers(string $expressionString, array $expected): void
    {
        $this->assertSame(
            $expected,
            (new Pages($expressionString))->getPageNumbers()
        );
    }


    /**
     * @return array<int, list<list<int>|string>>
     */
    public function pageNumbersProvider(): array
    {
        return [
            ['', []],
            ['1', [1]],
            ['1,2', [1,2]],
            ['5-7', [5,6,7]],
            ['7-5', [7,6,5]],
            ['1,2-5,4,7-5', [1,2,3,4,5,4,7,6,5]],
            [' 1, 2- 5,, 4 ,7 -5,,', [1,2,3,4,5,4,7,6,5]],
        ];
    }

    public function testInvalidString(): void
    {
        $this->expectException(Exception::class);
        new Pages('12,*');
    }
}
