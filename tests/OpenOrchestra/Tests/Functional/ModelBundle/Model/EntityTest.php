<?php

namespace OpenOrchestra\FunctionalTests\ModelBundle\Model;
use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractBaseTestCase;

/**
 * Description of BaseNodeTest
 *
 * @group integrationTest
 */
class EntityTest extends AbstractBaseTestCase
{
    /**
     * @param string $class
     * @param string $interface
     *
     * @dataProvider providateClassInterfaceRelation
     */
    public function testInstance($class, $interface)
    {
        $fullClass = 'OpenOrchestra\ModelBundle\Document\\' . $class;
        $fullInterface = 'OpenOrchestra\ModelInterface\Model\\' . $interface;
        $entity = new $fullClass();

        $this->assertInstanceOf($fullInterface, $entity);
    }

    /**
     * @return array
     */
    public function providateClassInterfaceRelation()
    {
        return array(
            array('Node'                     , 'NodeInterface'),
            array('Node'                     , 'SchemeableInterface'),
            array('Node'                     , 'ReadSchemeableInterface'),
            array('Node'                     , 'VersionableInterface'),
            array('Node'                     , 'SoftDeleteableInterface'),
            array('Node'                     , 'StatusableInterface'),
            array('Content'                  , 'StatusableInterface'),
            array('Content'                  , 'SoftDeleteableInterface'),
            array('Content'                  , 'VersionableInterface'),
            array('Content'                  , 'SiteLinkableInterface'),
            array('ContentType'              , 'SiteLinkableInterface'),
            array('Area'                     , 'AreaInterface'),
            array('Area'                     , 'ReadAreaInterface'),
            array('Block'                    , 'BlockInterface'),
            array('Block'                    , 'ReadBlockInterface'),
            array('Block'                    , 'TimestampableInterface'),
            array('ContentAttribute'         , 'ContentAttributeInterface'),
            array('ContentAttribute'         , 'ReadContentAttributeInterface'),
            array('Content'                  , 'ContentInterface'),
            array('Content'                  ,  'ReadContentInterface'),
            array('ContentType'              , 'ContentTypeInterface'),
            array('ContentType'              , 'SoftDeleteableInterface'),
            array('ContentType'              , 'FieldTypeContainerInterface'),
            array('ContentType'              , 'VersionableInterface'),
            array('FieldType'                , 'FieldTypeInterface'),
            array('FieldOption'              , 'FieldOptionInterface'),
            array('Site'                     , 'SiteInterface'),
            array('Site'                     , 'SoftDeleteableInterface'),
            array('SiteAlias'                , 'SiteAliasInterface'),
            array('SiteAlias'                , 'SchemeableInterface'),
            array('SiteAlias'                , 'ReadSchemeableInterface'),
            array('Node'                     , 'BlameableInterface'),
            array('Content'                  , 'BlameableInterface'),
            array('ContentType'              , 'BlameableInterface'),
            array('Node'                     , 'TimestampableInterface'),
            array('Content'                  , 'TimestampableInterface'),
            array('ContentType'              , 'TimestampableInterface'),
            array('Keyword'                  , 'KeywordInterface'),
            array('Content'                  , 'KeywordableInterface'),
            array('Redirection'              , 'RedirectionInterface'),
            array('Redirection'              , 'ReadRedirectionInterface'),
            array('TrashItem'                , 'TrashItemInterface'),
            array('RouteDocument'            , 'RouteDocumentInterface'),
            array('WorkflowProfile'          , 'WorkflowProfileInterface'),
            array('WorkflowProfileCollection', 'WorkflowProfileCollectionInterface'),
            array('WorkflowTransition'       , 'WorkflowTransitionInterface'),
        );
    }
}
