<?php

declare(strict_types=1);

namespace App\Commands;

use App\Model\Cryptography;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

abstract class BaseCommand extends Command
{

	protected const RETURN_CODE_OK = 0;
	protected const RETURN_CODE_ERROR = 1;

	protected QuestionHelper $questionHelper;

	protected Cryptography $cryptography;

	public function __construct(QuestionHelper $questionHelper, Cryptography $cryptography)
	{
		parent::__construct();

		$this->questionHelper = $questionHelper;
		$this->cryptography = $cryptography;
	}

	protected function getTextFromInput(InputInterface $input, OutputInterface $output, string $questionText): string
	{
		$questionForText = (new Question($questionText))
			->setValidator(function ($answer) {
				if (is_string($answer) === false || $answer === '') {
					throw new RuntimeException('Text cannot be empty!');
				}

				return $answer;
			});

		return (string) $this->questionHelper->ask($input, $output, $questionForText);
	}

	protected function getPasswordFromInput(InputInterface $input, OutputInterface $output): string
	{
		$questionForPassword = (new Question('Enter password: '))
			->setValidator(function ($answer) {
				if (is_string($answer) === false || $answer === '') {
					throw new RuntimeException('Password cannot be empty!');
				}

				return $answer;
			})
			->setHidden(true)
			->setHiddenFallback(false);

		return (string) $this->questionHelper->ask($input, $output, $questionForPassword);
	}
}
