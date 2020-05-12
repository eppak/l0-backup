<?php namespace Eppak;

use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;


class S3 {

    public function __construct()
	{
		$client = new S3Client([
		    'credentials' => [
		        'key'    => '',
		        'secret' => '',
		    ],
		    'region' => 'fr-par',
		    'version' => 'latest',
		    'endpoint' => 'https://s3.fr-par.scw.cloud'
		]);

		$adapter = new AwsS3Adapter($client, 'laravel-backup');


		$filesystem = new Filesystem($adapter);


		$filesystem->put('test.txt', time());	
		$filesystem->put('folder/test2.txt', time());
	}

}
