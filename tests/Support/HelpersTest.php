<?php

namespace Tests\Support;

use App\Support\Helpers;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class HelpersTest extends TestCase
{
    public function test_it_can_get_an_environment_variable(): void
    {
        putenv('TEST_STRING=Test string; please ignore');

        $env = Helpers::env('TEST_STRING');

        $this->assertEquals('Test string; please ignore', $env);
    }

    public function test_it_can_return_a_default_value(): void
    {
        $env = Helpers::env('DEFAULT_TEST', 'Test default; please ignore');

        $this->assertEquals('Test default; please ignore', $env);
    }

    public function test_it_can_a_retrieve_boolean_value(): void
    {
        putenv('TRUE_TEST=true');
        putenv('FALSE_TEST=false');

        $this->assertTrue(Helpers::env('TRUE_TEST'));
        $this->assertFalse(Helpers::env('FALSE_TEST'));
    }

    public function test_it_can_retrieve_a_null_value(): void
    {
        putenv('NULL_TEST=null');

        $this->assertNull(Helpers::env('NULL_TEST'));
    }

    public function test_it_can_be_surrounded_bys_quotation_marks(): void
    {
        putenv('QUOTES_TEST="Test charlie; please ignore"');

        $env = Helpers::env('QUOTES_TEST');

        $this->assertEquals('Test charlie; please ignore', $env);
    }

    public function test_it_can_get_a_relative_path_from_one_path_to_another(): void
    {
        $relativePath = Helpers::realativePath('foo/bar', 'foo/bar/baz/qux');

        $this->assertEquals('baz/qux', $relativePath);
    }

    public function test_it_cat_get_a_relative_path_to_itself(): void
    {
        $relativePath = Helpers::realativePath('foo/bar/baz', 'foo/bar/baz');

        $this->assertEquals('', $relativePath);
    }

    public function test_it_can_get_a_relative_path_between_two_unrelated_paths(): void
    {
        $path = $this->expectException(RuntimeException::class);

        Helpers::realativePath('foo/bar', 'baz/qux');
    }
}
