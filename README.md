
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



Usage
-----


Put you document in lib/Documents dir

	<?php
	// lib/Documents/User.php

	namespace Documents;


	/** @Document(collection="users") */
	class User
	{
		/** @Id */
		private $id;

		public function setId($id)
		{
			$this->id = $id;
		}

		public function getId()
		{
			return $this->id;
		}


		/** @Field(type="string") */
		private $username;


		public function setUsername($username)
		{
			$this->username = $username;
		}

		public function getUsername()
		{
			return $this->username;
		}

	}


After that use you documents


	$app->get('/testdb', function () use($app)
	{

		$document = new User();
		$document->setUsername('dima');

		$app['mongo']->persist($document);
		$app['mongo']->flush();

		return 'User created successfully!';

	});


That's all!

