<?php

declare(strict_types=1);

namespace App\Commands;

use App\Model\Exceptions\CryptographyException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DecryptionCommand extends BaseCommand
{

	protected function configure(): void
	{
		$this->setName('app:decrypt')
			->setDescription('Command for decrypting text.');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$text = $this->getTextFromInput($input, $output, 'Enter your text, which will be decrypted: ');
		$password = $this->getPasswordFromInput($input, $output);

		$output->writeln("\n");

		try {
			$decryptedText = $this->cryptography->decrypt($text, $password);
		} catch (CryptographyException $e) {
			$output->writeln($e->getMessage());

			return self::RETURN_CODE_ERROR;
		}

		$output->writeln("Your decrypted text is:\n");
		$output->writeln($decryptedText);

		return self::RETURN_CODE_OK;
	}
}
