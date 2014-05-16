<?php

namespace Model\PHPOrchestraCMSBundle\Base;

/**
 * Base class of Model\PHPOrchestraCMSBundle\Content document.
 */
abstract class Content extends \Mandango\Document\Document
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
     * @return \Model\PHPOrchestraCMSBundle\Content The document (fluent interface).
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
        if (isset($data['contentId'])) {
            $this->data['fields']['contentId'] = (int) $data['contentId'];
        } elseif (isset($data['_fields']['contentId'])) {
            $this->data['fields']['contentId'] = null;
        }
        if (isset($data['contentType'])) {
            $this->data['fields']['contentType'] = (string) $data['contentType'];
        } elseif (isset($data['_fields']['contentType'])) {
            $this->data['fields']['contentType'] = null;
        }
        if (isset($data['version'])) {
            $this->data['fields']['version'] = (int) $data['version'];
        } elseif (isset($data['_fields']['version'])) {
            $this->data['fields']['version'] = null;
        }
        if (isset($data['language'])) {
            $this->data['fields']['language'] = (string) $data['language'];
        } elseif (isset($data['_fields']['language'])) {
            $this->data['fields']['language'] = null;
        }
        if (isset($data['status'])) {
            $this->data['fields']['status'] = (string) $data['status'];
        } elseif (isset($data['_fields']['status'])) {
            $this->data['fields']['status'] = null;
        }
        if (isset($data['shortName'])) {
            $this->data['fields']['shortName'] = (string) $data['shortName'];
        } elseif (isset($data['_fields']['shortName'])) {
            $this->data['fields']['shortName'] = null;
        }
        if (isset($data['attributes'])) {
            $embedded = new \Mandango\Group\EmbeddedGroup('Model\PHPOrchestraCMSBundle\ContentAttribute');
            $embedded->setRootAndPath($this, 'attributes');
            $embedded->setSavedData($data['attributes']);
            $this->data['embeddedsMany']['attributes'] = $embedded;
        }

        return $this;
    }

    /**
     * Set the "contentId" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Content The document (fluent interface).
     */
    public function setContentId($value)
    {
        if (!isset($this->data['fields']['contentId'])) {
            if (!$this->isNew()) {
                $this->getContentId();
                if ($this->isFieldEqualTo('contentId', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['contentId'] = null;
                $this->data['fields']['contentId'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('contentId', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['contentId']) && !array_key_exists('contentId', $this->fieldsModified)) {
            $this->fieldsModified['contentId'] = $this->data['fields']['contentId'];
        } elseif ($this->isFieldModifiedEqualTo('contentId', $value)) {
            unset($this->fieldsModified['contentId']);
        }

        $this->data['fields']['contentId'] = $value;

        return $this;
    }

    /**
     * Returns the "contentId" field.
     *
     * @return mixed The $name field.
     */
    public function getContentId()
    {
        if (!isset($this->data['fields']['contentId'])) {
            if ($this->isNew()) {
                $this->data['fields']['contentId'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('contentId', $this->data['fields'])) {
                $this->addFieldCache('contentId');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('contentId' => 1)
                );
                if (isset($data['contentId'])) {
                    $this->data['fields']['contentId'] = (int) $data['contentId'];
                } else {
                    $this->data['fields']['contentId'] = null;
                }
            }
        }

        return $this->data['fields']['contentId'];
    }

    /**
     * Set the "contentType" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Content The document (fluent interface).
     */
    public function setContentType($value)
    {
        if (!isset($this->data['fields']['contentType'])) {
            if (!$this->isNew()) {
                $this->getContentType();
                if ($this->isFieldEqualTo('contentType', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['contentType'] = null;
                $this->data['fields']['contentType'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('contentType', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['contentType']) && !array_key_exists('contentType', $this->fieldsModified)) {
            $this->fieldsModified['contentType'] = $this->data['fields']['contentType'];
        } elseif ($this->isFieldModifiedEqualTo('contentType', $value)) {
            unset($this->fieldsModified['contentType']);
        }

        $this->data['fields']['contentType'] = $value;

        return $this;
    }

    /**
     * Returns the "contentType" field.
     *
     * @return mixed The $name field.
     */
    public function getContentType()
    {
        if (!isset($this->data['fields']['contentType'])) {
            if ($this->isNew()) {
                $this->data['fields']['contentType'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('contentType', $this->data['fields'])) {
                $this->addFieldCache('contentType');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('contentType' => 1)
                );
                if (isset($data['contentType'])) {
                    $this->data['fields']['contentType'] = (string) $data['contentType'];
                } else {
                    $this->data['fields']['contentType'] = null;
                }
            }
        }

        return $this->data['fields']['contentType'];
    }

    /**
     * Set the "version" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Content The document (fluent interface).
     */
    public function setVersion($value)
    {
        if (!isset($this->data['fields']['version'])) {
            if (!$this->isNew()) {
                $this->getVersion();
                if ($this->isFieldEqualTo('version', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['version'] = null;
                $this->data['fields']['version'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('version', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['version']) && !array_key_exists('version', $this->fieldsModified)) {
            $this->fieldsModified['version'] = $this->data['fields']['version'];
        } elseif ($this->isFieldModifiedEqualTo('version', $value)) {
            unset($this->fieldsModified['version']);
        }

        $this->data['fields']['version'] = $value;

        return $this;
    }

    /**
     * Returns the "version" field.
     *
     * @return mixed The $name field.
     */
    public function getVersion()
    {
        if (!isset($this->data['fields']['version'])) {
            if ($this->isNew()) {
                $this->data['fields']['version'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('version', $this->data['fields'])) {
                $this->addFieldCache('version');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('version' => 1)
                );
                if (isset($data['version'])) {
                    $this->data['fields']['version'] = (int) $data['version'];
                } else {
                    $this->data['fields']['version'] = null;
                }
            }
        }

        return $this->data['fields']['version'];
    }

    /**
     * Set the "language" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Content The document (fluent interface).
     */
    public function setLanguage($value)
    {
        if (!isset($this->data['fields']['language'])) {
            if (!$this->isNew()) {
                $this->getLanguage();
                if ($this->isFieldEqualTo('language', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['language'] = null;
                $this->data['fields']['language'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('language', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['language']) && !array_key_exists('language', $this->fieldsModified)) {
            $this->fieldsModified['language'] = $this->data['fields']['language'];
        } elseif ($this->isFieldModifiedEqualTo('language', $value)) {
            unset($this->fieldsModified['language']);
        }

        $this->data['fields']['language'] = $value;

        return $this;
    }

    /**
     * Returns the "language" field.
     *
     * @return mixed The $name field.
     */
    public function getLanguage()
    {
        if (!isset($this->data['fields']['language'])) {
            if ($this->isNew()) {
                $this->data['fields']['language'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('language', $this->data['fields'])) {
                $this->addFieldCache('language');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('language' => 1)
                );
                if (isset($data['language'])) {
                    $this->data['fields']['language'] = (string) $data['language'];
                } else {
                    $this->data['fields']['language'] = null;
                }
            }
        }

        return $this->data['fields']['language'];
    }

    /**
     * Set the "status" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Content The document (fluent interface).
     */
    public function setStatus($value)
    {
        if (!isset($this->data['fields']['status'])) {
            if (!$this->isNew()) {
                $this->getStatus();
                if ($this->isFieldEqualTo('status', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['status'] = null;
                $this->data['fields']['status'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('status', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['status']) && !array_key_exists('status', $this->fieldsModified)) {
            $this->fieldsModified['status'] = $this->data['fields']['status'];
        } elseif ($this->isFieldModifiedEqualTo('status', $value)) {
            unset($this->fieldsModified['status']);
        }

        $this->data['fields']['status'] = $value;

        return $this;
    }

    /**
     * Returns the "status" field.
     *
     * @return mixed The $name field.
     */
    public function getStatus()
    {
        if (!isset($this->data['fields']['status'])) {
            if ($this->isNew()) {
                $this->data['fields']['status'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('status', $this->data['fields'])) {
                $this->addFieldCache('status');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('status' => 1)
                );
                if (isset($data['status'])) {
                    $this->data['fields']['status'] = (string) $data['status'];
                } else {
                    $this->data['fields']['status'] = null;
                }
            }
        }

        return $this->data['fields']['status'];
    }

    /**
     * Set the "shortName" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Content The document (fluent interface).
     */
    public function setShortName($value)
    {
        if (!isset($this->data['fields']['shortName'])) {
            if (!$this->isNew()) {
                $this->getShortName();
                if ($this->isFieldEqualTo('shortName', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['shortName'] = null;
                $this->data['fields']['shortName'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('shortName', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['shortName']) && !array_key_exists('shortName', $this->fieldsModified)) {
            $this->fieldsModified['shortName'] = $this->data['fields']['shortName'];
        } elseif ($this->isFieldModifiedEqualTo('shortName', $value)) {
            unset($this->fieldsModified['shortName']);
        }

        $this->data['fields']['shortName'] = $value;

        return $this;
    }

    /**
     * Returns the "shortName" field.
     *
     * @return mixed The $name field.
     */
    public function getShortName()
    {
        if (!isset($this->data['fields']['shortName'])) {
            if ($this->isNew()) {
                $this->data['fields']['shortName'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('shortName', $this->data['fields'])) {
                $this->addFieldCache('shortName');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('shortName' => 1)
                );
                if (isset($data['shortName'])) {
                    $this->data['fields']['shortName'] = (string) $data['shortName'];
                } else {
                    $this->data['fields']['shortName'] = null;
                }
            }
        }

        return $this->data['fields']['shortName'];
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
     * Returns the "attributes" embedded many.
     *
     * @return \Mandango\Group\EmbeddedGroup The "attributes" embedded many.
     */
    public function getAttributes()
    {
        if (!isset($this->data['embeddedsMany']['attributes'])) {
            $this->data['embeddedsMany']['attributes'] = $embedded =
                new \Mandango\Group\EmbeddedGroup('Model\PHPOrchestraCMSBundle\ContentAttribute');
            $embedded->setRootAndPath($this, 'attributes');
        }

        return $this->data['embeddedsMany']['attributes'];
    }

    /**
     * Adds documents to the "attributes" embeddeds many.
     *
     * @param mixed $documents A document or an array or documents.
     *
     * @return \Model\PHPOrchestraCMSBundle\Content The document (fluent interface).
     */
    public function addAttributes($documents)
    {
        $this->getAttributes()->add($documents);

        return $this;
    }

    /**
     * Removes documents to the "attributes" embeddeds many.
     *
     * @param mixed $documents A document or an array or documents.
     *
     * @return \Model\PHPOrchestraCMSBundle\Content The document (fluent interface).
     */
    public function removeAttributes($documents)
    {
        $this->getAttributes()->remove($documents);

        return $this;
    }

    /**
     * Resets the groups of the document.
     */
    public function resetGroups()
    {
        if (isset($this->data['embeddedsMany']['attributes'])) {
            $this->data['embeddedsMany']['attributes']->reset();
        }
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
        if ('contentId' == $name) {
            return $this->setContentId($value);
        }
        if ('contentType' == $name) {
            return $this->setContentType($value);
        }
        if ('version' == $name) {
            return $this->setVersion($value);
        }
        if ('language' == $name) {
            return $this->setLanguage($value);
        }
        if ('status' == $name) {
            return $this->setStatus($value);
        }
        if ('shortName' == $name) {
            return $this->setShortName($value);
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
        if ('contentId' == $name) {
            return $this->getContentId();
        }
        if ('contentType' == $name) {
            return $this->getContentType();
        }
        if ('version' == $name) {
            return $this->getVersion();
        }
        if ('language' == $name) {
            return $this->getLanguage();
        }
        if ('status' == $name) {
            return $this->getStatus();
        }
        if ('shortName' == $name) {
            return $this->getShortName();
        }
        if ('attributes' == $name) {
            return $this->getAttributes();
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Model\PHPOrchestraCMSBundle\Content The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['id'])) {
            $this->setId($array['id']);
        }
        if (isset($array['contentId'])) {
            $this->setContentId($array['contentId']);
        }
        if (isset($array['contentType'])) {
            $this->setContentType($array['contentType']);
        }
        if (isset($array['version'])) {
            $this->setVersion($array['version']);
        }
        if (isset($array['language'])) {
            $this->setLanguage($array['language']);
        }
        if (isset($array['status'])) {
            $this->setStatus($array['status']);
        }
        if (isset($array['shortName'])) {
            $this->setShortName($array['shortName']);
        }
        if (isset($array['attributes'])) {
            $embeddeds = array();
            foreach ($array['attributes'] as $documentData) {
                $embeddeds[] = $embedded = new \Model\PHPOrchestraCMSBundle\ContentAttribute($this->getMandango());
                $embedded->setDocumentData($documentData);
            }
            $this->getAttributes()->replace($embeddeds);
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

        $array['contentId'] = $this->getContentId();
        $array['contentType'] = $this->getContentType();
        $array['version'] = $this->getVersion();
        $array['language'] = $this->getLanguage();
        $array['status'] = $this->getStatus();
        $array['shortName'] = $this->getShortName();

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
                if (isset($this->data['fields']['contentId'])) {
                    $query['contentId'] = (int) $this->data['fields']['contentId'];
                }
                if (isset($this->data['fields']['contentType'])) {
                    $query['contentType'] = (string) $this->data['fields']['contentType'];
                }
                if (isset($this->data['fields']['version'])) {
                    $query['version'] = (int) $this->data['fields']['version'];
                }
                if (isset($this->data['fields']['language'])) {
                    $query['language'] = (string) $this->data['fields']['language'];
                }
                if (isset($this->data['fields']['status'])) {
                    $query['status'] = (string) $this->data['fields']['status'];
                }
                if (isset($this->data['fields']['shortName'])) {
                    $query['shortName'] = (string) $this->data['fields']['shortName'];
                }
            } else {
                if (isset($this->data['fields']['contentId'])
                    || array_key_exists('contentId', $this->data['fields'])) {
                    $value = $this->data['fields']['contentId'];
                    $originalValue = $this->getOriginalFieldValue('contentId');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['contentId'] = (int) $this->data['fields']['contentId'];
                        } else {
                            $query['$unset']['contentId'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['contentType'])
                    || array_key_exists('contentType', $this->data['fields'])) {
                    $value = $this->data['fields']['contentType'];
                    $originalValue = $this->getOriginalFieldValue('contentType');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['contentType'] = (string) $this->data['fields']['contentType'];
                        } else {
                            $query['$unset']['contentType'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['version'])
                    || array_key_exists('version', $this->data['fields'])) {
                    $value = $this->data['fields']['version'];
                    $originalValue = $this->getOriginalFieldValue('version');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['version'] = (int) $this->data['fields']['version'];
                        } else {
                            $query['$unset']['version'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['language'])
                    || array_key_exists('language', $this->data['fields'])) {
                    $value = $this->data['fields']['language'];
                    $originalValue = $this->getOriginalFieldValue('language');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['language'] = (string) $this->data['fields']['language'];
                        } else {
                            $query['$unset']['language'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['status'])
                    || array_key_exists('status', $this->data['fields'])) {
                    $value = $this->data['fields']['status'];
                    $originalValue = $this->getOriginalFieldValue('status');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['status'] = (string) $this->data['fields']['status'];
                        } else {
                            $query['$unset']['status'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['shortName'])
                    || array_key_exists('shortName', $this->data['fields'])) {
                    $value = $this->data['fields']['shortName'];
                    $originalValue = $this->getOriginalFieldValue('shortName');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['shortName'] = (string) $this->data['fields']['shortName'];
                        } else {
                            $query['$unset']['shortName'] = 1;
                        }
                    }
                }
            }
        }
        if (true === $reset) {
            $reset = 'deep';
        }
        if (isset($this->data['embeddedsMany'])) {
            if ($isNew) {
                if (isset($this->data['embeddedsMany']['attributes'])) {
                    foreach ($this->data['embeddedsMany']['attributes']->getAdd() as $document) {
                        $query = $document->queryForSave($query, $isNew);
                    }
                }
            } else {
                if (isset($this->data['embeddedsMany']['attributes'])) {
                    $group = $this->data['embeddedsMany']['attributes'];
                    foreach ($group->getSaved() as $document) {
                        $query = $document->queryForSave($query, $isNew);
                    }
                    $groupRap = $group->getRootAndPath();
                    foreach ($group->getAdd() as $document) {
                        $q = $document->queryForSave(array(), true);
                        $rap = $document->getRootAndPath();
                        foreach (explode('.', $rap['path']) as $name) {
                            if (0 === strpos($name, '_add')) {
                                $name = substr($name, 4);
                            }
                            $q = $q[$name];
                        }
                        $query['$pushAll'][$groupRap['path']][] = $q;
                    }
                    foreach ($group->getRemove() as $document) {
                        $rap = $document->getRootAndPath();
                        $query['$unset'][$rap['path']] = 1;
                    }
                }
            }
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
