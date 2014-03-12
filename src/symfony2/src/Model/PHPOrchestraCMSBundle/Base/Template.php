<?php

namespace Model\PHPOrchestraCMSBundle\Base;

/**
 * Base class of Model\PHPOrchestraCMSBundle\Template document.
 */
abstract class Template extends \Mandango\Document\Document
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
     * @return \Model\PHPOrchestraCMSBundle\Template The document (fluent interface).
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
        if (isset($data['templateId'])) {
            $this->data['fields']['templateId'] = (int) $data['templateId'];
        } elseif (isset($data['_fields']['templateId'])) {
            $this->data['fields']['templateId'] = null;
        }
        if (isset($data['siteId'])) {
            $this->data['fields']['siteId'] = (int) $data['siteId'];
        } elseif (isset($data['_fields']['siteId'])) {
            $this->data['fields']['siteId'] = null;
        }
        if (isset($data['name'])) {
            $this->data['fields']['name'] = (string) $data['name'];
        } elseif (isset($data['_fields']['name'])) {
            $this->data['fields']['name'] = null;
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
        if (isset($data['areas'])) {
            $this->data['fields']['areas'] = $data['areas'];
        } elseif (isset($data['_fields']['areas'])) {
            $this->data['fields']['areas'] = null;
        }
        if (isset($data['blocks'])) {
            $embedded = new \Mandango\Group\EmbeddedGroup('Model\PHPOrchestraCMSBundle\Block');
            $embedded->setRootAndPath($this, 'blocks');
            $embedded->setSavedData($data['blocks']);
            $this->data['embeddedsMany']['blocks'] = $embedded;
        }

        return $this;
    }

    /**
     * Set the "templateId" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Template The document (fluent interface).
     */
    public function setTemplateId($value)
    {
        if (!isset($this->data['fields']['templateId'])) {
            if (!$this->isNew()) {
                $this->getTemplateId();
                if ($this->isFieldEqualTo('templateId', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['templateId'] = null;
                $this->data['fields']['templateId'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('templateId', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['templateId']) && !array_key_exists('templateId', $this->fieldsModified)) {
            $this->fieldsModified['templateId'] = $this->data['fields']['templateId'];
        } elseif ($this->isFieldModifiedEqualTo('templateId', $value)) {
            unset($this->fieldsModified['templateId']);
        }

        $this->data['fields']['templateId'] = $value;

        return $this;
    }

    /**
     * Returns the "templateId" field.
     *
     * @return mixed The $name field.
     */
    public function getTemplateId()
    {
        if (!isset($this->data['fields']['templateId'])) {
            if ($this->isNew()) {
                $this->data['fields']['templateId'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('templateId', $this->data['fields'])) {
                $this->addFieldCache('templateId');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('templateId' => 1));
                if (isset($data['templateId'])) {
                    $this->data['fields']['templateId'] = (int) $data['templateId'];
                } else {
                    $this->data['fields']['templateId'] = null;
                }
            }
        }

        return $this->data['fields']['templateId'];
    }

    /**
     * Set the "siteId" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Template The document (fluent interface).
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
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('siteId' => 1));
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
     * Set the "name" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Template The document (fluent interface).
     */
    public function setName($value)
    {
        if (!isset($this->data['fields']['name'])) {
            if (!$this->isNew()) {
                $this->getName();
                if ($this->isFieldEqualTo('name', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['name'] = null;
                $this->data['fields']['name'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('name', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['name']) && !array_key_exists('name', $this->fieldsModified)) {
            $this->fieldsModified['name'] = $this->data['fields']['name'];
        } elseif ($this->isFieldModifiedEqualTo('name', $value)) {
            unset($this->fieldsModified['name']);
        }

        $this->data['fields']['name'] = $value;

        return $this;
    }

    /**
     * Returns the "name" field.
     *
     * @return mixed The $name field.
     */
    public function getName()
    {
        if (!isset($this->data['fields']['name'])) {
            if ($this->isNew()) {
                $this->data['fields']['name'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('name', $this->data['fields'])) {
                $this->addFieldCache('name');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('name' => 1));
                if (isset($data['name'])) {
                    $this->data['fields']['name'] = (string) $data['name'];
                } else {
                    $this->data['fields']['name'] = null;
                }
            }
        }

        return $this->data['fields']['name'];
    }

    /**
     * Set the "version" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Template The document (fluent interface).
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
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('version' => 1));
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
     * @return \Model\PHPOrchestraCMSBundle\Template The document (fluent interface).
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
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('language' => 1));
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
     * @return \Model\PHPOrchestraCMSBundle\Template The document (fluent interface).
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
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('status' => 1));
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
     * Set the "areas" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Template The document (fluent interface).
     */
    public function setAreas($value)
    {
        if (!isset($this->data['fields']['areas'])) {
            if (!$this->isNew()) {
                $this->getAreas();
                if ($this->isFieldEqualTo('areas', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['areas'] = null;
                $this->data['fields']['areas'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('areas', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['areas']) && !array_key_exists('areas', $this->fieldsModified)) {
            $this->fieldsModified['areas'] = $this->data['fields']['areas'];
        } elseif ($this->isFieldModifiedEqualTo('areas', $value)) {
            unset($this->fieldsModified['areas']);
        }

        $this->data['fields']['areas'] = $value;

        return $this;
    }

    /**
     * Returns the "areas" field.
     *
     * @return mixed The $name field.
     */
    public function getAreas()
    {
        if (!isset($this->data['fields']['areas'])) {
            if ($this->isNew()) {
                $this->data['fields']['areas'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('areas', $this->data['fields'])) {
                $this->addFieldCache('areas');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('areas' => 1));
                if (isset($data['areas'])) {
                    $this->data['fields']['areas'] = $data['areas'];
                } else {
                    $this->data['fields']['areas'] = null;
                }
            }
        }

        return $this->data['fields']['areas'];
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
     * Returns the "blocks" embedded many.
     *
     * @return \Mandango\Group\EmbeddedGroup The "blocks" embedded many.
     */
    public function getBlocks()
    {
        if (!isset($this->data['embeddedsMany']['blocks'])) {
            $this->data['embeddedsMany']['blocks'] = $embedded = new \Mandango\Group\EmbeddedGroup('Model\PHPOrchestraCMSBundle\Block');
            $embedded->setRootAndPath($this, 'blocks');
        }

        return $this->data['embeddedsMany']['blocks'];
    }

    /**
     * Adds documents to the "blocks" embeddeds many.
     *
     * @param mixed $documents A document or an array or documents.
     *
     * @return \Model\PHPOrchestraCMSBundle\Template The document (fluent interface).
     */
    public function addBlocks($documents)
    {
        $this->getBlocks()->add($documents);

        return $this;
    }

    /**
     * Removes documents to the "blocks" embeddeds many.
     *
     * @param mixed $documents A document or an array or documents.
     *
     * @return \Model\PHPOrchestraCMSBundle\Template The document (fluent interface).
     */
    public function removeBlocks($documents)
    {
        $this->getBlocks()->remove($documents);

        return $this;
    }

    /**
     * Resets the groups of the document.
     */
    public function resetGroups()
    {
        if (isset($this->data['embeddedsMany']['blocks'])) {
            $this->data['embeddedsMany']['blocks']->reset();
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
        if ('templateId' == $name) {
            return $this->setTemplateId($value);
        }
        if ('siteId' == $name) {
            return $this->setSiteId($value);
        }
        if ('name' == $name) {
            return $this->setName($value);
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
        if ('areas' == $name) {
            return $this->setAreas($value);
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
        if ('templateId' == $name) {
            return $this->getTemplateId();
        }
        if ('siteId' == $name) {
            return $this->getSiteId();
        }
        if ('name' == $name) {
            return $this->getName();
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
        if ('areas' == $name) {
            return $this->getAreas();
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
     * @return \Model\PHPOrchestraCMSBundle\Template The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['id'])) {
            $this->setId($array['id']);
        }
        if (isset($array['templateId'])) {
            $this->setTemplateId($array['templateId']);
        }
        if (isset($array['siteId'])) {
            $this->setSiteId($array['siteId']);
        }
        if (isset($array['name'])) {
            $this->setName($array['name']);
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
        if (isset($array['areas'])) {
            $this->setAreas($array['areas']);
        }
        if (isset($array['blocks'])) {
            $embeddeds = array();
            foreach ($array['blocks'] as $documentData) {
                $embeddeds[] = $embedded = new \Model\PHPOrchestraCMSBundle\Block($this->getMandango());
                $embedded->setDocumentData($documentData);
            }
            $this->getBlocks()->replace($embeddeds);
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

        $array['templateId'] = $this->getTemplateId();
        $array['siteId'] = $this->getSiteId();
        $array['name'] = $this->getName();
        $array['version'] = $this->getVersion();
        $array['language'] = $this->getLanguage();
        $array['status'] = $this->getStatus();
        $array['areas'] = $this->getAreas();

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
                if (isset($this->data['fields']['templateId'])) {
                    $query['templateId'] = (int) $this->data['fields']['templateId'];
                }
                if (isset($this->data['fields']['siteId'])) {
                    $query['siteId'] = (int) $this->data['fields']['siteId'];
                }
                if (isset($this->data['fields']['name'])) {
                    $query['name'] = (string) $this->data['fields']['name'];
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
                if (isset($this->data['fields']['areas'])) {
                    $query['areas'] = $this->data['fields']['areas'];
                }
            } else {
                if (isset($this->data['fields']['templateId']) || array_key_exists('templateId', $this->data['fields'])) {
                    $value = $this->data['fields']['templateId'];
                    $originalValue = $this->getOriginalFieldValue('templateId');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['templateId'] = (int) $this->data['fields']['templateId'];
                        } else {
                            $query['$unset']['templateId'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['siteId']) || array_key_exists('siteId', $this->data['fields'])) {
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
                if (isset($this->data['fields']['name']) || array_key_exists('name', $this->data['fields'])) {
                    $value = $this->data['fields']['name'];
                    $originalValue = $this->getOriginalFieldValue('name');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['name'] = (string) $this->data['fields']['name'];
                        } else {
                            $query['$unset']['name'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['version']) || array_key_exists('version', $this->data['fields'])) {
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
                if (isset($this->data['fields']['language']) || array_key_exists('language', $this->data['fields'])) {
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
                if (isset($this->data['fields']['status']) || array_key_exists('status', $this->data['fields'])) {
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
                if (isset($this->data['fields']['areas']) || array_key_exists('areas', $this->data['fields'])) {
                    $value = $this->data['fields']['areas'];
                    $originalValue = $this->getOriginalFieldValue('areas');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['areas'] = $this->data['fields']['areas'];
                        } else {
                            $query['$unset']['areas'] = 1;
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
                if (isset($this->data['embeddedsMany']['blocks'])) {
                    foreach ($this->data['embeddedsMany']['blocks']->getAdd() as $document) {
                        $query = $document->queryForSave($query, $isNew);
                    }
                }
            } else {
                if (isset($this->data['embeddedsMany']['blocks'])) {
                    $group = $this->data['embeddedsMany']['blocks'];
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
    static public function loadValidatorMetadata(\Symfony\Component\Validator\Mapping\ClassMetadata $metadata)
    {
        $validation = array(
            'constraints' => array(

            ),
            'getters' => array(

            ),
        );

        foreach (\Mandango\MandangoBundle\Extension\DocumentValidation::parseNodes($validation['constraints']) as $constraint) {
            $metadata->addConstraint($constraint);
        }

        foreach ($validation['getters'] as $getter => $constraints) {
            foreach (\Mandango\MandangoBundle\Extension\DocumentValidation::parseNodes($constraints) as $constraint) {
                $metadata->addGetterConstraint($getter, $constraint);
            }
        }

        return true;
    }
}