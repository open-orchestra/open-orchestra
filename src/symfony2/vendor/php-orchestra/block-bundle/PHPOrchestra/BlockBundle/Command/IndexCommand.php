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
            
        if ($input->getOption('all')) {
            //indexation
            $repositoryNode = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node');
            $nodes = $repositoryNode->getAllNodes();
            $repositoryContent = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Content');
            $contents = $repositoryContent->getAllContents();
            
            $resultNode = $container->get('phporchestra_cms.indexsolr')->slpitDoc($nodes, 'Node');
            $resultContent = $container->get('phporchestra_cms.indexsolr')->slpitDoc($contents, 'Content');
            
            $output->writeln($container->get('translator')->trans('All the documents are indexed'));

        } elseif ($input->getOption('remove')) {
            $client = $container->get('solarium.client');
            //get an update query instance
            $update = $client->createUpdate();
            
            $update->addDeleteQuery('*:*');
            $update->addCommit();
            
            //this execute the query and return the result
            $result = $client->update($update);
            
            $output->writeln($container->get('translator')->trans('All the documents are removed from the index'));

        } else {
            // Take a list of identifiant to index it
            $repositoryListIndex = $mandango->getRepository('Model\PHPOrchestraCMSBundle\ListIndex');
                        
            $listIndex = $repositoryListIndex->getAll();
            
            if (!empty($listIndex) && is_array($listIndex)) {
                $repositoryNode = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node');
                $repositoryContent = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Content');
                
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
                    $resultNode = $container->get('phporchestra_cms.indexsolr')->slpitDoc($nodes, 'Node');
                }

                if (is_array($contents) && !empty($contents)) {
                    $resultContent = $container->get('phporchestra_cms.indexsolr')->slpitDoc($contents, 'Content');
                }
                
                $output->writeln($container->get('translator')->trans('The List of documents is indexed'));
            } else {
                $output->writeln($container->get('translator')->trans('The list of documents is empty!'));
            }
        }
    }
}
