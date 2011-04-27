
Doctrine ODM (MongoDB) extension for the Silex framework. 


Installation
------------

	$ mkdir Extension
	$ cd Extension
	$ git clone git://github.com/madiedinro/MongoExtension.git MongoExtension



Configuration
------------
	<?php 
	require_once __DIR__.'/silex.phar';
	require_once __DIR__.'/Extension/MongoExtension/MongoExtension.php';

	// ...
	
	use DRodin\Extension\MongoExtension;

	// ...

	$app = new Application();

	// ...

	$app->register(new MongoExtension(), array(
		'mongo.options'            => array(
			'dbname'	=> 'madieru' // default DB
		),
		'mongo.common.class_path'  => __DIR__.'/vendor/doctrineCommon/lib',
		'mongo.mongodb.class_path'  => __DIR__.'/vendor/doctrineMongoDB/lib',
		'mongo.mongodbodm.class_path'  => __DIR__.'/vendor/doctrineMongoDBODM/lib',

		'mongo.common.proxy_dir' => __DIR__.'/cache',
		'mongo.common.hydrator_dir' => __DIR__.'/cache',
		'mongo.common.documents_dir' => __DIR__.'/lib',
	));



