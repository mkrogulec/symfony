<?php

namespace Doctrine\ODM\MongoDB\Tests\Functional;

use Doctrine\Common\ClassLoader,
    Doctrine\Common\Cache\ApcCache,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\ODM\MongoDB\DocumentManager,
    Doctrine\ODM\MongoDB\Configuration,
    Doctrine\ODM\MongoDB\Mapping\ClassMetadata,
    Doctrine\MongoDB\Connection,
    Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

class EnvironmentTest extends \PHPUnit_Framework_TestCase
{
    protected $dbNames = array
    (
        'specified' => 'test_testing',
        'unspecified' => 'testing_default',
    );

    protected $defaultDB = 'testing_default';

    public function setUp()
    {
        $config = new Configuration();

        $config->setProxyDir(__DIR__ . '/../../../../../Proxies');
        $config->setProxyNamespace('Proxies');

        $config->setHydratorDir(__DIR__ . '/../../../../../Hydrators');
        $config->setHydratorNamespace('Hydrators');

        $config->setEnvironment('test');
        $config->setDefaultDB($this->defaultDB);

        $reader = new AnnotationReader();
        $reader->setDefaultAnnotationNamespace('Doctrine\ODM\MongoDB\Mapping\\');
        $config->setMetadataDriverImpl(new AnnotationDriver($reader, __DIR__ . '/Documents'));
        
        $conn = new Connection();

        $this->dm = DocumentManager::create($conn, $conn->selectDatabase($this->defaultDB), $config);
    }

    public function testDefaultDb()
    {
        $dbname = $this->dm->getConfiguration()->getDefaultDB();
        $this->assertEquals($this->defaultDB, $dbname);
    }

    public function testSetEnvironmentForDocumentUnspecifiedDb()
    {
        $dbname = $this->dm->getDatabase()->getName();
        $this->assertEquals($this->defaultDB, $dbname);
    }

    public function testSetEnvironment()
    {
        $dbname  = $this->dm->getDatabase()->getName();

        $this->assertEquals($this->defaultDB, $dbname);
    }

    public function testFind()
    {
        $collection = $this->dm->getDatabase()
            ->selectCollection('documents');
        $testDoc = array('name' => 'test doc');
        $collection->insert($testDoc);

        $this->assertTrue($testDoc['_id'] instanceof \MongoId);

        $doc = $this->dm->find('Doctrine\ODM\MongoDB\Tests\Functional\TestDocument', (string) $testDoc['_id']);
        $this->assertNotNull($doc);
        $this->assertEquals($doc->getId(), (string) $testDoc['_id']);
    }

    public function testFindForDocWithUnspecifiedDb()
    {
        $conn = $this->dm->getConnection();
        $collection = $conn->selectDatabase($this->dbNames['unspecified'])
            ->selectCollection('documents');
        $testDoc = array('name' => 'test doc with unspecified db name.');
        $collection->insert($testDoc);

        $this->assertTrue($testDoc['_id'] instanceof \MongoId);

        $doc = $this->dm->find('Doctrine\ODM\MongoDB\Tests\Functional\TestEmptyDatabase', (string)$testDoc['_id']);
        $this->assertNotNull($doc);
        $this->assertEquals($doc->getId(), (string)$testDoc['_id']);
    }

    public function testCustomQuery()
    {
        $conn = $this->dm->getConnection();
        $coll = $conn->selectDatabase($this->defaultDB)
            ->selectCollection('documents');
        $doc = array('name' => 'test doc');
        $coll->insert($doc);

        $docName = $this->dm->createQueryBuilder('Doctrine\ODM\MongoDB\Tests\Functional\TestDocument')
            ->field('name')->equals('test doc')
            ->getQuery()
            ->getSingleResult();
        $this->assertNotNull($docName);
        $this->assertEquals((string)$doc['_id'], $docName->getId());
    }

    public function tearDown()
    {
        $documents = array(
            'Doctrine\ODM\MongoDB\Tests\Functional\TestDocument',
            'Doctrine\ODM\MongoDB\Tests\Functional\TestEmptyDatabase',
        );
        foreach ($documents as $document) {
            $this->dm->getDocumentCollection($document)->drop();
        }
    }
}

/** @Document(db="testing", collection="documents") */
class TestDocument
{
    /** @Id */
    private $id;

    /** @Field(type="string") */
    private $name;

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}

/** @Document(collection="documents") */
class TestEmptyDatabase
{
    /** @Id */
    private $id;

    /** @Field(type="string") */
    private $name;

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name;
    }

    public function getName()
    {
        return $this->name;
    }
}
