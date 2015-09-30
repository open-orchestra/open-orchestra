<?php

namespace OpenOrchestra\jmeter\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OpenOrchestra\DisplayBundle\DisplayBlock\Strategies\TinyMCEWysiwygStrategy;
use OpenOrchestra\ModelBundle\Document\Area;
use OpenOrchestra\ModelBundle\Document\Block;
use OpenOrchestra\ModelBundle\Document\Node;
use OpenOrchestra\ModelBundle\Document\Status;
use OpenOrchestra\ModelBundle\Document\TranslatedValue;
use OpenOrchestra\ModelInterface\Model\NodeInterface;
use OpenOrchestra\ModelInterface\Model\AreaInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use OpenOrchestra\BackofficeBundle\Manager\RouteDocumentManager;

/**
 * Class LoadNodeData
 */
class LoadNodeData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var RouteDocumentManager
     */
    private $updateRoute;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->updateRoute = $this->container->get('open_orchestra_backoffice.manager.route_document');

    }

    const NUMBER_OF_NODE = 100;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i=0; self::NUMBER_OF_NODE > $i; $i++) {
            $name = 'node' . $i;
            $pattern = '/node' . $i;
            $content = 'Node ' . $i . 'on ' . self::NUMBER_OF_NODE;
            $this->generateSimpleNode($name, 'en', $manager, $content, $pattern);
            $this->generateSimpleNode($name, 'fr', $manager, $content, $pattern);
        }
        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 300;
    }

    /**
     * @param string        $name
     * @param string        $language
     * @param ObjectManager $manager
     * @param string        $htmlBody
     * @param string        $pattern
     *
     * @return NodeInterface
     */
    public function generateSimpleNode($name, $language, ObjectManager $manager, $htmlBody = null, $pattern = null)
    {
        $areaHeader  = $this->generateHeaderArea();
        $areaContent = $this->generateContentArea();
        $areaFooter  = $this->generateFooterArea();

        $titleBlock = new Block();
        $titleBlock->setClass('block-body-header');
        $titleBlock->setComponent(TinyMCEWysiwygStrategy::TINYMCEWYSIWYG);
        $titleBlock->setAttributes(array('htmlContent' => '<h1>' . $name . '</h1>'));

        $contentBlock = new Block();
        $contentBlock->setClass('block-body');
        $contentBlock->setComponent(TinyMCEWysiwygStrategy::TINYMCEWYSIWYG);
        $contentBlock->setAttributes(array('htmlContent' => $htmlBody));

        $areaContent->addBlock(array('nodeId' => 0, 'blockId' => 0));
        $areaContent->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $node = $this->generateNode($name, NodeInterface::ROOT_NODE_ID, $pattern, $name, $language);

        $node->addArea($areaHeader);
        $node->addArea($areaContent);
        $node->addArea($areaFooter);

        $node->addBlock($titleBlock);
        $node->addBlock($contentBlock);
        $node->setInMenu(true);

        $routes = $this->updateRoute->createForNode($node);
        foreach ($routes as $route) {
            $manager->persist($route);
        }

        $manager->persist($node);
    }

    /**
     * @return AreaInterface
     */
    protected function generateHeaderArea()
    {
        $areaHeader = $this->generateArea('header');
        $areaHeader->setHtmlClass('area-header');
        $areaHeader->addBlock(array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 0));
        $areaHeader->addBlock(array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 1));

        return $areaHeader;
    }

    /**
     * @return AreaInterface
     */
    protected function generateContentArea()
    {
        $areaContent = $this->generateArea('content');
        $areaContent->setHtmlClass('area-body');

        return $areaContent;
    }

    /**
     * @return AreaInterface
     */
    protected function generateFooterArea()
    {
        $areaFooter = $this->generateArea('footer');
        $areaFooter->setHtmlClass('area-footer');
        $areaFooter->addBlock(array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 2));
        $areaFooter->addBlock(array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 3));
        $areaFooter->addBlock(array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 4));

        return $areaFooter;
    }

    /**
     * @param string $name
     *
     * @return AreaInterface
     */
    protected function generateArea($name)
    {
        $area = new Area();
        $area->setAreaId($name);
        $area->setLabel($name);

        return $area;
    }

    /**
     * @param string $nodeId
     * @param string $parentId
     * @param string $routePattern
     * @param string $name
     * @param string $language
     * @param string $type
     *
     * @return NodeInterface
     */
    protected function generateNode($nodeId, $parentId, $routePattern, $name, $language, $type = NodeInterface::TYPE_DEFAULT)
    {
        $label = new TranslatedValue();
        $label->setLanguage($language);
        $label->setValue("published");

        $value = new Status();
        $value->setName("published");
        $value->setPublished(true);
        $value->setInitial(false);
        $value->addLabel($label);
        $value->setDisplayColor("red");

        $node = new Node();
        $node->setNodeId($nodeId);
        $node->setNodeType($type);
        $node->setSiteId('2');
        $node->setParentId($parentId);
        $node->setPath('-');
        $node->setRoutePattern($routePattern);
        $node->setName($name);
        $node->setVersion(1);
        $node->setLanguage($language);
        $node->setDeleted(false);
        $node->setCreatedAt(new \Datetime());
        $node->setUpdatedAt(new \Datetime());
        $node->setStatus($value);

        return $node;
    }

}
