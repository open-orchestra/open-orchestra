<?php

namespace Model\PHPOrchestraCMSBundle\Base;

/**
 * Base class of Model\PHPOrchestraCMSBundle\BlockReference document.
 */
abstract class BlockReference extends \Mandango\Document\EmbeddedDocument
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
     * @return \Model\PHPOrchestraCMSBundle\BlockReference The document (fluent interface).
     */
    public function setDocumentData($data, $clean = false)
    {
        if ($clean) {
            $this->data = array();
            $this->fieldsModified = array();
        }

        if (isset($data['node_id'])) {
            $this->data['fields']['node_id'] = (int) $data['node_id'];
        } elseif (isset($data['_fields']['node_id'])) {
            $this->data['fields']['node_id'] = null;
        }
        if (isset($data['block_id'])) {
            $this->data['fields']['block_id'] = (int) $data['block_id'];
        } elseif (isset($data['_fields']['block_id'])) {
            $this->data['fields']['block_id'] = null;
        }

        return $this;
    }

    /**
     * Set the "node_id" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\BlockReference The document (fluent interface).
     */
    public function setNode_id($value)
    {
        if (!isset($this->data['fields']['node_id'])) {
            if (($rap = $this->getRootAndPath()) && !$rap['root']->isNew()) {
                $this->getNode_id();
                if ($this->isFieldEqualTo('node_id', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['node_id'] = null;
                $this->data['fields']['node_id'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('node_id', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['node_id']) && !array_key_exists('node_id', $this->fieldsModified)) {
            $this->fieldsModified['node_id'] = $this->data['fields']['node_id'];
        } elseif ($this->isFieldModifiedEqualTo('node_id', $value)) {
            unset($this->fieldsModified['node_id']);
        }

        $this->data['fields']['node_id'] = $value;

        return $this;
    }

    /**
     * Returns the "node_id" field.
     *
     * @return mixed The $name field.
     */
    public function getNode_id()
    {
        if (!isset($this->data['fields']['node_id'])) {
            if (
                (!isset($this->data['fields']) || !array_key_exists('node_id', $this->data['fields']))
                &&
                ($rap = $this->getRootAndPath())
                &&
                !$this->isEmbeddedOneChangedInParent()
                &&
                !$this->isEmbeddedManyNew()
            ) {
                $field = $rap['path'].'.node_id';
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
                    $this->data['fields']['node_id'] = (int) $data;
                }
            }
            if (!isset($this->data['fields']['node_id'])) {
                $this->data['fields']['node_id'] = null;
            }
        }

        return $this->data['fields']['node_id'];
    }

    /**
     * Set the "block_id" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\BlockReference The document (fluent interface).
     */
    public function setBlock_id($value)
    {
        if (!isset($this->data['fields']['block_id'])) {
            if (($rap = $this->getRootAndPath()) && !$rap['root']->isNew()) {
                $this->getBlock_id();
                if ($this->isFieldEqualTo('block_id', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['block_id'] = null;
                $this->data['fields']['block_id'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('block_id', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['block_id']) && !array_key_exists('block_id', $this->fieldsModified)) {
            $this->fieldsModified['block_id'] = $this->data['fields']['block_id'];
        } elseif ($this->isFieldModifiedEqualTo('block_id', $value)) {
            unset($this->fieldsModified['block_id']);
        }

        $this->data['fields']['block_id'] = $value;

        return $this;
    }

    /**
     * Returns the "block_id" field.
     *
     * @return mixed The $name field.
     */
    public function getBlock_id()
    {
        if (!isset($this->data['fields']['block_id'])) {
            if (
                (!isset($this->data['fields']) || !array_key_exists('block_id', $this->data['fields']))
                &&
                ($rap = $this->getRootAndPath())
                &&
                !$this->isEmbeddedOneChangedInParent()
                &&
                !$this->isEmbeddedManyNew()
            ) {
                $field = $rap['path'].'.block_id';
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
                    $this->data['fields']['block_id'] = (int) $data;
                }
            }
            if (!isset($this->data['fields']['block_id'])) {
                $this->data['fields']['block_id'] = null;
            }
        }

        return $this->data['fields']['block_id'];
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
        if ('node_id' == $name) {
            return $this->setNode_id($value);
        }
        if ('block_id' == $name) {
            return $this->setBlock_id($value);
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
        if ('node_id' == $name) {
            return $this->getNode_id();
        }
        if ('block_id' == $name) {
            return $this->getBlock_id();
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Model\PHPOrchestraCMSBundle\BlockReference The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['node_id'])) {
            $this->setNode_id($array['node_id']);
        }
        if (isset($array['block_id'])) {
            $this->setBlock_id($array['block_id']);
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

        $array['node_id'] = $this->getNode_id();
        $array['block_id'] = $this->getBlock_id();

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
                if (isset($this->data['fields']['node_id'])) {
                    $query['node_id'] = (int) $this->data['fields']['node_id'];
                }
                if (isset($this->data['fields']['block_id'])) {
                    $query['block_id'] = (int) $this->data['fields']['block_id'];
                }
                unset($query);
                $query = $rootQuery;
            } else {
                $rap = $this->getRootAndPath();
                $documentPath = $rap['path'];
                if (isset($this->data['fields']['node_id']) || array_key_exists('node_id', $this->data['fields'])) {
                    $value = $this->data['fields']['node_id'];
                    $originalValue = $this->getOriginalFieldValue('node_id');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set'][$documentPath.'.node_id'] = (int) $this->data['fields']['node_id'];
                        } else {
                            $query['$unset'][$documentPath.'.node_id'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['block_id']) || array_key_exists('block_id', $this->data['fields'])) {
                    $value = $this->data['fields']['block_id'];
                    $originalValue = $this->getOriginalFieldValue('block_id');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set'][$documentPath.'.block_id'] = (int) $this->data['fields']['block_id'];
                        } else {
                            $query['$unset'][$documentPath.'.block_id'] = 1;
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