<?php namespace Eppak\Contexts;

use Eppak\Contracts\Context;
use LaravelZero\Framework\Commands\Command as BaseCommand;

class Command implements Context
{
    /**
     * @var BaseCommand
     */
    private $context;

    /**
     * Command constructor.
     * @param object $context
     */
    public function __construct(object $context)
    {
        $this->context = $context;
    }

    /**
     * @param string $string
     */
    public function __invoke(string $string)
    {
        $this->context->info($string);
    }

    /**
     * @param object $context
     * @return $this|Context
     */
    public function context(object $context): Context
    {
        $this->context = $context;

        return $this;
    }

    /**
     * @param string $string
     */
    public function info(string $string)
    {
        $this->context->info($string);
    }

    /**
     * @param string $string
     */
    public function warn(string $string)
    {
        $this->context->warn($string);
    }

    /**
     * @param string $string
     * @param null $e
     */
    public function error(string $string, $e = null)
    {
        $this->context->error($string);
    }

    /**
     * @param string $string
     */
    public function debug(string $string)
    {
        $this->context->info($string);
    }

    /**
     * @param string $name
     * @param string $loading
     */
    public function startTask(string $name, $loading = 'loading...')
    {
        $output = $this->context->getOutput();
        $output->write("$name: <comment>{$loading}</comment>");

        $this->context->setOutput($output);
    }

    /**
     * @param string $name
     * @param bool $completed
     * @param string $error
     */
    public function endTask(string $name, bool $completed, $error = 'failed')
    {
        $output = $this->context->getOutput();
        $message = "$name: <info>✔</info>";

        if (!$completed) {
            $message = "$name: <error>{$error}</error>";
        }

        if ($output->isDecorated()) {
            $output->write("\x0D");
            $output->write("\x1B[2K");
            $output->writeln($message);

            $this->context->setOutput($output);
            return;
        }

        $output->writeln('');
        $output->writeln($message);

        $this->context->setOutput($output);
    }
}
