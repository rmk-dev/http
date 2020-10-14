<?php

namespace Rmk\HttpTests;

use GuzzleHttp\Psr7\Stream;
use PHPUnit\Framework\TestCase;
use Rmk\Http\Factory\UploadedFileFactory;
use Rmk\Http\UploadedFile;

class UploadedFileFactoryTest extends TestCase
{

    public function testCreateUploadedFile()
    {
        $factory = new UploadedFileFactory();
        $stream = new Stream(fopen('php://input', 'r'));
        $file = $factory->createUploadedFile($stream, 0);
        $this->assertInstanceOf(UploadedFile::class, $file);
    }
}
