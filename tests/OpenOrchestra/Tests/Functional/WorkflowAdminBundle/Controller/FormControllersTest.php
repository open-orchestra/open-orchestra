<?php

namespace OpenOrchestra\FunctionalTests\WorkflowAdminBundle\Controller;

use OpenOrchestra\FunctionalTests\Utils\AbstractFormTest;
use OpenOrchestra\ModelInterface\Repository\WorkflowProfileRepositoryInterface;

/**
 * Class FormControllersTest
 *
 * @group backofficeTest
 */
class FormControllersTest extends AbstractFormTest
{
    protected $username = 'developer';
    protected $password = 'developer';

    /**
     * @var WorkflowProfileRepositoryInterface
     */
    protected $workflowProfileRepository;

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();
        $this->workflowProfileRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.workflow_profile');
    }

    /**
     * @param string $url
     *
     * @dataProvider provideApiUrl
     */
    public function testForm($url)
    {
        $this->client->request('GET', $url);

        $this->assertForm($this->client->getResponse());
    }

    /**
     * @return array
     */
    public function provideApiUrl()
    {
        return array(
            0 => array('/admin/workflow-profile/new'),
            1 => array('/admin/workflow-parameters/form'),
        );
    }

    public function testEditForm()
    {
        $workflowProfile = $this->workflowProfileRepository->findOneBy(array('labels.en' => 'Validator'));
        $this->testForm('/admin/workflow-profile/form/'.$workflowProfile->getId());
    }
}
