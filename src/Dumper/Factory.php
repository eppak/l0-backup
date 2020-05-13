<?php namespace Eppak\Dumper;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Eppak\Dumper\MySql;
use Eppak\Contracts\Dumper;
use M1\Env\Parser as Env;

/**
 * (c) Alessandro Cappellozza <alessandro.cappellozza@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */
class Factory
{
    public static function make($config): ?Dumper
    {
        $config = static::parse($config);

        return static::driver($config);
    }

    private static function parse(string $config): ?array
    {
        if (Str::endsWith($config, '.env')) {
	    $values = new Env(File::get('/var/www/cloud/.env'));

            return $values->lines;
        }

        return null;
    }

    private static function driver(array $config): ?Dumper
    {
        $type = Str::lower($config['DB_CONNECTION']);

        switch ($type) {
            case 'mysql':
                return new MySql($config);

            default:
                return null;
        }
    }
}
