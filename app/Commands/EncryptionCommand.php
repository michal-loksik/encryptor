<?php

declare(strict_types=1);

namespace App\Commands;

use App\Model\Exceptions\CryptographyException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EncryptionCommand extends BaseCommand
{

	protected function configure(): void
	{
		$this->setName('app:encrypt')
			->setDescription('Command for encrypting text.');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$text = $this->getTextFromInput($input, $output, 'Enter your text, which will be encrypted: ');
		$password = $this->getPasswordFromInput($input, $output);

		try {
			$cypher = $this->cryptography->encrypt($text, $password);
		} catch (CryptographyException $e) {
			$output->writeln($e->getMessage());

			return self::RETURN_CODE_ERROR;
		}

		$output->writeln("Your encrypted text is:\n");
		$output->writeln($cypher);

		return self::RETURN_CODE_OK;
	}
}
