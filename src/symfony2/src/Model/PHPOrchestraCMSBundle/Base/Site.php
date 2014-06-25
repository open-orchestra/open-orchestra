<?php

namespace Model\PHPOrchestraCMSBundle\Base;

/**
 * Base class of Model\PHPOrchestraCMSBundle\Site document.
 */
abstract class Site extends \Mandango\Document\Document
{
    /**
     * Initializes the document defaults.
     */
    public function initializeDefaults()
    {
    }

    /**
     * Set the document data (hydrate).
     *
     * @param array $data  The document data.
     * @param bool  $clean Whether clean the document.
     *
     * @return \Model\PHPOrchestraCMSBundle\Site The document (fluent interface).
     */
    public function setDocumentData($data, $clean = false)
    {
        if ($clean) {
            $this->data = array();
            $this->fieldsModified = array();
        }

        if (isset($data['_query_hash'])) {
            $this->addQueryHash($data['_query_hash']);
        }
        if (isset($data['_id'])) {
            $this->setId($data['_id']);
            $this->setIsNew(false);
        }
        if (isset($data['siteId'])) {
            $this->data['fields']['siteId'] = (int) $data['siteId'];
        } elseif (isset($data['_fields']['siteId'])) {
            $this->data['fields']['siteId'] = null;
        }
        if (isset($data['domain'])) {
            $this->data['fields']['domain'] = (string) $data['domain'];
        } elseif (isset($data['_fields']['domain'])) {
            $this->data['fields']['domain'] = null;
        }
        if (isset($data['alias'])) {
            $this->data['fields']['alias'] = (string) $data['alias'];
        } elseif (isset($data['_fields']['alias'])) {
            $this->data['fields']['alias'] = null;
        }
        if (isset($data['defaultLanguage'])) {
            $this->data['fields']['defaultLanguage'] = (string) $data['defaultLanguage'];
        } elseif (isset($data['_fields']['defaultLanguage'])) {
            $this->data['fields']['defaultLanguage'] = null;
        }
        if (isset($data['languages'])) {
            $this->data['fields']['languages'] = (string) $data['languages'];
        } elseif (isset($data['_fields']['languages'])) {
            $this->data['fields']['languages'] = null;
        }
        if (isset($data['blocks'])) {
            $this->data['fields']['blocks'] = (string) $data['blocks'];
        } elseif (isset($data['_fields']['blocks'])) {
            $this->data['fields']['blocks'] = null;
        }

        return $this;
    }

