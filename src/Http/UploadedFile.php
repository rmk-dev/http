<?php

/**
 * The uploaded file class
 */
namespace Rmk\Http;

use GuzzleHttp\Psr7\UploadedFile as GuzzleUploadedFile;

/**
 * Class UploadedFile
 * @package Rmk\Http
 */
class UploadedFile extends GuzzleUploadedFile implements UploadedFileInterface
{

}
