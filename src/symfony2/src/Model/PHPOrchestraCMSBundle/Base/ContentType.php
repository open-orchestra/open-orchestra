<?php

namespace Model\PHPOrchestraCMSBundle\Base;

/**
 * Base class of Model\PHPOrchestraCMSBundle\ContentType document.
 */
abstract class ContentType extends \Mandango\Document\Document
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
     * @return \Model\PHPOrchestraCMSBundle\ContentType The document (fluent interface).
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
        if (isset($data['contentTypeId'])) {
            $this->data['fields']['contentTypeId'] = (string) $data['contentTypeId'];
        } elseif (isset($data['_fields']['contentTypeId'])) {
            $this->data['fields']['contentTypeId'] = null;
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
        if (isset($data['status'])) {
            $this->data['fields']['status'] = (string) $data['status'];
        } elseif (isset($data['_fields']['status'])) {
            $this->data['fields']['status'] = null;
        }
        if (isset($data['deleted'])) {
            $this->data['fields']['deleted'] = (bool) $data['deleted'];
        } elseif (isset($data['_fields']['deleted'])) {
            $this->data['fields']['deleted'] = null;
        }
        if (isset($data['fields'])) {
            $this->data['fields']['fields'] = $data['fields'];
        } elseif (isset($data['_fields']['fields'])) {
            $this->data['fields']['fields'] = null;
        }

        return $this;
    }

    /**
     * Set the "contentTypeId" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\ContentType The document (fluent interface).
     */
    public function setContentTypeId($value)
    {
        if (!isset($this->data['fields']['contentTypeId'])) {
            if (!$this->isNew()) {
                $this->getContentTypeId();
                if ($this->isFieldEqualTo('contentTypeId', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['contentTypeId'] = null;
                $this->data['fields']['contentTypeId'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('contentTypeId', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['contentTypeId']) && !array_key_exists('contentTypeId', $this->fieldsModified)) {
            $this->fieldsModified['contentTypeId'] = $this->data['fields']['contentTypeId'];
        } elseif ($this->isFieldModifiedEqualTo('contentTypeId', $value)) {
            unset($this->fieldsModified['contentTypeId']);
        }

        $this->data['fields']['contentTypeId'] = $value;

        return $this;
    }

    /**
     * Returns the "contentTypeId" field.
     *
     * @return mixed The $name field.
     */
    public function getContentTypeId()
    {
        if (!isset($this->data['fields']['contentTypeId'])) {
            if ($this->isNew()) {
                $this->data['fields']['contentTypeId'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('contentTypeId', $this->data['fields'])) {
                $this->addFieldCache('contentTypeId');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('contentTypeId' => 1)
                );
                if (isset($data['contentTypeId'])) {
                    $this->data['fields']['contentTypeId'] = (string) $data['contentTypeId'];
                } else {
                    $this->data['fields']['contentTypeId'] = null;
                }
            }
        }

        return $this->data['fields']['contentTypeId'];
    }

    /**
     * Set the "name" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\ContentType The document (fluent interface).
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
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('name' => 1)
                );
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
     * @return \Model\PHPOrchestraCMSBundle\ContentType The document (fluent interface).
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
     * Set the "status" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\ContentType The document (fluent interface).
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
     * Set the "deleted" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\ContentType The document (fluent interface).
     */
    public function setDeleted($value)
    {
        if (!isset($this->data['fields']['deleted'])) {
            if (!$this->isNew()) {
                $this->getDeleted();
                if ($this->isFieldEqualTo('deleted', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['deleted'] = null;
                $this->data['fields']['deleted'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('deleted', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['deleted']) && !array_key_exists('deleted', $this->fieldsModified)) {
            $this->fieldsModified['deleted'] = $this->data['fields']['deleted'];
        } elseif ($this->isFieldModifiedEqualTo('deleted', $value)) {
            unset($this->fieldsModified['deleted']);
        }

        $this->data['fields']['deleted'] = $value;

        return $this;
    }

    /**
     * Returns the "deleted" field.
     *
     * @return mixed The $name field.
     */
    public function getDeleted()
    {
        if (!isset($this->data['fields']['deleted'])) {
            if ($this->isNew()) {
                $this->data['fields']['deleted'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('deleted', $this->data['fields'])) {
                $this->addFieldCache('deleted');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('deleted' => 1)
                );
                if (isset($data['deleted'])) {
                    $this->data['fields']['deleted'] = (bool) $data['deleted'];
                } else {
                    $this->data['fields']['deleted'] = null;
                }
            }
        }

        return $this->data['fields']['deleted'];
    }

    /**
     * Set the "fields" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\ContentType The document (fluent interface).
     */
    public function setFields($value)
    {
        if (!isset($this->data['fields']['fields'])) {
            if (!$this->isNew()) {
                $this->getFields();
                if ($this->isFieldEqualTo('fields', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['fields'] = null;
                $this->data['fields']['fields'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('fields', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['fields']) && !array_key_exists('fields', $this->fieldsModified)) {
            $this->fieldsModified['fields'] = $this->data['fields']['fields'];
        } elseif ($this->isFieldModifiedEqualTo('fields', $value)) {
            unset($this->fieldsModified['fields']);
        }

        $this->data['fields']['fields'] = $value;

        return $this;
    }

    /**
     * Returns the "fields" field.
     *
     * @return mixed The $name field.
     */
    public function getFields()
    {
        if (!isset($this->data['fields']['fields'])) {
            if ($this->isNew()) {
                $this->data['fields']['fields'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('fields', $this->data['fields'])) {
                $this->addFieldCache('fields');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('fields' => 1)
                );
                if (isset($data['fields'])) {
                    $this->data['fields']['fields'] = $data['fields'];
                } else {
                    $this->data['fields']['fields'] = null;
                }
            }
        }

        return $this->data['fields']['fields'];
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
        if ('contentTypeId' == $name) {
            return $this->setContentTypeId($value);
        }
        if ('name' == $name) {
            return $this->setName($value);
        }
        if ('version' == $name) {
            return $this->setVersion($value);
        }
        if ('status' == $name) {
            return $this->setStatus($value);
        }
        if ('deleted' == $name) {
            return $this->setDeleted($value);
        }
        if ('fields' == $name) {
            return $this->setFields($value);
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
        if ('contentTypeId' == $name) {
            return $this->getContentTypeId();
        }
        if ('name' == $name) {
            return $this->getName();
        }
        if ('version' == $name) {
            return $this->getVersion();
        }
        if ('status' == $name) {
            return $this->getStatus();
        }
        if ('deleted' == $name) {
            return $this->getDeleted();
        }
        if ('fields' == $name) {
            return $this->getFields();
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Model\PHPOrchestraCMSBundle\ContentType The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['id'])) {
            $this->setId($array['id']);
        }
        if (isset($array['contentTypeId'])) {
            $this->setContentTypeId($array['contentTypeId']);
        }
        if (isset($array['name'])) {
            $this->setName($array['name']);
        }
        if (isset($array['version'])) {
            $this->setVersion($array['version']);
        }
        if (isset($array['status'])) {
            $this->setStatus($array['status']);
        }
        if (isset($array['deleted'])) {
            $this->setDeleted($array['deleted']);
        }
        if (isset($array['fields'])) {
            $this->setFields($array['fields']);
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

        $array['contentTypeId'] = $this->getContentTypeId();
        $array['name'] = $this->getName();
        $array['version'] = $this->getVersion();
        $array['status'] = $this->getStatus();
        $array['deleted'] = $this->getDeleted();
        $array['fields'] = $this->getFields();

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
                if (isset($this->data['fields']['contentTypeId'])) {
                    $query['contentTypeId'] = (string) $this->data['fields']['contentTypeId'];
                }
                if (isset($this->data['fields']['name'])) {
                    $query['name'] = (string) $this->data['fields']['name'];
                }
                if (isset($this->data['fields']['version'])) {
                    $query['version'] = (int) $this->data['fields']['version'];
                }
                if (isset($this->data['fields']['status'])) {
                    $query['status'] = (string) $this->data['fields']['status'];
                }
                if (isset($this->data['fields']['deleted'])) {
                    $query['deleted'] = (bool) $this->data['fields']['deleted'];
                }
                if (isset($this->data['fields']['fields'])) {
                    $query['fields'] = $this->data['fields']['fields'];
                }
            } else {
                if (isset($this->data['fields']['contentTypeId'])
                    || array_key_exists('contentTypeId', $this->data['fields'])) {
                    $value = $this->data['fields']['contentTypeId'];
                    $originalValue = $this->getOriginalFieldValue('contentTypeId');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['contentTypeId'] = (string) $this->data['fields']['contentTypeId'];
                        } else {
                            $query['$unset']['contentTypeId'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['name'])
                    || array_key_exists('name', $this->data['fields'])) {
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
                if (isset($this->data['fields']['deleted'])
                    || array_key_exists('deleted', $this->data['fields'])) {
                    $value = $this->data['fields']['deleted'];
                    $originalValue = $this->getOriginalFieldValue('deleted');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['deleted'] = (bool) $this->data['fields']['deleted'];
                        } else {
                            $query['$unset']['deleted'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['fields'])
                    || array_key_exists('fields', $this->data['fields'])) {
                    $value = $this->data['fields']['fields'];
                    $originalValue = $this->getOriginalFieldValue('fields');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['fields'] = $this->data['fields']['fields'];
                        } else {
                            $query['$unset']['fields'] = 1;
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
