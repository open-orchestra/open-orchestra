<?php

namespace Model\PHPOrchestraCMSBundle\Base;

/**
 * Base class of Model\PHPOrchestraCMSBundle\ContentField document.
 */
abstract class ContentField extends \Mandango\Document\EmbeddedDocument
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
     * @return \Model\PHPOrchestraCMSBundle\ContentField The document (fluent interface).
     */
    public function setDocumentData($data, $clean = false)
    {
        if ($clean) {
            $this->data = array();
            $this->fieldsModified = array();
        }

        if (isset($data['fieldId'])) {
            $this->data['fields']['fieldId'] = (string) $data['fieldId'];
        } elseif (isset($data['_fields']['fieldId'])) {
            $this->data['fields']['fieldId'] = null;
        }
        if (isset($data['type'])) {
            $this->data['fields']['type'] = (string) $data['type'];
        } elseif (isset($data['_fields']['type'])) {
            $this->data['fields']['type'] = null;
        }
        if (isset($data['options'])) {
            $this->data['fields']['options'] = unserialize($data['options']);
        } elseif (isset($data['_fields']['options'])) {
            $this->data['fields']['options'] = null;
        }
        if (isset($data['mandatory'])) {
            $this->data['fields']['mandatory'] = (bool) $data['mandatory'];
        } elseif (isset($data['_fields']['mandatory'])) {
            $this->data['fields']['mandatory'] = null;
        }
        if (isset($data['searchable'])) {
            $this->data['fields']['searchable'] = (bool) $data['searchable'];
        } elseif (isset($data['_fields']['searchable'])) {
            $this->data['fields']['searchable'] = null;
        }

        return $this;
    }

    /**
     * Set the "fieldId" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\ContentField The document (fluent interface).
     */
    public function setFieldId($value)
    {
        if (!isset($this->data['fields']['fieldId'])) {
            if (($rap = $this->getRootAndPath()) && !$rap['root']->isNew()) {
                $this->getFieldId();
                if ($this->isFieldEqualTo('fieldId', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['fieldId'] = null;
                $this->data['fields']['fieldId'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('fieldId', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['fieldId']) && !array_key_exists('fieldId', $this->fieldsModified)) {
            $this->fieldsModified['fieldId'] = $this->data['fields']['fieldId'];
        } elseif ($this->isFieldModifiedEqualTo('fieldId', $value)) {
            unset($this->fieldsModified['fieldId']);
        }

        $this->data['fields']['fieldId'] = $value;

        return $this;
    }

    /**
     * Returns the "fieldId" field.
     *
     * @return mixed The $name field.
     */
    public function getFieldId()
    {
        if (!isset($this->data['fields']['fieldId'])) {
            if ((!isset($this->data['fields']) || !array_key_exists('fieldId', $this->data['fields']))
                && ($rap = $this->getRootAndPath())
                && !$this->isEmbeddedOneChangedInParent()
                && !$this->isEmbeddedManyNew()) {
                $field = $rap['path'].'.fieldId';
                $rap['root']->addFieldCache($field);
                $collection = $this->getMandango()->getRepository(get_class($rap['root']))->getCollection();
                $data = $collection->findOne(array('_id' => $rap['root']->getId()), array($field => 1));
                foreach (explode('.', $field) as $key) {
                    if (!isset($data[$key])) {
                        $data = null;
                        break;
                    }
                    $data = $data[$key];
                }
                if (null !== $data) {
                    $this->data['fields']['fieldId'] = (string) $data;
                }
            }
            if (!isset($this->data['fields']['fieldId'])) {
                $this->data['fields']['fieldId'] = null;
            }
        }

        return $this->data['fields']['fieldId'];
    }

    /**
     * Set the "type" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\ContentField The document (fluent interface).
     */
    public function setType($value)
    {
        if (!isset($this->data['fields']['type'])) {
            if (($rap = $this->getRootAndPath()) && !$rap['root']->isNew()) {
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

        if (!isset($this->fieldsModified['type']) && !array_key_exists('type', $this->fieldsModified)) {
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
            if ((!isset($this->data['fields']) || !array_key_exists('type', $this->data['fields']))
                && ($rap = $this->getRootAndPath())
                && !$this->isEmbeddedOneChangedInParent()
                && !$this->isEmbeddedManyNew()) {
                $field = $rap['path'].'.type';
                $rap['root']->addFieldCache($field);
                $collection = $this->getMandango()->getRepository(get_class($rap['root']))->getCollection();
                $data = $collection->findOne(array('_id' => $rap['root']->getId()), array($field => 1));
                foreach (explode('.', $field) as $key) {
                    if (!isset($data[$key])) {
                        $data = null;
                        break;
                    }
                    $data = $data[$key];
                }
                if (null !== $data) {
                    $this->data['fields']['type'] = (string) $data;
                }
            }
            if (!isset($this->data['fields']['type'])) {
                $this->data['fields']['type'] = null;
            }
        }

        return $this->data['fields']['type'];
    }

    /**
     * Set the "options" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\ContentField The document (fluent interface).
     */
    public function setOptions($value)
    {
        if (!isset($this->data['fields']['options'])) {
            if (($rap = $this->getRootAndPath()) && !$rap['root']->isNew()) {
                $this->getOptions();
                if ($this->isFieldEqualTo('options', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['options'] = null;
                $this->data['fields']['options'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('options', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['options']) && !array_key_exists('options', $this->fieldsModified)) {
            $this->fieldsModified['options'] = $this->data['fields']['options'];
        } elseif ($this->isFieldModifiedEqualTo('options', $value)) {
            unset($this->fieldsModified['options']);
        }

        $this->data['fields']['options'] = $value;

        return $this;
    }

    /**
     * Returns the "options" field.
     *
     * @return mixed The $name field.
     */
    public function getOptions()
    {
        if (!isset($this->data['fields']['options'])) {
            if ((!isset($this->data['fields']) || !array_key_exists('options', $this->data['fields']))
                && ($rap = $this->getRootAndPath())
                && !$this->isEmbeddedOneChangedInParent()
                && !$this->isEmbeddedManyNew()) {
                $field = $rap['path'].'.options';
                $rap['root']->addFieldCache($field);
                $collection = $this->getMandango()->getRepository(get_class($rap['root']))->getCollection();
                $data = $collection->findOne(array('_id' => $rap['root']->getId()), array($field => 1));
                foreach (explode('.', $field) as $key) {
                    if (!isset($data[$key])) {
                        $data = null;
                        break;
                    }
                    $data = $data[$key];
                }
                if (null !== $data) {
                    $this->data['fields']['options'] = unserialize($data);
                }
            }
            if (!isset($this->data['fields']['options'])) {
                $this->data['fields']['options'] = null;
            }
        }

        return $this->data['fields']['options'];
    }

    /**
     * Set the "mandatory" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\ContentField The document (fluent interface).
     */
    public function setMandatory($value)
    {
        if (!isset($this->data['fields']['mandatory'])) {
            if (($rap = $this->getRootAndPath()) && !$rap['root']->isNew()) {
                $this->getMandatory();
                if ($this->isFieldEqualTo('mandatory', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['mandatory'] = null;
                $this->data['fields']['mandatory'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('mandatory', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['mandatory']) && !array_key_exists('mandatory', $this->fieldsModified)) {
            $this->fieldsModified['mandatory'] = $this->data['fields']['mandatory'];
        } elseif ($this->isFieldModifiedEqualTo('mandatory', $value)) {
            unset($this->fieldsModified['mandatory']);
        }

        $this->data['fields']['mandatory'] = $value;

        return $this;
    }

    /**
     * Returns the "mandatory" field.
     *
     * @return mixed The $name field.
     */
    public function getMandatory()
    {
        if (!isset($this->data['fields']['mandatory'])) {
            if ((!isset($this->data['fields']) || !array_key_exists('mandatory', $this->data['fields']))
                && ($rap = $this->getRootAndPath())
                && !$this->isEmbeddedOneChangedInParent()
                && !$this->isEmbeddedManyNew()) {
                $field = $rap['path'].'.mandatory';
                $rap['root']->addFieldCache($field);
                $collection = $this->getMandango()->getRepository(get_class($rap['root']))->getCollection();
                $data = $collection->findOne(array('_id' => $rap['root']->getId()), array($field => 1));
                foreach (explode('.', $field) as $key) {
                    if (!isset($data[$key])) {
                        $data = null;
                        break;
                    }
                    $data = $data[$key];
                }
                if (null !== $data) {
                    $this->data['fields']['mandatory'] = (bool) $data;
                }
            }
            if (!isset($this->data['fields']['mandatory'])) {
                $this->data['fields']['mandatory'] = null;
            }
        }

        return $this->data['fields']['mandatory'];
    }

    /**
     * Set the "searchable" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\ContentField The document (fluent interface).
     */
    public function setSearchable($value)
    {
        if (!isset($this->data['fields']['searchable'])) {
            if (($rap = $this->getRootAndPath()) && !$rap['root']->isNew()) {
                $this->getSearchable();
                if ($this->isFieldEqualTo('searchable', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['searchable'] = null;
                $this->data['fields']['searchable'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('searchable', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['searchable']) && !array_key_exists('searchable', $this->fieldsModified)) {
            $this->fieldsModified['searchable'] = $this->data['fields']['searchable'];
        } elseif ($this->isFieldModifiedEqualTo('searchable', $value)) {
            unset($this->fieldsModified['searchable']);
        }

        $this->data['fields']['searchable'] = $value;

        return $this;
    }

    /**
     * Returns the "searchable" field.
     *
     * @return mixed The $name field.
     */
    public function getSearchable()
    {
        if (!isset($this->data['fields']['searchable'])) {
            if ((!isset($this->data['fields']) || !array_key_exists('searchable', $this->data['fields']))
                && ($rap = $this->getRootAndPath())
                && !$this->isEmbeddedOneChangedInParent()
                && !$this->isEmbeddedManyNew()) {
                $field = $rap['path'].'.searchable';
                $rap['root']->addFieldCache($field);
                $collection = $this->getMandango()->getRepository(get_class($rap['root']))->getCollection();
                $data = $collection->findOne(array('_id' => $rap['root']->getId()), array($field => 1));
                foreach (explode('.', $field) as $key) {
                    if (!isset($data[$key])) {
                        $data = null;
                        break;
                    }
                    $data = $data[$key];
                }
                if (null !== $data) {
                    $this->data['fields']['searchable'] = (bool) $data;
                }
            }
            if (!isset($this->data['fields']['searchable'])) {
                $this->data['fields']['searchable'] = null;
            }
        }

        return $this->data['fields']['searchable'];
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
        if ('fieldId' == $name) {
            return $this->setFieldId($value);
        }
        if ('type' == $name) {
            return $this->setType($value);
        }
        if ('options' == $name) {
            return $this->setOptions($value);
        }
        if ('mandatory' == $name) {
            return $this->setMandatory($value);
        }
        if ('searchable' == $name) {
            return $this->setSearchable($value);
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
        if ('fieldId' == $name) {
            return $this->getFieldId();
        }
        if ('type' == $name) {
            return $this->getType();
        }
        if ('options' == $name) {
            return $this->getOptions();
        }
        if ('mandatory' == $name) {
            return $this->getMandatory();
        }
        if ('searchable' == $name) {
            return $this->getSearchable();
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Model\PHPOrchestraCMSBundle\ContentField The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['fieldId'])) {
            $this->setFieldId($array['fieldId']);
        }
        if (isset($array['type'])) {
            $this->setType($array['type']);
        }
        if (isset($array['options'])) {
            $this->setOptions($array['options']);
        }
        if (isset($array['mandatory'])) {
            $this->setMandatory($array['mandatory']);
        }
        if (isset($array['searchable'])) {
            $this->setSearchable($array['searchable']);
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
        $array = array();

        $array['fieldId'] = $this->getFieldId();
        $array['type'] = $this->getType();
        $array['options'] = $this->getOptions();
        $array['mandatory'] = $this->getMandatory();
        $array['searchable'] = $this->getSearchable();

        return $array;
    }

    /**
     * Query for save.
     */
    public function queryForSave($query, $isNew, $reset = false)
    {
        if (isset($this->data['fields'])) {
            if ($isNew || $reset) {
                $rootQuery = $query;
                $query =& $rootQuery;
                $rap = $this->getRootAndPath();
                if (true === $reset) {
                    $path = array('$set', $rap['path']);
                } elseif ('deep' == $reset) {
                    $path = explode('.', '$set.'.$rap['path']);
                } else {
                    $path = explode('.', $rap['path']);
                }
                foreach ($path as $name) {
                    if (0 === strpos($name, '_add')) {
                        $name = substr($name, 4);
                    }
                    if (!isset($query[$name])) {
                        $query[$name] = array();
                    }
                    $query =& $query[$name];
                }
                if (isset($this->data['fields']['fieldId'])) {
                    $query['fieldId'] = (string) $this->data['fields']['fieldId'];
                }
                if (isset($this->data['fields']['type'])) {
                    $query['type'] = (string) $this->data['fields']['type'];
                }
                if (isset($this->data['fields']['options'])) {
                    $query['options'] = serialize($this->data['fields']['options']);
                }
                if (isset($this->data['fields']['mandatory'])) {
                    $query['mandatory'] = (bool) $this->data['fields']['mandatory'];
                }
                if (isset($this->data['fields']['searchable'])) {
                    $query['searchable'] = (bool) $this->data['fields']['searchable'];
                }
                unset($query);
                $query = $rootQuery;
            } else {
                $rap = $this->getRootAndPath();
                $documentPath = $rap['path'];
                if (isset($this->data['fields']['fieldId'])
                    || array_key_exists('fieldId', $this->data['fields'])) {
                    $value = $this->data['fields']['fieldId'];
                    $originalValue = $this->getOriginalFieldValue('fieldId');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set'][$documentPath.'.fieldId'] = (string) $this->data['fields']['fieldId'];
                        } else {
                            $query['$unset'][$documentPath.'.fieldId'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['type'])
                    || array_key_exists('type', $this->data['fields'])) {
                    $value = $this->data['fields']['type'];
                    $originalValue = $this->getOriginalFieldValue('type');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set'][$documentPath.'.type'] = (string) $this->data['fields']['type'];
                        } else {
                            $query['$unset'][$documentPath.'.type'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['options'])
                    || array_key_exists('options', $this->data['fields'])) {
                    $value = $this->data['fields']['options'];
                    $originalValue = $this->getOriginalFieldValue('options');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set'][$documentPath.'.options'] = serialize($this->data['fields']['options']);
                        } else {
                            $query['$unset'][$documentPath.'.options'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['mandatory'])
                    || array_key_exists('mandatory', $this->data['fields'])) {
                    $value = $this->data['fields']['mandatory'];
                    $originalValue = $this->getOriginalFieldValue('mandatory');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set'][$documentPath.'.mandatory'] = (bool) $this->data['fields']['mandatory'];
                        } else {
                            $query['$unset'][$documentPath.'.mandatory'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['searchable'])
                    || array_key_exists('searchable', $this->data['fields'])) {
                    $value = $this->data['fields']['searchable'];
                    $originalValue = $this->getOriginalFieldValue('searchable');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set'][$documentPath.'.searchable'] = (bool) $this->data['fields']['searchable'];
                        } else {
                            $query['$unset'][$documentPath.'.searchable'] = 1;
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
