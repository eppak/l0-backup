<?php namespace Eppak\Contracts;

interface Context
{
    /**
     * @param string $string
     * @return mixed
     */
    public function __invoke(string $string);

    /**
     * @param object $context
     * @return Context
     */
    public function context(object $context): Context;

    /**
     * @param string $string
     * @return mixed
     */
    public function info(string $string);

    /**
     * @param string $string
     * @return mixed
     */
    public function warn(string $string);

    /**
     * @param string $string
     * @param null $e
     * @return mixed
     */
    public function error(string $string, $e = null);

    /**
     * @param string $string
     * @return mixed
     */
    public function debug(string $string);

    /**
     * @param string $name
     * @param string $loading
     * @return mixed
     */
    public function startTask(string $name, $loading = 'loading...');

    /**
     * @param string $name
     * @param bool $completed
     * @param string $error
     * @return mixed
     */
    public function endTask(string $name, bool $completed, $error = 'failed');
}
