<?php

declare(strict_types=1);

namespace App\Model\Exceptions;

use Exception;

class CryptographyException extends Exception
{

	public static function createEncryptionFailed(): self
	{
		return new self('Encryption failed!');
	}

	public static function createDecryptionFailed(): self
	{
		return new self('Failed to decrypt text with entered password combination!');
	}
}