    /**
     * Set the "siteId" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Site The document (fluent interface).
     */
    public function setSiteId($value)
    {
        if (!isset($this->data['fields']['siteId'])) {
            if (!$this->isNew()) {
                $this->getSiteId();
                if ($this->isFieldEqualTo('siteId', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['siteId'] = null;
                $this->data['fields']['siteId'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('siteId', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['siteId']) && !array_key_exists('siteId', $this->fieldsModified)) {
            $this->fieldsModified['siteId'] = $this->data['fields']['siteId'];
        } elseif ($this->isFieldModifiedEqualTo('siteId', $value)) {
            unset($this->fieldsModified['siteId']);
        }

        $this->data['fields']['siteId'] = $value;

        return $this;
    }

    /**
     * Returns the "siteId" field.
     *
     * @return mixed The $name field.
     */
    public function getSiteId()
    {
        if (!isset($this->data['fields']['siteId'])) {
            if ($this->isNew()) {
                $this->data['fields']['siteId'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('siteId', $this->data['fields'])) {
                $this->addFieldCache('siteId');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('siteId' => 1)
                );
                if (isset($data['siteId'])) {
                    $this->data['fields']['siteId'] = (int) $data['siteId'];
                } else {
                    $this->data['fields']['siteId'] = null;
                }
            }
        }

        return $this->data['fields']['siteId'];
    }

    /**
     * Set the "domain" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Site The document (fluent interface).
     */
    public function setDomain($value)
    {
        if (!isset($this->data['fields']['domain'])) {
            if (!$this->isNew()) {
                $this->getDomain();
                if ($this->isFieldEqualTo('domain', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['domain'] = null;
                $this->data['fields']['domain'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('domain', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['domain']) && !array_key_exists('domain', $this->fieldsModified)) {
            $this->fieldsModified['domain'] = $this->data['fields']['domain'];
        } elseif ($this->isFieldModifiedEqualTo('domain', $value)) {
            unset($this->fieldsModified['domain']);
        }

        $this->data['fields']['domain'] = $value;

        return $this;
    }

    /**
     * Returns the "domain" field.
     *
     * @return mixed The $name field.
     */
    public function getDomain()
    {
        if (!isset($this->data['fields']['domain'])) {
            if ($this->isNew()) {
                $this->data['fields']['domain'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('domain', $this->data['fields'])) {
                $this->addFieldCache('domain');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('domain' => 1)
                );
                if (isset($data['domain'])) {
                    $this->data['fields']['domain'] = (string) $data['domain'];
                } else {
                    $this->data['fields']['domain'] = null;
                }
            }
        }

        return $this->data['fields']['domain'];
    }

    /**
     * Set the "alias" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Site The document (fluent interface).
     */
    public function setAlias($value)
    {
        if (!isset($this->data['fields']['alias'])) {
            if (!$this->isNew()) {
                $this->getAlias();
                if ($this->isFieldEqualTo('alias', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['alias'] = null;
                $this->data['fields']['alias'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('alias', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['alias']) && !array_key_exists('alias', $this->fieldsModified)) {
            $this->fieldsModified['alias'] = $this->data['fields']['alias'];
        } elseif ($this->isFieldModifiedEqualTo('alias', $value)) {
            unset($this->fieldsModified['alias']);
        }

        $this->data['fields']['alias'] = $value;

        return $this;
    }

    /**
     * Returns the "alias" field.
     *
     * @return mixed The $name field.
     */
    public function getAlias()
    {
        if (!isset($this->data['fields']['alias'])) {
            if ($this->isNew()) {
                $this->data['fields']['alias'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('alias', $this->data['fields'])) {
                $this->addFieldCache('alias');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('alias' => 1)
                );
                if (isset($data['alias'])) {
                    $this->data['fields']['alias'] = (string) $data['alias'];
                } else {
                    $this->data['fields']['alias'] = null;
                }
            }
        }

        return $this->data['fields']['alias'];
    }

    /**
     * Set the "defaultLanguage" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Site The document (fluent interface).
     */
    public function setDefaultLanguage($value)
    {
        if (!isset($this->data['fields']['defaultLanguage'])) {
            if (!$this->isNew()) {
                $this->getDefaultLanguage();
                if ($this->isFieldEqualTo('defaultLanguage', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['defaultLanguage'] = null;
                $this->data['fields']['defaultLanguage'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('defaultLanguage', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['defaultLanguage']) && !array_key_exists('defaultLanguage', $this->fieldsModified)) {
            $this->fieldsModified['defaultLanguage'] = $this->data['fields']['defaultLanguage'];
        } elseif ($this->isFieldModifiedEqualTo('defaultLanguage', $value)) {
            unset($this->fieldsModified['defaultLanguage']);
        }

        $this->data['fields']['defaultLanguage'] = $value;

        return $this;
    }

    /**
     * Returns the "defaultLanguage" field.
     *
     * @return mixed The $name field.
     */
    public function getDefaultLanguage()
    {
        if (!isset($this->data['fields']['defaultLanguage'])) {
            if ($this->isNew()) {
                $this->data['fields']['defaultLanguage'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('defaultLanguage', $this->data['fields'])) {
                $this->addFieldCache('defaultLanguage');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('defaultLanguage' => 1)
                );
                if (isset($data['defaultLanguage'])) {
                    $this->data['fields']['defaultLanguage'] = (string) $data['defaultLanguage'];
                } else {
                    $this->data['fields']['defaultLanguage'] = null;
                }
            }
        }

        return $this->data['fields']['defaultLanguage'];
    }

    /**
     * Set the "languages" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Site The document (fluent interface).
     */
    public function setLanguages($value)
    {
        if (!isset($this->data['fields']['languages'])) {
            if (!$this->isNew()) {
                $this->getLanguages();
                if ($this->isFieldEqualTo('languages', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['languages'] = null;
                $this->data['fields']['languages'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('languages', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['languages']) && !array_key_exists('languages', $this->fieldsModified)) {
            $this->fieldsModified['languages'] = $this->data['fields']['languages'];
        } elseif ($this->isFieldModifiedEqualTo('languages', $value)) {
            unset($this->fieldsModified['languages']);
        }

        $this->data['fields']['languages'] = $value;

        return $this;
    }

    /**
     * Returns the "languages" field.
     *
     * @return mixed The $name field.
     */
    public function getLanguages()
    {
        if (!isset($this->data['fields']['languages'])) {
            if ($this->isNew()) {
                $this->data['fields']['languages'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('languages', $this->data['fields'])) {
                $this->addFieldCache('languages');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('languages' => 1)
                );
                if (isset($data['languages'])) {
                    $this->data['fields']['languages'] = (string) $data['languages'];
                } else {
                    $this->data['fields']['languages'] = null;
                }
            }
        }

        return $this->data['fields']['languages'];
    }

    /**
     * Set the "blocks" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Site The document (fluent interface).
     */
    public function setBlocks($value)
    {
    	
    	
        if (!isset($this->data['fields']['blocks'])) {
            if (!$this->isNew()) {
                $this->getBlocks();
                if ($this->isFieldEqualTo('blocks', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['blocks'] = null;
                $this->data['fields']['blocks'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('blocks', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['blocks']) && !array_key_exists('blocks', $this->fieldsModified)) {
            $this->fieldsModified['blocks'] = $this->data['fields']['blocks'];
        } elseif ($this->isFieldModifiedEqualTo('blocks', $value)) {
            unset($this->fieldsModified['blocks']);
        }

        $this->data['fields']['blocks'] = $value;
//var_dump($this->getBlocks());
        return $this;
    }

    /**
     * Returns the "blocks" field.
     *
     * @return mixed The $name field.
     */
    public function getBlocks()
    {
        if (!isset($this->data['fields']['blocks'])) {
            if ($this->isNew()) {
                $this->data['fields']['blocks'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('blocks', $this->data['fields'])) {
                $this->addFieldCache('blocks');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('blocks' => 1)
                );
                if (isset($data['blocks'])) {
                    $this->data['fields']['blocks'] = (string) $data['blocks'];
                } else {
                    $this->data['fields']['blocks'] = null;
                }
            }
        }

        return $this->data['fields']['blocks'];
    }

    private function isFieldEqualTo($field, $otherValue)
    {
        $value = $this->data['fields'][$field];

        return $this->isFieldValueEqualTo($value, $otherValue);
    }

    private function isFieldModifiedEqualTo($field, $otherValue)
    {
        $value = $this->fieldsModified[$field];

        return $this->isFieldValueEqualTo($value, $otherValue);
    }

    protected function isFieldValueEqualTo($value, $otherValue)
    {
        if (is_object($value)) {
            return $value == $otherValue;
        }

        return $value === $otherValue;
    }

    /**
     * Process onDelete.
     */
    public function processOnDelete()
    {
    }

    private function processOnDeleteCascade($class, array $criteria)
    {
        $repository = $this->getMandango()->getRepository($class);
        $documents = $repository->createQuery($criteria)->all();
        if (count($documents)) {
            $repository->delete($documents);
        }
    }

    private function processOnDeleteUnset($class, array $criteria, array $update)
    {
        $this->getMandango()->getRepository($class)->update($criteria, $update, array('multiple' => true));
    }

    /**
     * Set a document data value by data name as string.
     *
     * @param string $name  The data name.
     * @param mixed  $value The value.
     *
     * @return mixed the data name setter return value.
     *
     * @throws \InvalidArgumentException If the data name is not valid.
     */
    public function set($name, $value)
    {
        if ('siteId' == $name) {
            return $this->setSiteId($value);
        }
        if ('domain' == $name) {
            return $this->setDomain($value);
        }
        if ('alias' == $name) {
            return $this->setAlias($value);
        }
        if ('defaultLanguage' == $name) {
            return $this->setDefaultLanguage($value);
        }
        if ('languages' == $name) {
            return $this->setLanguages($value);
        }
        if ('blocks' == $name) {
            return $this->setBlocks($value);
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Returns a document data by data name as string.
     *
     * @param string $name The data name.
     *
     * @return mixed The data name getter return value.
     *
     * @throws \InvalidArgumentException If the data name is not valid.
     */
    public function get($name)
    {
        if ('siteId' == $name) {
            return $this->getSiteId();
        }
        if ('domain' == $name) {
            return $this->getDomain();
        }
        if ('alias' == $name) {
            return $this->getAlias();
        }
        if ('defaultLanguage' == $name) {
            return $this->getDefaultLanguage();
        }
        if ('languages' == $name) {
            return $this->getLanguages();
        }
        if ('blocks' == $name) {
            return $this->getBlocks();
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Model\PHPOrchestraCMSBundle\Site The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['id'])) {
            $this->setId($array['id']);
        }
        if (isset($array['siteId'])) {
            $this->setSiteId($array['siteId']);
        }
        if (isset($array['domain'])) {
            $this->setDomain($array['domain']);
        }
        if (isset($array['alias'])) {
            $this->setAlias($array['alias']);
        }
        if (isset($array['defaultLanguage'])) {
            $this->setDefaultLanguage($array['defaultLanguage']);
        }
        if (isset($array['languages'])) {
            $this->setLanguages($array['languages']);
        }
        if (isset($array['blocks'])) {
            $this->setBlocks($array['blocks']);
        }

        return $this;
    }

    /**
     * Export the document data to an array.
     *
     * @param Boolean $withReferenceFields Whether include the fields of references or not (false by default).
     *
     * @return array An array with the document data.
     */
    public function toArray($withReferenceFields = false)
    {
        $array = array('id' => $this->getId());

        $array['siteId'] = $this->getSiteId();
        $array['domain'] = $this->getDomain();
        $array['alias'] = $this->getAlias();
        $array['defaultLanguage'] = $this->getDefaultLanguage();
        $array['languages'] = $this->getLanguages();
        $array['blocks'] = $this->getBlocks();

        return $array;
    }

    /**
     * Query for save.
     */
    public function queryForSave()
    {
        $isNew = $this->isNew();
        $query = array();
        $reset = false;

        if (isset($this->data['fields'])) {
            if ($isNew || $reset) {
                if (isset($this->data['fields']['siteId'])) {
                    $query['siteId'] = (int) $this->data['fields']['siteId'];
                }
                if (isset($this->data['fields']['domain'])) {
                    $query['domain'] = (string) $this->data['fields']['domain'];
                }
                if (isset($this->data['fields']['alias'])) {
                    $query['alias'] = (string) $this->data['fields']['alias'];
                }
                if (isset($this->data['fields']['defaultLanguage'])) {
                    $query['defaultLanguage'] = (string) $this->data['fields']['defaultLanguage'];
                }
                if (isset($this->data['fields']['languages'])) {
                    $query['languages'] = (string) $this->data['fields']['languages'];
                }
                if (isset($this->data['fields']['blocks'])) {
                    $query['blocks'] = (string) $this->data['fields']['blocks'];
                }
            } else {
                if (isset($this->data['fields']['siteId'])
                    || array_key_exists('siteId', $this->data['fields'])) {
                    $value = $this->data['fields']['siteId'];
                    $originalValue = $this->getOriginalFieldValue('siteId');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['siteId'] = (int) $this->data['fields']['siteId'];
                        } else {
                            $query['$unset']['siteId'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['domain'])
                    || array_key_exists('domain', $this->data['fields'])) {
                    $value = $this->data['fields']['domain'];
                    $originalValue = $this->getOriginalFieldValue('domain');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['domain'] = (string) $this->data['fields']['domain'];
                        } else {
                            $query['$unset']['domain'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['alias'])
                    || array_key_exists('alias', $this->data['fields'])) {
                    $value = $this->data['fields']['alias'];
                    $originalValue = $this->getOriginalFieldValue('alias');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['alias'] = (string) $this->data['fields']['alias'];
                        } else {
                            $query['$unset']['alias'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['defaultLanguage'])
                    || array_key_exists('defaultLanguage', $this->data['fields'])) {
                    $value = $this->data['fields']['defaultLanguage'];
                    $originalValue = $this->getOriginalFieldValue('defaultLanguage');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['defaultLanguage'] = (string) $this->data['fields']['defaultLanguage'];
                        } else {
                            $query['$unset']['defaultLanguage'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['languages'])
                    || array_key_exists('languages', $this->data['fields'])) {
                    $value = $this->data['fields']['languages'];
                    $originalValue = $this->getOriginalFieldValue('languages');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['languages'] = (string) $this->data['fields']['languages'];
                        } else {
                            $query['$unset']['languages'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['blocks'])
                    || array_key_exists('blocks', $this->data['fields'])) {
                    $value = $this->data['fields']['blocks'];
                    $originalValue = $this->getOriginalFieldValue('blocks');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['blocks'] = (string) $this->data['fields']['blocks'];
                        } else {
                            $query['$unset']['blocks'] = 1;
                        }
                    }
                }
            }
        }
        if (true === $reset) {
            $reset = 'deep';
        }

        return $query;
    }

    /**
     * Maps the validation.
     *
     * @param \Symfony\Component\Validator\Mapping\ClassMetadata $metadata The metadata class.
     */
    public static function loadValidatorMetadata(\Symfony\Component\Validator\Mapping\ClassMetadata $metadata)
    {
        $validation = array(
            'constraints' => array(

            ),
            'getters' => array(

            ),
        );

        foreach (\Mandango\MandangoBundle\Extension\DocumentValidation
            ::parseNodes($validation['constraints']) as $constraint) {
            $metadata->addConstraint($constraint);
        }

        foreach ($validation['getters'] as $getter => $constraints) {
            foreach (\Mandango\MandangoBundle\Extension\DocumentValidation
            ::parseNodes($constraints) as $constraint) {
                $metadata->addGetterConstraint($getter, $constraint);
            }
        }

        return true;
    }
}
