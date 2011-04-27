<?php

namespace DRodin\Extension;


use Silex\Application;
use Silex\ExtensionInterface;

use Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\ODM\MongoDB\DocumentManager,
    Doctrine\MongoDB\Connection,
    Doctrine\ODM\MongoDB\Configuration,
    Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

class MongoExtension implements ExtensionInterface
{
    public function register(Application $app)
    {
        $app['mongo.options'] = array_replace(array(
            'dbname'   => null
        ), isset($app['mongo.options']) ? $app['mongo.options'] : array());
		
        $app['mongo'] = $app->share(function () use($app) {
			return DocumentManager::create(new Connection(), $app['mongo.config']);			
        });
		
        $app['mongo.config'] = $app->share(function () use($app) {
            $config = new Configuration();
			
			if(isset($app['mongo.options']['dbname']))
			{
				$config->setDefaultDB($app['mongo.options']['dbname']);
			}
			
			$config->setProxyDir($app['mongo.common.proxy_dir']);
			$config->setProxyNamespace('Proxies');

			$config->setHydratorDir($app['mongo.common.hydrator_dir']);
			$config->setHydratorNamespace('Hydrators');

			$reader = new AnnotationReader();
			$reader->setDefaultAnnotationNamespace('Doctrine\\ODM\\MongoDB\\Mapping\\');
			$config->setMetadataDriverImpl(new AnnotationDriver($reader, $app['mongo.common.documents_dir']));
			
			return $config;
			
        });
		
        if (isset($app['mongo.common.class_path'])) {
            $app['autoloader']->registerNamespace('Doctrine\\Common', $app['mongo.common.class_path']);
        }
		
        if (isset($app['mongo.mongodb.class_path'])) {
            $app['autoloader']->registerNamespace('Doctrine\\MongoDB', $app['mongo.mongodb.class_path']);
        }
		
        if (isset($app['mongo.mongodbodm.class_path'])) {
            $app['autoloader']->registerNamespace('Doctrine\ODM\MongoDB', $app['mongo.mongodbodm.class_path']);
        }
		if (isset($app['mongo.common.documents_dir'])) {
			$app['autoloader']->registerNamespace('Documents', $app['mongo.common.documents_dir']);
		}
    }
}