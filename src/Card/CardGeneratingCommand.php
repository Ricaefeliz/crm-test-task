<?php

declare(strict_types=1);

namespace App\Card;

use Nette\DI\Container;
use Nette\Utils\Random;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Class CardGeneratingCommand
 * @package App\Card
 */
final class CardGeneratingCommand extends Command
{


	/** @var Container */
	protected $container;



	/**
	 * @inheritdoc
	 */
	protected function initialize(InputInterface $input, OutputInterface $output)
	{
		parent::initialize($input, $output);
		$this->container = $this->getHelper('container');
	}



	/**
	 * @inheritdoc
	 */
	protected function configure()
	{
		parent::configure();
		$this->setName('card:generate')
			->setDescription('Generate cards.');
	}



	/**
	 * @inheritDoc
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$limit = 10;
		$cardFacadeFactory = $this->container->getByType(CardFacadeFactory::class);
		$cardFacade = $cardFacadeFactory->create();

		for ($i = 0; $i <= $limit; $i++) {
			try {
				$card = $cardFacade->add(Card::TEMPORARY_TYPE, (int)Random::generate(5, '1-9'));
				$output->writeln(sprintf('Card with number \'%s\' has been added.', $card->getNumber()));
			} catch (CardFacadeException $exception) {
			}
		}
	}
}