<?php

namespace Model\Mapping;

class MetadataFactoryInfo
{
    public function getModelPHPOrchestraCMSBundleSiteClass()
    {
        return array(
            'isEmbedded' => false,
            'mandango' => null,
            'connection' => '',
            'collection' => 'site',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'siteId' => array(
                    'type' => 'integer',
                    'dbName' => 'siteId',
                ),
                'domain' => array(
                    'type' => 'string',
                    'dbName' => 'domain',
                ),
                'language' => array(
                    'type' => 'string',
                    'dbName' => 'language',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
        );
    }

    public function getModelPHPOrchestraCMSBundleBlockClass()
    {
        return array(
            'isEmbedded' => true,
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'component' => array(
                    'type' => 'string',
                    'dbName' => 'component',
                ),
                'attributes' => array(
                    'type' => 'raw',
                    'dbName' => 'attributes',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
        );
    }

    public function getModelPHPOrchestraCMSBundleNodeClass()
    {
        return array(
            'isEmbedded' => false,
            'mandango' => null,
            'connection' => '',
            'collection' => 'node',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'nodeId' => array(
                    'type' => 'integer',
                    'dbName' => 'nodeId',
                ),
                'siteId' => array(
                    'type' => 'integer',
                    'dbName' => 'siteId',
                ),
                'parentId' => array(
                    'type' => 'integer',
                    'dbName' => 'parentId',
                ),
                'path' => array(
                    'type' => 'string',
                    'dbName' => 'path',
                ),
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
                'version' => array(
                    'type' => 'integer',
                    'dbName' => 'version',
                ),
                'language' => array(
                    'type' => 'string',
                    'dbName' => 'language',
                ),
                'status' => array(
                    'type' => 'string',
                    'dbName' => 'status',
                ),
                'templateId' => array(
                    'type' => 'integer',
                    'dbName' => 'templateId',
                ),
                'areas' => array(
                    'type' => 'raw',
                    'dbName' => 'areas',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(
                'blocks' => array(
                    'class' => 'Model\\PHPOrchestraCMSBundle\\Block',
                ),
            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
        );
    }

    public function getModelPHPOrchestraCMSBundleTemplateClass()
    {
        return array(
            'isEmbedded' => false,
            'mandango' => null,
            'connection' => '',
            'collection' => 'template',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'templateId' => array(
                    'type' => 'integer',
                    'dbName' => 'templateId',
                ),
                'siteId' => array(
                    'type' => 'integer',
                    'dbName' => 'siteId',
                ),
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
                'version' => array(
                    'type' => 'integer',
                    'dbName' => 'version',
                ),
                'language' => array(
                    'type' => 'string',
                    'dbName' => 'language',
                ),
                'status' => array(
                    'type' => 'string',
                    'dbName' => 'status',
                ),
                'areas' => array(
                    'type' => 'raw',
                    'dbName' => 'areas',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(
                'blocks' => array(
                    'class' => 'Model\\PHPOrchestraCMSBundle\\Block',
                ),
            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
        );
    }

    public function getModelPHPOrchestraCMSBundleContentClass()
    {
        return array(
            'isEmbedded' => false,
            'mandango' => null,
            'connection' => '',
            'collection' => 'content',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'contentId' => array(
                    'type' => 'integer',
                    'dbName' => 'contentId',
                ),
                'type' => array(
                    'type' => 'string',
                    'dbName' => 'type',
                ),
                'version' => array(
                    'type' => 'integer',
                    'dbName' => 'version',
                ),
                'status' => array(
                    'type' => 'string',
                    'dbName' => 'status',
                ),
                'attributes' => array(
                    'type' => 'raw',
                    'dbName' => 'attributes',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
        );
    }

    public function getModelPHPOrchestraCMSBundleUserClass()
    {
        return array(
            'isEmbedded' => false,
            'mandango' => null,
            'connection' => '',
            'collection' => 'user',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'login' => array(
                    'type' => 'string',
                    'dbName' => 'login',
                ),
                'hash' => array(
                    'type' => 'string',
                    'dbName' => 'hash',
                ),
                'salt' => array(
                    'type' => 'string',
                    'dbName' => 'salt',
                ),
                'firstName' => array(
                    'type' => 'string',
                    'dbName' => 'firstName',
                ),
                'lastName' => array(
                    'type' => 'string',
                    'dbName' => 'lastName',
                ),
                'email' => array(
                    'type' => 'string',
                    'dbName' => 'email',
                ),
                'addresses' => array(
                    'type' => 'string',
                    'dbName' => 'addresses',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
        );
    }
}