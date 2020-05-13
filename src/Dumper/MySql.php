<?php namespace Eppak\Dumper; 

use Spatie\DbDumper\Databases\MySql as Driver;
use Eppak\Contracts\Dumper;
use Illuminate\Support\Facades\File;

/**
 * (c) Alessandro Cappellozza <alessandro.cappellozza@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class Mysql implements Dumper
{

    /**
     * @var array
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function name(): string
    {
        return 'mysql';
    }

    public function dump(string $filename): bool
    {
        Driver::create()
	    ->setHost($this->config['DB_HOST'])
	    ->setPort($this->config['DB_PORT'])
            ->setDbName($this->config['DB_DATABASE'])
            ->setUserName($this->config['DB_USERNAME'])
            ->setPassword($this->config['DB_PASSWORD'])
            ->dumpToFile($filename);

        return true;
    }
}
