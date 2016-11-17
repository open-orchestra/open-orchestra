<?php

namespace OpenOrchestra\FunctionalTests\ModelBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\ModelBundle\Repository\RouteDocumentRepository;

/**
 * Test RouteDocumentRepositoryTest
 *
 * @group integrationTest
 */
class RouteDocumentRepositoryTest extends AbstractKernelTestCase
{
    /**
     * @var RouteDocumentRepository
     */
    protected $repository;

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();

        static::bootKernel();
        $this->repository = static::$kernel->getContainer()->get('open_orchestra_model.repository.route_document');
    }

    /**
     * Test simple route
     *
     * @param string $pathInfo
     * @param string $name
     *
     * @dataProvider provideSimplePathInfo
     */
    public function testFindByPathInfoWithSingleAnswer($pathInfo, $name)
    {
        $routes = $this->repository->findByPathInfo($pathInfo);

        $this->assertCount(1, $routes);
        $this->assertSame($name, $routes[0]->getName());
    }

    /**
     * @return array
     */
    public function provideSimplePathInfo()
    {
        return array(
            array('foo', 'foo'),
            array('baz/bar', 'baz/bar'),
            array('foo/test', 'foo/{bar}'),
            array('foo/test/baz', 'foo/{bar}/baz'),
        );
    }

    /**
     * @param string $pathInfo
     * @param string $name0
     * @param string $name1
     *
     * @dataProvider provideMultiplePath
     */
    public function testFindByPathInfoWithMultipleAnswer($pathInfo, $name0, $name1)
    {
        $routes = $this->repository->findByPathInfo($pathInfo);

        $this->assertCount(2, $routes);
        $this->assertSame($name0, $routes[0]->getName());
        $this->assertSame($name1, $routes[1]->getName());
    }

    /**
     * @return array
     */
    public function provideMultiplePath()
    {
        return array(
            array('foo/bar', 'foo/bar', 'foo/{bar}'),
        );
    }

    /**
     * @param string $pathInfo
     * @param int    $count
     * @param string $name0
     * @param string $name1
     * @param string $name2
     * @param string $name3
     *
     * @dataProvider provideLongUrlPattern
     */
    public function testFindByPathInfoWithLongUrl($pathInfo, $count, $name0, $name1, $name2, $name3)
    {
        $routes = $this->repository->findByPathInfo($pathInfo);

        $this->assertCount($count, $routes);
        $this->assertSame($name0, $routes[0]->getName());
        $this->assertSame($name1, $routes[1]->getName());
        $this->assertSame($name2, $routes[2]->getName());
        $this->assertSame($name3, $routes[3]->getName());

    }

    /**
     * @return array
     */
    public function provideLongUrlPattern()
    {
        return array(
            array(
                'zero/one/two/three/four/five/six/{seven}/eight/nine/ten/eleven',
                4,
                'zero/one/two/three/four/five/six/{seven}/eight/nine/ten/eleven',
                'zero/one/two/three/four/five/six/{seven}/eight/nine/ten/eleven/twelve',
                'zero/one/two/three/four/five/six/{seven}/eight/nine/ten/{eleven}/twelve',
                'zero/one/two/three/four/five/six/{seven}/eight/nine/ten/eleven/{twelve}',
            ),
            array(
                'zero/one/two/three/four/five/six/{seven}/eight/nine/ten/eleven/twelve',
                4,
                'zero/one/two/three/four/five/six/{seven}/eight/nine/ten/eleven',
                'zero/one/two/three/four/five/six/{seven}/eight/nine/ten/eleven/twelve',
                'zero/one/two/three/four/five/six/{seven}/eight/nine/ten/{eleven}/twelve',
                'zero/one/two/three/four/five/six/{seven}/eight/nine/ten/eleven/{twelve}',
            ),
            array(
                'zero/one/two/three/four/five/six/{seven}/eight/nine/ten/eleven/other',
                4,
                'zero/one/two/three/four/five/six/{seven}/eight/nine/ten/eleven',
                'zero/one/two/three/four/five/six/{seven}/eight/nine/ten/eleven/twelve',
                'zero/one/two/three/four/five/six/{seven}/eight/nine/ten/{eleven}/twelve',
                'zero/one/two/three/four/five/six/{seven}/eight/nine/ten/eleven/{twelve}',
            ),
            array(
                'zero/one/two/three/four/five/six/{seven}/eight/nine/ten/other/twelve',
                4,
                'zero/one/two/three/four/five/six/{seven}/eight/nine/ten/eleven',
                'zero/one/two/three/four/five/six/{seven}/eight/nine/ten/eleven/twelve',
                'zero/one/two/three/four/five/six/{seven}/eight/nine/ten/{eleven}/twelve',
                'zero/one/two/three/four/five/six/{seven}/eight/nine/ten/eleven/{twelve}',
            ),
        );
    }

    /**
     * @param string $siteId
     * @param int    $count
     *
     * @dataProvider provideSiteIdCount
     */
    public function testFindBySiteId($siteId, $count)
    {
        $this->assertCount($count, $this->repository->findBySiteId($siteId));
    }

    /**
     * @return array
     */
    public function provideSiteIdCount()
    {
        return array(
            array('2', 32),
            array('fake2', 0),
        );
    }
}
