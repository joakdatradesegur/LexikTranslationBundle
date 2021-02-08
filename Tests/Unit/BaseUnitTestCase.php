<?php

namespace Lexik\Bundle\TranslationBundle\Tests\Unit;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Proxy\AbstractProxyFactory;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use Lexik\Bundle\TranslationBundle\Storage\DoctrineORMStorage;
use Lexik\Bundle\TranslationBundle\Tests\Fixtures\TransUnitData;
use PHPUnit\Framework\TestCase;

/**
 * Base unit test class providing functions to create a mock entity manger, load schema and fixtures.
 *
 * @author Cédric Girard <c.girard@lexik.fr>
 */
abstract class BaseUnitTestCase extends TestCase
{
    const ENTITY_TRANS_UNIT_CLASS  = 'Lexik\Bundle\TranslationBundle\Entity\TransUnit';
    const ENTITY_TRANSLATION_CLASS = 'Lexik\Bundle\TranslationBundle\Entity\Translation';
    const ENTITY_FILE_CLASS        = 'Lexik\Bundle\TranslationBundle\Entity\File';

    /**
     * Create a storage class form doctrine ORM.
     *
     * @param EntityManagerInterface $em
     * @return DoctrineORMStorage
     */
    protected function getORMStorage(EntityManagerInterface $em): DoctrineORMStorage
    {
        $registryMock = $this->getDoctrineRegistryMock($em);

        $storage = new DoctrineORMStorage($registryMock, 'default', array(
            'trans_unit'  => self::ENTITY_TRANS_UNIT_CLASS,
            'translation' => self::ENTITY_TRANSLATION_CLASS,
            'file'        => self::ENTITY_FILE_CLASS,
        ));

        return $storage;
    }

    /**
     * Create the database schema.
     *
     * @param EntityManagerInterface $om
     */
    protected function createSchema(EntityManagerInterface $om)
    {
        if ($om instanceof \Doctrine\ORM\EntityManager) {
            $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($om);
            $schemaTool->createSchema($om->getMetadataFactory()->getAllMetadata());
        }
    }

    /**
     * Load test fixtures.
     *
     * @param EntityManagerInterface $om
     */
    protected function loadFixtures(EntityManagerInterface $om)
    {
        if ($om instanceof \Doctrine\ORM\EntityManager) {
            $purger = new ORMPurger();
            $executor = new ORMExecutor($om, $purger);
        }

        $fixtures = new TransUnitData();
        $executor->execute(array($fixtures), false);
    }

    /**
     * @param $om
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getDoctrineRegistryMock($om)
    {
        $registryMock = $this->getMockBuilder('Symfony\Bridge\Doctrine\ManagerRegistry')
            ->setConstructorArgs(array(
                'registry',
                array(),
                array(),
                'default',
                'default',
                'proxy',
            ))
            ->getMock();

        $registryMock
            ->expects($this->any())
            ->method('getManager')
            ->will($this->returnValue($om))
        ;

        return $registryMock;
    }

    /**
     * EntityManager mock object together with annotation mapping driver and
     * pdo_sqlite database in memory
     *
     * @return EntityManagerInterface
     * @throws ORMException
     */
    protected function getMockSqliteEntityManager($mockCustomHydrator = false): EntityManagerInterface
    {
        $cache = new \Doctrine\Common\Cache\ArrayCache();

        // xml driver
        $xmlDriver = new \Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver(array(
            __DIR__.'/../../Resources/config/model'    => 'Lexik\Bundle\TranslationBundle\Model',
            __DIR__.'/../../Resources/config/doctrine' => 'Lexik\Bundle\TranslationBundle\Entity',
        ));

        $config = Setup::createAnnotationMetadataConfiguration(array(
            __DIR__.'/../../Model',
            __DIR__.'/../../Entity',
        ), false, null, null, false);

        $config->setMetadataDriverImpl($xmlDriver);
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);
        $config->setProxyDir(sys_get_temp_dir());
        $config->setProxyNamespace('Proxy');
        $config->setAutoGenerateProxyClasses(AbstractProxyFactory::AUTOGENERATE_EVAL);
        $config->setClassMetadataFactoryName('Doctrine\ORM\Mapping\ClassMetadataFactory');
        $config->setDefaultRepositoryClassName('Doctrine\ORM\EntityRepository');

        if ($mockCustomHydrator) {
            $config->setCustomHydrationModes(array(
                'SingleColumnArrayHydrator' => 'Lexik\Bundle\TranslationBundle\Util\Doctrine\SingleColumnArrayHydrator',
            ));
        }

        $conn = array(
            'driver' => 'pdo_sqlite',
            'memory' => true,
        );

        return \Doctrine\ORM\EntityManager::create($conn, $config);
    }
}
