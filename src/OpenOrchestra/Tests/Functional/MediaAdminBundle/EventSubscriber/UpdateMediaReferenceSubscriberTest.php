<?php

namespace OpenOrchestra\FunctionalTests\MediaAdminBundle\EventSubscriber;

use OpenOrchestra\FunctionalTests\Utils\AbstractAuthenticatedTest;
use OpenOrchestra\Media\Model\MediaInterface;
use OpenOrchestra\MediaModelBundle\Document\Media;
use OpenOrchestra\ModelBundle\Document\Block;
use OpenOrchestra\ModelBundle\Document\Node;
use Symfony\Component\EventDispatcher\EventDispatcher;
use OpenOrchestra\ModelInterface\Event\BlockEvent;
use OpenOrchestra\ModelInterface\BlockEvents;

/**
 * Class UpdateMediaReferenceSubscriberTest
 *
 * @group media
 */
class UpdateMediaReferenceSubscriberTest extends AbstractAuthenticatedTest
{
    const ATTRIBUTE_ID_SUFFIX = "Id";
    const METHOD_SUFFIX = "BlockConfiguration";

    /**
     * @var Node node
     */
    protected $node;

    /**
     * @var array medias
     */
    protected $medias;

    /**
     * @var EventDispatcher eventDispatcher
     */
    protected $eventDispatcher;

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();

        $mediaRepository = static::$kernel->getContainer()->get('open_orchestra_media.repository.media');
        $this->medias = array(
            $mediaRepository->findOneByName("Image 03"),
            $mediaRepository->findOneByName("Image 04")
        );
        $this->eventDispatcher = static::$kernel->getContainer()->get('event_dispatcher');
    }

    /**
     * @param array  $blockType
     * @param int    $mediaIndex
     *
     * @dataProvider provideMediaBlocks
     */
    public function testAddMediaBlocks(array $blockType, $mediaIndex)
    {
        /** @var Media $media */
        $media = $this->medias[$mediaIndex];
        $this->checkMediaReference($media, array());

        $block = $this->generateBlock($blockType['component']);
        $attributes = $block->getAttributes();
        $attributes['pictures'] = array(array('id' => $media->getId(), 'format' => ''));
        $attributes['id'] = $blockType["component"] . self::ATTRIBUTE_ID_SUFFIX;
        $method = $blockType["component"] . self::METHOD_SUFFIX;
        $attributes = $this->$method($attributes);
        $block->setAttributes($attributes);

        $event = new BlockEvent($block);

        $this->eventDispatcher->dispatch(BlockEvents::POST_BLOCK_UPDATE, $event);

        $expectedReference = array('block' => array($block->getId() => $block->getId()));
        $this->checkMediaReference($media, $expectedReference);
    }

    /**
     * @return array
     */
    public function provideMediaBlocks()
    {
        return array(
            array(array("component" => "gallery"), 0),
            array(array("component" => "slideshow"), 1),
        );
    }

    /**
     * @param MediaInterface $media
     * @param array          $expectedReference
     */
    protected function checkMediaReference($media, $expectedReference)
    {
        $references = $media->getUseReferences();
        $this->assertEquals($references, $expectedReference);
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    protected function slideshowBlockConfiguration($attributes)
    {
        $attributes['height'] = 200;
        $attributes['width'] = 250;

        return $attributes;
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    protected function galleryBlockConfiguration($attributes)
    {
        $attributes['imageFormat'] = MediaInterface::MEDIA_ORIGINAL;
        $attributes['thumbnailFormat'] = MediaInterface::MEDIA_ORIGINAL;
        $attributes['width'] = '';

        return $attributes;
    }

    /**
     * @param string $blockType
     * @param string $id
     *
     * @return Block
     */
    protected function generateBlock($blockType)
    {
        $block = new Block();
        $block->setComponent($blockType);

        static::$kernel->getContainer()->get('object_manager')->persist($block);
        static::$kernel->getContainer()->get('object_manager')->flush();

        return $block;
    }
}
