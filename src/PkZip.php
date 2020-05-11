<?php namespace Eppak;

use League\Flysystem\Filesystem;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;

class PkZip
{
    /**
     * @var
     */
    private $filename;
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * PkZip constructor.
     * @param $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     *
     */
    private function open()
    {
        $adapter = new ZipArchiveAdapter($this->filename);
        $this->filesystem = new Filesystem($adapter);
    }

    /**
     *
     */
    private function close()
    {
        $this->filesystem->getAdapter()->getArchive()->close();
    }

    /**
     * @param $filename
     * @param $content
     */
    public function add($filename, $content)
    {
        $this->open();
        $path = base_path($filename);

        $this->filesystem->createDir('dir');
        $this->filesystem->put('dir/test.txt', $content);

        $this->close();
    }
}
