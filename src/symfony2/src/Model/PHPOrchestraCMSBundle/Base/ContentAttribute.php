<?php

namespace Model\PHPOrchestraCMSBundle\Base;

/**
 * Base class of Model\PHPOrchestraCMSBundle\ContentAttribute document.
 */
abstract class ContentAttribute extends \Mandango\Document\Document
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
     * @return \Model\PHPOrchestraCMSBundle\ContentAttribute The document (fluent interface).
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
        if (isset($data['name'])) {
            $this->data['fields']['name'] = (string) $data['name'];
        } elseif (isset($data['_fields']['name'])) {
            $this->data['fields']['name'] = null;
        }
        if (isset($data['value'])) {
            $this->data['fields']['value'] = (string) $data['value'];
        } elseif (isset($data['_fields']['value'])) {
            $this->data['fields']['value'] = null;
        }

        return $this;
    }

    /**
     * Set the "name" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\ContentAttribute The document (fluent interface).
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
     * Set the "value" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\ContentAttribute The document (fluent interface).
     */
    public function setValue($value)
    {
        if (!isset($this->data['fields']['value'])) {
            if (!$this->isNew()) {
                $this->getValue();
                if ($this->isFieldEqualTo('value', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['value'] = null;
                $this->data['fields']['value'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('value', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['value']) && !array_key_exists('value', $this->fieldsModified)) {
            $this->fieldsModified['value'] = $this->data['fields']['value'];
        } elseif ($this->isFieldModifiedEqualTo('value', $value)) {
            unset($this->fieldsModified['value']);
        }

        $this->data['fields']['value'] = $value;

        return $this;
    }

    /**
     * Returns the "value" field.
     *
     * @return mixed The $name field.
     */
    public function getValue()
    {
        if (!isset($this->data['fields']['value'])) {
            if ($this->isNew()) {
                $this->data['fields']['value'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('value', $this->data['fields'])) {
                $this->addFieldCache('value');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('value' => 1)
                );
                if (isset($data['value'])) {
                    $this->data['fields']['value'] = (string) $data['value'];
                } else {
                    $this->data['fields']['value'] = null;
                }
            }
        }

        return $this->data['fields']['value'];
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
        if ('name' == $name) {
            return $this->setName($value);
        }
        if ('value' == $name) {
            return $this->setValue($value);
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
        if ('name' == $name) {
            return $this->getName();
        }
        if ('value' == $name) {
            return $this->getValue();
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Model\PHPOrchestraCMSBundle\ContentAttribute The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['id'])) {
            $this->setId($array['id']);
        }
        if (isset($array['name'])) {
            $this->setName($array['name']);
        }
        if (isset($array['value'])) {
            $this->setValue($array['value']);
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

        $array['name'] = $this->getName();
        $array['value'] = $this->getValue();

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
                if (isset($this->data['fields']['name'])) {
                    $query['name'] = (string) $this->data['fields']['name'];
                }
                if (isset($this->data['fields']['value'])) {
                    $query['value'] = (string) $this->data['fields']['value'];
                }
            } else {
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
                if (isset($this->data['fields']['value'])
                    || array_key_exists('value', $this->data['fields'])) {
                    $value = $this->data['fields']['value'];
                    $originalValue = $this->getOriginalFieldValue('value');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['value'] = (string) $this->data['fields']['value'];
                        } else {
                            $query['$unset']['value'] = 1;
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
