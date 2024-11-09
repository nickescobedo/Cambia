<?php

namespace NickEscobedo\Cambia\Tests;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use NickEscobedo\Cambia\InvalidRequestCastException;
use NickEscobedo\Cambia\Tests\SupportFiles\AllInputCast;
use NickEscobedo\Cambia\Tests\SupportFiles\Cast;
use NickEscobedo\Cambia\Tests\SupportFiles\InvalidClassCast;
use NickEscobedo\Cambia\Tests\SupportFiles\Status;
use Orchestra\Testbench\TestCase;

class AllCastedInputTest extends TestCase
{
    public function testGetAllCastedInput(): void
    {
        // Create a request instance with 'name' as an integer
        $request = new Cast();
        $request->replace(['name' => 123]); // Simulate form data
        $request = AllInputCast::create('/', 'POST', [
            'toInt' => '12345',
            'toString' => 112345.12,
            'toBool' => '1',
            'toObject' => '{"key":"value"}',
        ]);

        $request->setContainer($this->app);

        $request->validateResolved();

        $this->assertSame(12345, $request->castedInput('toInt'));
        $this->assertSame('112345.12', $request->castedInput('toString'));
        $this->assertSame(true, $request->castedInput('toBool'));
        $this->assertInstanceOf(\stdClass::class, $request->castedInput('toObject'));

        $this->assertEquals([
            'toInt' => 12345,
            'toString' => '112345.12',
            'toBool' => true,
            'toObject' => (object)['key' => 'value'],
        ], $request->allCastedInput());
    }
}