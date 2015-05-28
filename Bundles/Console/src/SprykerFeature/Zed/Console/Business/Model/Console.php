<?php

namespace SprykerFeature\Zed\Console\Business\Model;

use Generated\Zed\Ide\AutoCompletion;

use SprykerEngine\Shared\Kernel\Factory\FactoryInterface;
use SprykerEngine\Shared\Kernel\LocatorLocatorInterface;

use SprykerFeature\Zed\Application\Communication\Plugin\ServiceProvider\PropelServiceProvider;
use SprykerEngine\Zed\Kernel\Communication\DependencyContainer\DependencyContainerInterface;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Psr\Log\LoggerInterface;

class Console extends SymfonyCommand
{

    use Helper;

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var AutoCompletion
     */
    protected $locator;

    /**
     * @var DependencyContainerInterface
     */
    private $dependencyContainer;

    /**
     * @var LoggerInterface
     */
    protected $messenger;

    /**
     * @param FactoryInterface $factory
     * @param LocatorLocatorInterface $locator
     */
    public function __construct(
        FactoryInterface $factory,
        LocatorLocatorInterface $locator
    ) {
        if ($factory->exists('DependencyContainer')) {
            $this->dependencyContainer = $factory->create('DependencyContainer', $factory, $locator);
        }

        $this->locator = $locator;

        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $propelService = new PropelServiceProvider();
        $propelService->boot(new \Silex\Application());
    }

    /**
     * @param string $command
     * @param array $arguments
     */
    protected function runDependingCommand($command, array $arguments = [])
    {
        //TODO find is unknown
        $command = $this->getApplication()->find($command);
        $arguments['command'] = $command;
        $input = new ArrayInput($arguments);
        $command->run($input, $this->output);
    }

    /**
     * @return LoggerInterface
     */
    protected function getMessenger()
    {
        if (is_null($this->messenger)) {
            $this->messenger = new ConsoleMessenger($this->output);

            $this->messenger->setTranslator(
                $this->locator->translation()->facade()
            );
        }

        return $this->messenger;
    }

    /**
     * @return DependencyContainerInterface
     */
    protected function getDependencyContainer()
    {
        return $this->dependencyContainer;
    }

    /**
     * @return AutoCompletion
     */
    protected function getLocator()
    {
        return $this->locator;
    }
}
