<?php

namespace NickEscobedo\Cambia\Tests;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use NickEscobedo\Cambia\InvalidRequestCastException;
use NickEscobedo\Cambia\Tests\SupportFiles\Cast;
use NickEscobedo\Cambia\Tests\SupportFiles\InvalidClassCast;
use NickEscobedo\Cambia\Tests\SupportFiles\Status;
use Orchestra\Testbench\TestCase;

class CastTest extends TestCase
{
    public function testRequestCastsNameToIntToString(): void
    {
        // Create a request instance with 'name' as an integer
        $request = new Cast();
        $request->replace(['name' => 123]); // Simulate form data
        $request = Cast::create('/', 'POST', [
            'toInt' => '12345',
            'toInteger' => '12345',

            'toReal' => '12345.67',
            'toFloat' => '12345.67',
            'toDouble' => '12345.67',
            'toDecimal' => '12345.67',

            'toString' => 112345.12,

            'toBool' => '1',
            'toBool2' => '0',
            'toBoolean' => '1',
            'toBoolean2' => '0',

            'toObject' => '{"key":"value"}',

            'toArray' => '[1]',
            'toJson' => '{"key":"value"}',

            'toCollection' => '[1,2,3]',

            'toDate' => '2021-01-01',

            'toDateTime' => '2021-01-01 12:12:12',
            'toCustomDateTime' => '2021-01-01 12:12',

            'toImmutableDate' => '2022-01-01',

            'toImmutableDateTime' => '2022-01-01 12:12:12',
            'toImmutableCustomDateTime' => '2022-01-01 12:12',

            'toTimestamp' => '2023-01-01 12:12:12',

            'toEnum' => 'pending',

            'classCastableJson' => '{"key":"value"}',
        ]);

        $request->setContainer($this->app);

        $request->validateResolved();

        $this->assertSame(12345, $request->attributes->get('toInt'));
        $this->assertSame(12345, $request->attributes->get('toInteger'));

        $this->assertSame(12345.67, $request->attributes->get('toReal'));
        $this->assertSame(12345.67, $request->attributes->get('toFloat'));
        $this->assertSame(12345.67, $request->attributes->get('toDouble'));

        $this->assertSame('112345.12', $request->attributes->get('toString'));

        $this->assertSame(true, $request->attributes->get('toBool'));
        $this->assertSame(false, $request->attributes->get('toBool2'));
        $this->assertSame(true, $request->attributes->get('toBoolean'));
        $this->assertSame(false, $request->attributes->get('toBoolean2'));

        $this->assertInstanceOf(\stdClass::class, $request->attributes->get('toObject'));

        $this->assertSame([1], $request->attributes->get('toArray'));
        $this->assertSame(['key' => 'value'], $request->attributes->get('toJson'));

        $this->assertInstanceOf(Collection::class, $request->attributes->get('toCollection'));
        $this->assertSame([1, 2, 3], $request->attributes->get('toCollection')->all());

        $this->assertInstanceOf(Carbon::class, $request->attributes->get('toDate'));

        $this->assertInstanceOf(Carbon::class, $request->attributes->get('toDateTime'));
        $this->assertSame('2021-01-01 12:12:12', $request->attributes->get('toDateTime')->format('Y-m-d H:i:s'));
        $this->assertInstanceOf(Carbon::class, $request->attributes->get('toCustomDateTime'));
        $this->assertSame('2021-01-01 12:00:12', $request->attributes->get('toCustomDateTime')->format('Y-m-d H:i:s'));

        $this->assertInstanceOf(CarbonImmutable::class, $request->attributes->get('toImmutableDate'));
        $this->assertSame('2022-01-01', $request->attributes->get('toImmutableDate')->format('Y-m-d'));


        $this->assertInstanceOf(CarbonImmutable::class, $request->attributes->get('toImmutableDateTime'));
        $this->assertSame('2022-01-01 12:12:12', $request->attributes->get('toImmutableDateTime')->format('Y-m-d H:i:s'));

        $this->assertInstanceOf(CarbonImmutable::class, $request->attributes->get('toImmutableCustomDateTime'));
        $this->assertSame('2022-01-01 12:00:12', $request->attributes->get('toImmutableCustomDateTime')->format('Y-m-d H:i:s'));

        $this->assertSame(Carbon::parse('2023-01-01 12:12:12')->timestamp, $request->attributes->get('toTimestamp'));

        $this->assertSame(Status::Pending, $request->attributes->get('toEnum'));

        $this->assertSame(['key' => 'value'], $request->attributes->get('classCastableJson'));
    }

    public function testExceptionThrowForInvalidCastClass(): void
    {
        $this->expectException(InvalidRequestCastException::class);

        $request = InvalidClassCast::create('/', 'POST', [
            'invalidClassCastableJson' => '{"key":"value"}',
        ]);

        $request->setContainer($this->app);

        $request->validateResolved();
    }
}