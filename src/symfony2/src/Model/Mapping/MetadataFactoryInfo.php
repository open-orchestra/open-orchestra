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
            'collection' => 'model_phporchestracmsbundle_site',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
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

    public function getModelPHPOrchestraCMSBundleNodeClass()
    {
        return array(
            'isEmbedded' => false,
            'mandango' => null,
            'connection' => '',
            'collection' => 'model_phporchestracmsbundle_node',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
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
                'blocks' => array(
                    'type' => 'string',
                    'dbName' => 'blocks',
                ),
                'area' => array(
                    'type' => 'string',
                    'dbName' => 'area',
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

    public function getModelPHPOrchestraCMSBundleContentClass()
    {
        return array(
            'isEmbedded' => false,
            'mandango' => null,
            'connection' => '',
            'collection' => 'model_phporchestracmsbundle_content',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
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
                    'type' => 'string',
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
            'collection' => 'model_phporchestracmsbundle_user',
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