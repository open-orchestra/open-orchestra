<?php

namespace Model\PHPOrchestraCMSBundle\Base;

/**
 * Base class of Model\PHPOrchestraCMSBundle\FieldIndex document.
 */
abstract class FieldIndex extends \Mandango\Document\Document
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
     * @return \Model\PHPOrchestraCMSBundle\FieldIndex The document (fluent interface).
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
        if (isset($data['fieldName'])) {
            $this->data['fields']['fieldName'] = (string) $data['fieldName'];
        } elseif (isset($data['_fields']['fieldName'])) {
            $this->data['fields']['fieldName'] = null;
        }
        if (isset($data['fieldType'])) {
            $this->data['fields']['fieldType'] = (string) $data['fieldType'];
        } elseif (isset($data['_fields']['fieldType'])) {
            $this->data['fields']['fieldType'] = null;
        }

        return $this;
    }

    /**
     * Set the "fieldName" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\FieldIndex The document (fluent interface).
     */
    public function setFieldName($value)
    {
        if (!isset($this->data['fields']['fieldName'])) {
            if (!$this->isNew()) {
                $this->getFieldName();
                if ($this->isFieldEqualTo('fieldName', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['fieldName'] = null;
                $this->data['fields']['fieldName'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('fieldName', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['fieldName']) && !array_key_exists('fieldName', $this->fieldsModified)) {
            $this->fieldsModified['fieldName'] = $this->data['fields']['fieldName'];
        } elseif ($this->isFieldModifiedEqualTo('fieldName', $value)) {
            unset($this->fieldsModified['fieldName']);
        }

        $this->data['fields']['fieldName'] = $value;

        return $this;
    }

    /**
     * Returns the "fieldName" field.
     *
     * @return mixed The $name field.
     */
    public function getFieldName()
    {
        if (!isset($this->data['fields']['fieldName'])) {
            if ($this->isNew()) {
                $this->data['fields']['fieldName'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('fieldName', $this->data['fields'])) {
                $this->addFieldCache('fieldName');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('fieldName' => 1)
                );
                if (isset($data['fieldName'])) {
                    $this->data['fields']['fieldName'] = (string) $data['fieldName'];
                } else {
                    $this->data['fields']['fieldName'] = null;
                }
            }
        }

        return $this->data['fields']['fieldName'];
    }

    /**
     * Set the "fieldType" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\FieldIndex The document (fluent interface).
     */
    public function setFieldType($value)
    {
        if (!isset($this->data['fields']['fieldType'])) {
            if (!$this->isNew()) {
                $this->getFieldType();
                if ($this->isFieldEqualTo('fieldType', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['fieldType'] = null;
                $this->data['fields']['fieldType'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('fieldType', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['fieldType']) && !array_key_exists('fieldType', $this->fieldsModified)) {
            $this->fieldsModified['fieldType'] = $this->data['fields']['fieldType'];
        } elseif ($this->isFieldModifiedEqualTo('fieldType', $value)) {
            unset($this->fieldsModified['fieldType']);
        }

        $this->data['fields']['fieldType'] = $value;

        return $this;
    }

    /**
     * Returns the "fieldType" field.
     *
     * @return mixed The $name field.
     */
    public function getFieldType()
    {
        if (!isset($this->data['fields']['fieldType'])) {
            if ($this->isNew()) {
                $this->data['fields']['fieldType'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('fieldType', $this->data['fields'])) {
                $this->addFieldCache('fieldType');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('fieldType' => 1)
                );
                if (isset($data['fieldType'])) {
                    $this->data['fields']['fieldType'] = (string) $data['fieldType'];
                } else {
                    $this->data['fields']['fieldType'] = null;
                }
            }
        }

        return $this->data['fields']['fieldType'];
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
        if ('fieldName' == $name) {
            return $this->setFieldName($value);
        }
        if ('fieldType' == $name) {
            return $this->setFieldType($value);
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
        if ('fieldName' == $name) {
            return $this->getFieldName();
        }
        if ('fieldType' == $name) {
            return $this->getFieldType();
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Model\PHPOrchestraCMSBundle\FieldIndex The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['id'])) {
            $this->setId($array['id']);
        }
        if (isset($array['fieldName'])) {
            $this->setFieldName($array['fieldName']);
        }
        if (isset($array['fieldType'])) {
            $this->setFieldType($array['fieldType']);
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

        $array['fieldName'] = $this->getFieldName();
        $array['fieldType'] = $this->getFieldType();

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
                if (isset($this->data['fields']['fieldName'])) {
                    $query['fieldName'] = (string) $this->data['fields']['fieldName'];
                }
                if (isset($this->data['fields']['fieldType'])) {
                    $query['fieldType'] = (string) $this->data['fields']['fieldType'];
                }
            } else {
                if (isset($this->data['fields']['fieldName'])
                    || array_key_exists('fieldName', $this->data['fields'])) {
                    $value = $this->data['fields']['fieldName'];
                    $originalValue = $this->getOriginalFieldValue('fieldName');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['fieldName'] = (string) $this->data['fields']['fieldName'];
                        } else {
                            $query['$unset']['fieldName'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['fieldType'])
                    || array_key_exists('fieldType', $this->data['fields'])) {
                    $value = $this->data['fields']['fieldType'];
                    $originalValue = $this->getOriginalFieldValue('fieldType');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['fieldType'] = (string) $this->data['fields']['fieldType'];
                        } else {
                            $query['$unset']['fieldType'] = 1;
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
