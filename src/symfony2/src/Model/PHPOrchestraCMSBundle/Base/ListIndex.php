<?php

namespace Model\PHPOrchestraCMSBundle\Base;

/**
 * Base class of Model\PHPOrchestraCMSBundle\ListIndex document.
 */
abstract class ListIndex extends \Mandango\Document\Document
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
     * @return \Model\PHPOrchestraCMSBundle\ListIndex The document (fluent interface).
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
        if (isset($data['nodeId'])) {
            $this->data['fields']['nodeId'] = (string) $data['nodeId'];
        } elseif (isset($data['_fields']['nodeId'])) {
            $this->data['fields']['nodeId'] = null;
        }
        if (isset($data['contentId'])) {
            $this->data['fields']['contentId'] = (int) $data['contentId'];
        } elseif (isset($data['_fields']['contentId'])) {
            $this->data['fields']['contentId'] = null;
        }

        return $this;
    }

    /**
     * Set the "nodeId" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\ListIndex The document (fluent interface).
     */
    public function setNodeId($value)
    {
        if (!isset($this->data['fields']['nodeId'])) {
            if (!$this->isNew()) {
                $this->getNodeId();
                if ($this->isFieldEqualTo('nodeId', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['nodeId'] = null;
                $this->data['fields']['nodeId'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('nodeId', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['nodeId']) && !array_key_exists('nodeId', $this->fieldsModified)) {
            $this->fieldsModified['nodeId'] = $this->data['fields']['nodeId'];
        } elseif ($this->isFieldModifiedEqualTo('nodeId', $value)) {
            unset($this->fieldsModified['nodeId']);
        }

        $this->data['fields']['nodeId'] = $value;

        return $this;
    }

    /**
     * Returns the "nodeId" field.
     *
     * @return mixed The $name field.
     */
    public function getNodeId()
    {
        if (!isset($this->data['fields']['nodeId'])) {
            if ($this->isNew()) {
                $this->data['fields']['nodeId'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('nodeId', $this->data['fields'])) {
                $this->addFieldCache('nodeId');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('nodeId' => 1)
                );
                if (isset($data['nodeId'])) {
                    $this->data['fields']['nodeId'] = (string) $data['nodeId'];
                } else {
                    $this->data['fields']['nodeId'] = null;
                }
            }
        }

        return $this->data['fields']['nodeId'];
    }

    /**
     * Set the "contentId" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\ListIndex The document (fluent interface).
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
        if ('nodeId' == $name) {
            return $this->setNodeId($value);
        }
        if ('contentId' == $name) {
            return $this->setContentId($value);
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
        if ('nodeId' == $name) {
            return $this->getNodeId();
        }
        if ('contentId' == $name) {
            return $this->getContentId();
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Model\PHPOrchestraCMSBundle\ListIndex The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['id'])) {
            $this->setId($array['id']);
        }
        if (isset($array['nodeId'])) {
            $this->setNodeId($array['nodeId']);
        }
        if (isset($array['contentId'])) {
            $this->setContentId($array['contentId']);
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

        $array['nodeId'] = $this->getNodeId();
        $array['contentId'] = $this->getContentId();

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
                if (isset($this->data['fields']['nodeId'])) {
                    $query['nodeId'] = (string) $this->data['fields']['nodeId'];
                }
                if (isset($this->data['fields']['contentId'])) {
                    $query['contentId'] = (int) $this->data['fields']['contentId'];
                }
            } else {
                if (isset($this->data['fields']['nodeId'])
                    || array_key_exists('nodeId', $this->data['fields'])) {
                    $value = $this->data['fields']['nodeId'];
                    $originalValue = $this->getOriginalFieldValue('nodeId');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['nodeId'] = (string) $this->data['fields']['nodeId'];
                        } else {
                            $query['$unset']['nodeId'] = 1;
                        }
                    }
                }
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
