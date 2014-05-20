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
                'alias' => array(
                    'type' => 'string',
                    'dbName' => 'alias',
                ),
                'defaultLanguage' => array(
                    'type' => 'string',
                    'dbName' => 'defaultLanguage',
                ),
                'languages' => array(
                    'type' => 'string',
                    'dbName' => 'languages',
                ),
                'blocks' => array(
                    'type' => 'string',
                    'dbName' => 'blocks',
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
                    'type' => 'string',
                    'dbName' => 'nodeId',
                ),
                'nodeType' => array(
                    'type' => 'string',
                    'dbName' => 'nodeType',
                ),
                'siteId' => array(
                    'type' => 'integer',
                    'dbName' => 'siteId',
                ),
                'parentId' => array(
                    'type' => 'string',
                    'dbName' => 'parentId',
                ),
                'path' => array(
                    'type' => 'string',
                    'dbName' => 'path',
                ),
                'alias' => array(
                    'type' => 'string',
                    'dbName' => 'alias',
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
                'deleted' => array(
                    'type' => 'boolean',
                    'dbName' => 'deleted',
                ),
                'templateId' => array(
                    'type' => 'string',
                    'dbName' => 'templateId',
                ),
                'theme' => array(
                    'type' => 'string',
                    'dbName' => 'theme',
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
                    'type' => 'string',
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
                'deleted' => array(
                    'type' => 'boolean',
                    'dbName' => 'deleted',
                ),
                'areas' => array(
                    'type' => 'raw',
                    'dbName' => 'areas',
                ),
                'boDirection' => array(
                    'type' => 'string',
                    'dbName' => 'boDirection',
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

    public function getModelPHPOrchestraCMSBundleContentAttributeClass()
    {
        return array(
            'isEmbedded' => true,
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
                'value' => array(
                    'type' => 'string',
                    'dbName' => 'value',
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
                'contentType' => array(
                    'type' => 'string',
                    'dbName' => 'contentType',
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
                'shortName' => array(
                    'type' => 'string',
                    'dbName' => 'shortName',
                ),
                'contentTypeVersion' => array(
                    'type' => 'integer',
                    'dbName' => 'contentTypeVersion',
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
                'attributes' => array(
                    'class' => 'Model\\PHPOrchestraCMSBundle\\ContentAttribute',
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

    public function getModelPHPOrchestraCMSBundleContentFieldClass()
    {
        return array(
            'isEmbedded' => true,
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
                'type' => array(
                    'type' => 'string',
                    'dbName' => 'type',
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

    public function getModelPHPOrchestraCMSBundleContentTypeClass()
    {
        return array(
            'isEmbedded' => false,
            'mandango' => null,
            'connection' => '',
            'collection' => 'contentType',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'contentType' => array(
                    'type' => 'string',
                    'dbName' => 'contentType',
                ),
                'version' => array(
                    'type' => 'integer',
                    'dbName' => 'version',
                ),
                'deleted' => array(
                    'type' => 'boolean',
                    'dbName' => 'deleted',
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
                'fields' => array(
                    'class' => 'Model\\PHPOrchestraCMSBundle\\ContentField',
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
