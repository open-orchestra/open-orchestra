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
                'site_id' => array(
                    'type' => 'integer',
                    'dbName' => 'site_id',
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
                'node_id' => array(
                    'type' => 'integer',
                    'dbName' => 'node_id',
                ),
                'site_id' => array(
                    'type' => 'integer',
                    'dbName' => 'site_id',
                ),
                'parent_id' => array(
                    'type' => 'integer',
                    'dbName' => 'parent_id',
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
                'template_id' => array(
                    'type' => 'integer',
                    'dbName' => 'template_id',
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
                'content_id' => array(
                    'type' => 'integer',
                    'dbName' => 'content_id',
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
                'first_name' => array(
                    'type' => 'string',
                    'dbName' => 'first_name',
                ),
                'last_name' => array(
                    'type' => 'string',
                    'dbName' => 'last_name',
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