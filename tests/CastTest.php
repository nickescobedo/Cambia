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

        $this->assertSame(12345, $request->castedInput('toInt'));
        $this->assertSame(12345, $request->castedInput('toInteger'));

        $this->assertSame(12345.67, $request->castedInput('toReal'));
        $this->assertSame(12345.67, $request->castedInput('toFloat'));
        $this->assertSame(12345.67, $request->castedInput('toDouble'));

        $this->assertSame('112345.12', $request->castedInput('toString'));

        $this->assertSame(true, $request->castedInput('toBool'));
        $this->assertSame(false, $request->castedInput('toBool2'));
        $this->assertSame(true, $request->castedInput('toBoolean'));
        $this->assertSame(false, $request->castedInput('toBoolean2'));

        $this->assertInstanceOf(\stdClass::class, $request->castedInput('toObject'));

        $this->assertSame([1], $request->castedInput('toArray'));
        $this->assertSame(['key' => 'value'], $request->castedInput('toJson'));

        $this->assertInstanceOf(Collection::class, $request->castedInput('toCollection'));
        $this->assertSame([1, 2, 3], $request->castedInput('toCollection')->all());

        $this->assertInstanceOf(Carbon::class, $request->castedInput('toDate'));

        $this->assertInstanceOf(Carbon::class, $request->castedInput('toDateTime'));
        $this->assertSame('2021-01-01 12:12:12', $request->castedInput('toDateTime')->format('Y-m-d H:i:s'));
        $this->assertInstanceOf(Carbon::class, $request->castedInput('toCustomDateTime'));
        $this->assertSame('2021-01-01 12:00:12', $request->castedInput('toCustomDateTime')->format('Y-m-d H:i:s'));

        $this->assertInstanceOf(CarbonImmutable::class, $request->castedInput('toImmutableDate'));
        $this->assertSame('2022-01-01', $request->castedInput('toImmutableDate')->format('Y-m-d'));


        $this->assertInstanceOf(CarbonImmutable::class, $request->castedInput('toImmutableDateTime'));
        $this->assertSame('2022-01-01 12:12:12', $request->castedInput('toImmutableDateTime')->format('Y-m-d H:i:s'));

        $this->assertInstanceOf(CarbonImmutable::class, $request->castedInput('toImmutableCustomDateTime'));
        $this->assertSame('2022-01-01 12:00:12', $request->castedInput('toImmutableCustomDateTime')->format('Y-m-d H:i:s'));

        $this->assertSame(Carbon::parse('2023-01-01 12:12:12')->timestamp, $request->castedInput('toTimestamp'));

        $this->assertSame(Status::Pending, $request->castedInput('toEnum'));

        $this->assertSame(['key' => 'value'], $request->castedInput('classCastableJson'));
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