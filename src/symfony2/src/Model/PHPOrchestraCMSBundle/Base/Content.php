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
        if (isset($data['type'])) {
            $this->data['fields']['type'] = (string) $data['type'];
        } elseif (isset($data['_fields']['type'])) {
            $this->data['fields']['type'] = null;
        }
        if (isset($data['version'])) {
            $this->data['fields']['version'] = (int) $data['version'];
        } elseif (isset($data['_fields']['version'])) {
            $this->data['fields']['version'] = null;
        }
        if (isset($data['status'])) {
            $this->data['fields']['status'] = (string) $data['status'];
        } elseif (isset($data['_fields']['status'])) {
            $this->data['fields']['status'] = null;
        }
        if (isset($data['attributes'])) {
            $this->data['fields']['attributes'] = $data['attributes'];
        } elseif (isset($data['_fields']['attributes'])) {
            $this->data['fields']['attributes'] = null;
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

        if (!isset($this->fieldsModified['contentId'])
            && !array_key_exists('contentId', $this->fieldsModified)) {
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
            } elseif (!isset($this->data['fields'])
                || !array_key_exists('contentId', $this->data['fields'])) {
                $this->addFieldCache('contentId');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()), array('contentId' => 1));
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
     * Set the "type" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Content The document (fluent interface).
     */
    public function setType($value)
    {
        if (!isset($this->data['fields']['type'])) {
            if (!$this->isNew()) {
                $this->getType();
                if ($this->isFieldEqualTo('type', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['type'] = null;
                $this->data['fields']['type'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('type', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['type'])
            && !array_key_exists('type', $this->fieldsModified)) {
            $this->fieldsModified['type'] = $this->data['fields']['type'];
        } elseif ($this->isFieldModifiedEqualTo('type', $value)) {
            unset($this->fieldsModified['type']);
        }

        $this->data['fields']['type'] = $value;

        return $this;
    }

    /**
     * Returns the "type" field.
     *
     * @return mixed The $name field.
     */
    public function getType()
    {
        if (!isset($this->data['fields']['type'])) {
            if ($this->isNew()) {
                $this->data['fields']['type'] = null;
            } elseif (!isset($this->data['fields'])
                || !array_key_exists('type', $this->data['fields'])) {
                $this->addFieldCache('type');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()), array('type' => 1));
                if (isset($data['type'])) {
                    $this->data['fields']['type'] = (string) $data['type'];
                } else {
                    $this->data['fields']['type'] = null;
                }
            }
        }

        return $this->data['fields']['type'];
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

        if (!isset($this->fieldsModified['version'])
            && !array_key_exists('version', $this->fieldsModified)) {
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
            } elseif (!isset($this->data['fields'])
                || !array_key_exists('version', $this->data['fields'])) {
                $this->addFieldCache('version');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()), array('version' => 1));
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

        if (!isset($this->fieldsModified['status'])
            && !array_key_exists('status', $this->fieldsModified)) {
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
            } elseif (!isset($this->data['fields'])
                || !array_key_exists('status', $this->data['fields'])) {
                $this->addFieldCache('status');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()), array('status' => 1));
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
     * Set the "attributes" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Content The document (fluent interface).
     */
    public function setAttributes($value)
    {
        if (!isset($this->data['fields']['attributes'])) {
            if (!$this->isNew()) {
                $this->getAttributes();
                if ($this->isFieldEqualTo('attributes', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['attributes'] = null;
                $this->data['fields']['attributes'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('attributes', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['attributes'])
            && !array_key_exists('attributes', $this->fieldsModified)) {
            $this->fieldsModified['attributes'] = $this->data['fields']['attributes'];
        } elseif ($this->isFieldModifiedEqualTo('attributes', $value)) {
            unset($this->fieldsModified['attributes']);
        }

        $this->data['fields']['attributes'] = $value;

        return $this;
    }

    /**
     * Returns the "attributes" field.
     *
     * @return mixed The $name field.
     */
    public function getAttributes()
    {
        if (!isset($this->data['fields']['attributes'])) {
            if ($this->isNew()) {
                $this->data['fields']['attributes'] = null;
            } elseif (!isset($this->data['fields'])
                || !array_key_exists('attributes', $this->data['fields'])) {
                $this->addFieldCache('attributes');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()), array('attributes' => 1));
                if (isset($data['attributes'])) {
                    $this->data['fields']['attributes'] = $data['attributes'];
                } else {
                    $this->data['fields']['attributes'] = null;
                }
            }
        }

        return $this->data['fields']['attributes'];
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
        if ('contentId' == $name) {
            return $this->setContentId($value);
        }
        if ('type' == $name) {
            return $this->setType($value);
        }
        if ('version' == $name) {
            return $this->setVersion($value);
        }
        if ('status' == $name) {
            return $this->setStatus($value);
        }
        if ('attributes' == $name) {
            return $this->setAttributes($value);
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
        if ('type' == $name) {
            return $this->getType();
        }
        if ('version' == $name) {
            return $this->getVersion();
        }
        if ('status' == $name) {
            return $this->getStatus();
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
        if (isset($array['type'])) {
            $this->setType($array['type']);
        }
        if (isset($array['version'])) {
            $this->setVersion($array['version']);
        }
        if (isset($array['status'])) {
            $this->setStatus($array['status']);
        }
        if (isset($array['attributes'])) {
            $this->setAttributes($array['attributes']);
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
        $array['type'] = $this->getType();
        $array['version'] = $this->getVersion();
        $array['status'] = $this->getStatus();
        $array['attributes'] = $this->getAttributes();

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
                if (isset($this->data['fields']['type'])) {
                    $query['type'] = (string) $this->data['fields']['type'];
                }
                if (isset($this->data['fields']['version'])) {
                    $query['version'] = (int) $this->data['fields']['version'];
                }
                if (isset($this->data['fields']['status'])) {
                    $query['status'] = (string) $this->data['fields']['status'];
                }
                if (isset($this->data['fields']['attributes'])) {
                    $query['attributes'] = $this->data['fields']['attributes'];
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
                if (isset($this->data['fields']['type'])
                    || array_key_exists('type', $this->data['fields'])) {
                    $value = $this->data['fields']['type'];
                    $originalValue = $this->getOriginalFieldValue('type');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['type'] = (string) $this->data['fields']['type'];
                        } else {
                            $query['$unset']['type'] = 1;
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
                if (isset($this->data['fields']['attributes'])
                    || array_key_exists('attributes', $this->data['fields'])) {
                    $value = $this->data['fields']['attributes'];
                    $originalValue = $this->getOriginalFieldValue('attributes');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['attributes'] = $this->data['fields']['attributes'];
                        } else {
                            $query['$unset']['attributes'] = 1;
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

        foreach (\Mandango\MandangoBundle\Extension\DocumentValidation::parseNodes($validation['constraints'])
            as $constraint) {
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

