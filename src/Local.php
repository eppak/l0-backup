<?php namespace Eppak;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local as LocalAdapter;

class Local
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct($path)
    {
        $adapter = new LocalAdapter($path);
        $this->filesystem = new Filesystem($adapter);



        dd($this->filesystem->listContents('/', true));
    }


}
