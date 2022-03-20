<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Exceptions\CryptographyException;

class Cryptography
{

	private string $cypherMethod;

	private string $iv;

	public function __construct(string $cypherMethod, string $iv)
	{
		$this->cypherMethod = $cypherMethod;
		$this->iv = $iv;
	}

	/**
	 * @param string $text
	 * @param string $password
	 * @return string
	 * @throws CryptographyException
	 */
	public function encrypt(string $text, string $password): string
	{
		$cypher = openssl_encrypt($text, $this->cypherMethod, $password, 0, $this->iv);

		if ($cypher === false) {
			throw CryptographyException::createEncryptionFailed();
		}

		return $cypher;
	}

	/**
	 * @param string $text
	 * @param string $password
	 * @return string
	 * @throws CryptographyException
	 */
	public function decrypt(string $text, string $password): string
	{
		$decryptedText = openssl_decrypt($text, $this->cypherMethod, $password, 0, $this->iv);

		if ($decryptedText === false) {
			throw CryptographyException::createDecryptionFailed();
		}

		return $decryptedText;
	}
}
