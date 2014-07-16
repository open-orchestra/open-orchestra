<?php

/*
 * Business & Decision - Commercial License
 *
 * Copyright 2014 Business & Decision.
 *
 * All rights reserved. You CANNOT use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell this Software or any parts of this
 * Software, without the written authorization of Business & Decision.
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * See LICENSE.txt file for the full LICENSE text.
 */

namespace PHPOrchestra\BlockBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use PHPOrchestra\BlockBundle\IndexCommand\SolrIndexCommand;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use PHPOrchestra\CMSBundle\Model\ListIndex;
use PHPOrchestra\CMSBundle\Model\ListIndexRepository;

/**
 * Command to index in solr
 * 
 * @author benjamin fouché <benjamin.fouche@businessdecision.com>
 *
 */
class IndexCommand extends ContainerAwareCommand
{
    
    /**
     * Configure the command
     * 
     * @see \Symfony\Component\Console\Command\Command::configure()
     */
    protected function configure()
    {
        $this
            ->setName('solr:index')
            ->setDescription('Indexing in Solr')
            ->addOption(
                'all',
                null,
                InputOption::VALUE_NONE,
                'if defined all the documents will be index.'
            )
            ->addOption(
                'remove',
                null,
                InputOption::VALUE_NONE,
                'if defined remove all the documents.'
            );
    }


    /**
     * Execute the command
     * 
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
    
        $mandango = $container->get('mandango');
        
        $softindex = $container->get('phporchestra_cms.indexHelper');

        if ($softindex->getSolr()) {
            
            $index = $container->get('phporchestra_cms.indexsolr');
            
            if ($index->solrIsRunning()) {
                
                $repositoryNode = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node');
                $repositoryContent = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Content');
                
                if ($input->getOption('all')) {
                    // indexation of all documents
                    $this->indexAll($repositoryNode, $repositoryContent, $index);
                    $output->writeln($container->get('translator')->trans('All the documents are indexed'));
            
                } elseif ($input->getOption('remove')) {
                    $client = $container->get('solarium.client');
                    $this->removeIndex($client);
            
                    $output->writeln(
                        $container->get('translator')->trans('All the documents are removed from the index')
                    );
            
                } else {
                    // Take a list of identifiant to index it
                    $repositoryListIndex = $mandango->getRepository('Model\PHPOrchestraCMSBundle\ListIndex');
            
                    $listIndex = $repositoryListIndex->getAll();
            
                    if (!empty($listIndex) && is_array($listIndex)) {
                        $this->indexList($repositoryNode, $repositoryContent, $listIndex, $repositoryListIndex, $index);
                        $output->writeln($container->get('translator')->trans('The List of documents is indexed'));
            
                    } else {
                        $output->writeln($container->get('translator')->trans('The list of documents is empty!'));
                    }
                }
            } else {
                $output->writeln($container->get('translator')->trans('Solr is not running!'));
            }
        }
        if ($softindex->getElasticSearch()) {
            $output->writeln('Nous n\'avons pas encore elasticsearch');
        }
    }


    /**
     * Index all the documents
     * 
     * @param NodeRepository $repositoryNode
     * @param ContentRepository $repositoryContent
     * @param indexSolr $index service
     */
    public function indexAll($repositoryNode, $repositoryContent, $index)
    {
        $nodes = $repositoryNode->getAllNodes();
        $contents = $repositoryContent->getAllToIndex();
        
        $resultNode = $index->slpitDoc($nodes, 'Node');
        $resultContent = $index->slpitDoc($contents, 'Content');
    }


    /**
     * Index a list of documents
     * 
     * @param NodeRepository $repositoryNode
     * @param ContentRepository $repositoryContent
     * @param ListIndex $listIndex
     * @param ListIndexRepository $repositoryListIndex
     * @param indexSolr $indexSolr service
     */
    public function indexList($repositoryNode, $repositoryContent, $listIndex, $repositoryListIndex, $indexSolr)
    {
        $nodes = array();
        $contents = array();
        
        foreach ($listIndex as $index) {
            $nodeId = $index->getNodeId();
        
            if (isset($nodeId)) {
                $nodes[] = $repositoryNode->getOne($nodeId);
                // Remove from mandango
                $repositoryListIndex->delete($index);
            } else {
                $contentId = $index->getContentId();
                $contents[] = $repositoryContent->getOne($contentId);
                //Remove from mandango
                $repositoryListIndex->delete($index);
            }
        }
        
        if (is_array($nodes) && !empty($nodes)) {
            $resultNode = $indexSolr->slpitDoc($nodes, 'Node');
        }

        if (is_array($contents) && !empty($contents)) {
            $resultContent = $indexSolr->slpitDoc($contents, 'Content');
        }
    }


    /**
     * Remove the solr index
     * 
     * @param Solarium/Client $client
     */
    public function removeIndex($client)
    {
        //get an update query instance
        $update = $client->createUpdate();
        
        $update->addDeleteQuery('*:*');
        $update->addCommit();
        
        //this execute the query and return the result
        $result = $client->update($update);
    }
}
