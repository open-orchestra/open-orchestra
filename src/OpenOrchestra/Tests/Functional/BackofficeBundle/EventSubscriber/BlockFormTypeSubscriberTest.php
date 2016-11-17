<?php

namespace OpenOrchestra\FunctionalTests\BackofficeBundle\EventSubscriber;

use OpenOrchestra\FunctionalTests\Utils\AbstractAuthenticatedTest;
use OpenOrchestra\DisplayBundle\DisplayBlock\Strategies\ConfigurableContentStrategy;
use OpenOrchestra\DisplayBundle\DisplayBlock\Strategies\ContentListStrategy;
use OpenOrchestra\DisplayBundle\DisplayBlock\Strategies\VideoStrategy;
use OpenOrchestra\ModelBundle\Document\Block;
use OpenOrchestra\ModelInterface\Model\BlockInterface;
use Symfony\Component\Form\FormFactoryInterface;
use OpenOrchestra\ModelInterface\Repository\ReadContentRepositoryInterface;
use OpenOrchestra\ModelInterface\Repository\RepositoryTrait\KeywordableTraitInterface;

/**
 * Class BlockFormTypeSubscriberTest
 *
 * @group backofficeTest
 */
class BlockFormTypeSubscriberTest extends AbstractAuthenticatedTest
{
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;
    protected $keywords;
    protected $keywordRepository;

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();
        $this->keywordRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.keyword');
        $this->formFactory = static::$kernel->getContainer()->get('form.factory');
    }

    /**
     * Test video block : checkbox unique to uncheck
     */
    public function testVideoBlock()
    {
        $block = new Block();
        $block->setComponent(VideoStrategy::NAME);
        $block->addAttribute('videoType', 'youtube');
        $block->addAttribute('youtubeFs', true);
        $formType =  static::$kernel->getContainer()->get('open_orchestra_backoffice.generate_form_manager')->getFormType($block);
        $form = $this->formFactory->create($formType, $block, array('csrf_protection' => false));

         $form->submit(array(
             'style' => 'default',
             'videoType' => 'youtube',
             'youtubeVideoId' => 'videoId',
             'youtubeAutoplay' => true,
         ));

         $this->assertTrue($form->isSynchronized());
         /** @var BlockInterface $data */
         $data = $form->getConfig()->getData();
         $this->assertBlock($data);
         $this->assertSame('videoId', $data->getAttribute('youtubeVideoId'));
         $this->assertTrue($data->getAttribute('youtubeAutoplay'));
         $this->assertFalse($data->getAttribute('youtubeFs'));
    }

    /**
     * @param string $component
     * @param array  $value
     *
     * @dataProvider provideComponentAndData
     */
    public function testMultipleBlock($component, $value)
    {
        $block = new Block();
        $block->setComponent($component);
        $formType =  static::$kernel->getContainer()->get('open_orchestra_backoffice.generate_form_manager')->getFormType($block);

        $form = $this->formFactory->create($formType, $block, array('csrf_protection' => false));

        $submittedValue = array_merge(array('style' => 'default'), $value);
        $form->submit($submittedValue);

        $this->assertTrue($form->isSynchronized());
        /** @var BlockInterface $data */
        $data = $form->getConfig()->getData();
        $this->assertBlock($data);
        foreach ($value as $key => $sendData) {
            $this->assertSame($sendData, $data->getAttribute($key));
        }
    }

    /**
     * @return array
     */
    public function provideComponentAndData()
    {
        return array(
            array(ContentListStrategy::NAME, array(
                'contentNodeId' => 'root',
                'contentSearch' => array(
                  'contentType' => 'news',
                  'choiceType' => 'choice_and',
                  'keywords' => null,
                ),
                'characterNumber' => 150,
                'contentTemplateEnabled' => true,
            )),
            array(ConfigurableContentStrategy::NAME, array(
                'contentSearch' => array(
                    'contentType' => 'car',
                    'choiceType' => ReadContentRepositoryInterface::CHOICE_AND,
                    'keywords' => null,
                    'contentId' => null,
                ),
                'contentTemplateEnabled' => true,
            ))
        );
    }

    /**
     * @param string $component
     * @param array  $value
     *
     * @dataProvider provideComponentAndDataAndTransformedValue
     */
    public function testMultipleBlockWithDataTransformation($component, $value)
    {
        $block = new Block();
        $block->setComponent($component);
        $formType =  static::$kernel->getContainer()->get('open_orchestra_backoffice.generate_form_manager')->getFormType($block);

        $form = $this->formFactory->create($formType, $block, array('csrf_protection' => false));
        $submittedValue = array_merge(array('style' => 'default'), $value);
        $value['contentSearch']['keywords'] = $this->replaceKeywordLabelById($value['contentSearch']['keywords']);
        $form->submit($submittedValue);

        $this->assertTrue($form->isSynchronized());
        /** @var BlockInterface $data */
        $data = $form->getConfig()->getData();
        $this->assertBlock($data);
        foreach ($value as $key => $receivedData) {
            $this->assertSame($receivedData, $data->getAttribute($key));
        }
    }

    /**
     * @return array
     */
    public function provideComponentAndDataAndTransformedValue()
    {
        return array(
            array(ContentListStrategy::NAME, array(
                'contentNodeId' => 'root',
                'contentTemplateEnabled' => true,
                'characterNumber' => 150,
                'contentSearch' => array(
                    'contentType' => 'news',
                    'choiceType' => ReadContentRepositoryInterface::CHOICE_AND,
                    'keywords' => 'lorem AND ipsum',
                    )
            )),
        );
    }

    /**
     * @param $data
     */
    protected function assertBlock($data)
    {
        $this->assertInstanceOf('OpenOrchestra\ModelInterface\Model\BlockInterface', $data);
        $this->assertSame('default', $data->getStyle());
    }

    /**
     * @param string $condition
     *
     * @return array
     */
    protected function replaceKeywordLabelById($condition)
    {
        $conditionWithoutOperator = preg_replace(explode('|', KeywordableTraitInterface::OPERATOR_SPLIT), ' ', $condition);
        $conditionArray = explode(' ', $conditionWithoutOperator);

        foreach ($conditionArray as $keyword) {
            if ($keyword != '') {
                $keywordDocument = $this->keywordRepository->findOneByLabel($keyword);
                if (!is_null($keywordDocument)) {
                    $condition = str_replace($keyword, $keywordDocument->getId(), $condition);
                } else {
                    return '';
                }
            }
        }

        return $condition;
    }
}
