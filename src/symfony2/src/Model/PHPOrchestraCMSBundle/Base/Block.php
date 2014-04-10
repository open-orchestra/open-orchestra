<?php

namespace Model\PHPOrchestraCMSBundle\Base;

/**
 * Base class of Model\PHPOrchestraCMSBundle\Block document.
 */
abstract class Block extends \Mandango\Document\EmbeddedDocument
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
     * @return \Model\PHPOrchestraCMSBundle\Block The document (fluent interface).
     */
    public function setDocumentData($data, $clean = false)
    {
        if ($clean) {
            $this->data = array();
            $this->fieldsModified = array();
        }

        if (isset($data['component'])) {
            $this->data['fields']['component'] = (string) $data['component'];
        } elseif (isset($data['_fields']['component'])) {
            $this->data['fields']['component'] = null;
        }
        if (isset($data['attributes'])) {
            $this->data['fields']['attributes'] = $data['attributes'];
        } elseif (isset($data['_fields']['attributes'])) {
            $this->data['fields']['attributes'] = null;
        }

        return $this;
    }

    /**
     * Set the "component" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Block The document (fluent interface).
     */
    public function setComponent($value)
    {
        if (!isset($this->data['fields']['component'])) {
            if (($rap = $this->getRootAndPath()) && !$rap['root']->isNew()) {
                $this->getComponent();
                if ($this->isFieldEqualTo('component', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['component'] = null;
                $this->data['fields']['component'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('component', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['component']) && !array_key_exists('component', $this->fieldsModified)) {
            $this->fieldsModified['component'] = $this->data['fields']['component'];
        } elseif ($this->isFieldModifiedEqualTo('component', $value)) {
            unset($this->fieldsModified['component']);
        }

        $this->data['fields']['component'] = $value;

        return $this;
    }

    /**
     * Returns the "component" field.
     *
     * @return mixed The $name field.
     */
    public function getComponent()
    {
        if (!isset($this->data['fields']['component'])) {
            if (
                (!isset($this->data['fields']) || !array_key_exists('component', $this->data['fields']))
                &&
                ($rap = $this->getRootAndPath())
                &&
                !$this->isEmbeddedOneChangedInParent()
                &&
                !$this->isEmbeddedManyNew()
            ) {
                $field = $rap['path'].'.component';
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
                    $this->data['fields']['component'] = (string) $data;
                }
            }
            if (!isset($this->data['fields']['component'])) {
                $this->data['fields']['component'] = null;
            }
        }

        return $this->data['fields']['component'];
    }

    /**
     * Set the "attributes" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Block The document (fluent interface).
     */
    public function setAttributes($value)
    {
        if (!isset($this->data['fields']['attributes'])) {
            if (($rap = $this->getRootAndPath()) && !$rap['root']->isNew()) {
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

        if (!isset($this->fieldsModified['attributes']) && !array_key_exists('attributes', $this->fieldsModified)) {
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
            if (
                (!isset($this->data['fields']) || !array_key_exists('attributes', $this->data['fields']))
                &&
                ($rap = $this->getRootAndPath())
                &&
                !$this->isEmbeddedOneChangedInParent()
                &&
                !$this->isEmbeddedManyNew()
            ) {
                $field = $rap['path'].'.attributes';
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
                    $this->data['fields']['attributes'] = $data;
                }
            }
            if (!isset($this->data['fields']['attributes'])) {
                $this->data['fields']['attributes'] = null;
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
        if ('component' == $name) {
            return $this->setComponent($value);
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
        if ('component' == $name) {
            return $this->getComponent();
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
     * @return \Model\PHPOrchestraCMSBundle\Block The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['component'])) {
            $this->setComponent($array['component']);
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
        $array = array();

        $array['component'] = $this->getComponent();
        $array['attributes'] = $this->getAttributes();

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
                if (isset($this->data['fields']['component'])) {
                    $query['component'] = (string) $this->data['fields']['component'];
                }
                if (isset($this->data['fields']['attributes'])) {
                    $query['attributes'] = $this->data['fields']['attributes'];
                }
                unset($query);
                $query = $rootQuery;
            } else {
                $rap = $this->getRootAndPath();
                $documentPath = $rap['path'];
                if (isset($this->data['fields']['component']) || array_key_exists('component', $this->data['fields'])) {
                    $value = $this->data['fields']['component'];
                    $originalValue = $this->getOriginalFieldValue('component');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set'][$documentPath.'.component'] = (string) $this->data['fields']['component'];
                        } else {
                            $query['$unset'][$documentPath.'.component'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['attributes']) || array_key_exists('attributes', $this->data['fields'])) {
                    $value = $this->data['fields']['attributes'];
                    $originalValue = $this->getOriginalFieldValue('attributes');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set'][$documentPath.'.attributes'] = $this->data['fields']['attributes'];
                        } else {
                            $query['$unset'][$documentPath.'.attributes'] = 1;
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