<?php namespace Eppak;

use Eppak\Archives\S3;
use Eppak\Contracts\Context;
use Exception;
use Illuminate\Support\Facades\File;

/**
 * (c) Alessandro Cappellozza <alessandro.cappellozza@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */
class Backup
{
    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var S3
     */
    private $archive;
    /**
     * @var Context
     */
    private $context;

    /**
     * Backup constructor.
     * @param Configuration $configuration
     * @param S3 $archive
     */
    public function __construct(Configuration $configuration, S3 $archive)
    {
        $this->configuration = $configuration;
        $this->archive = $archive;
    }

    public function run(Context $context)
    {
        $size = 0;
        $this->context = $context;

        foreach ($this->configuration->get('sites') as $name => $value) {
            try {
                $destination = $this->configuration->get("sites.{$name}.destination");
                $db = $this->configuration->get("sites.{$name}.assets.db");
                $files = $this->configuration->get("sites.{$name}.assets.files");

                $this->context->startTask("SITE {$name}", 'Creating...');

                $this->files($name, $files);
                $this->db($name, $db);
                $this->move($destination, $name);

                $size += File::size($this->temp($name));
                $this->context->endTask("SITE {$name}", 'Done', true);

                File::delete($this->temp($name));
            } catch (Exception $e) {
                $this->context->endTask("SITE {$name}",false, $e->getMessage());
            }
        }

        $this->context->info("TOTAL " . hrSize($size));
    }

    private function temp($name)
    {
        $temp = $this->configuration->get('tmp');

        return "{$temp}/{$name}.zip";
    }

    private function move($destination, $name)
    {
        $to = "{$destination}/{$name}.zip";

        $this->archive->put($to, File::get($this->temp($name)));
    }

    private function db($name, $config)
    {
        //$zip = new PkZip($this->temp($name));
        $temp = $this->configuration->get('tmp');
        $dump = "{$temp}/{$name}.sql";

        // TODO
        /*

        Spatie\DbDumper\Databases\MySql::create()
            ->setDbName($databaseName)
            ->setUserName($userName)
            ->setPassword($password)
            ->dumpToFile($dump);

        $zip->add($dump);
        $zip->close();
        */
    }

    private function files($name, $files)
    {
        $zip = new PkZip($this->temp($name));

        foreach ($files as $file) {
            $zip->directory($file);
        }

        $zip->close();
    }
}
