<?php

namespace Model\PHPOrchestraCMSBundle\Base;

/**
 * Base class of Model\PHPOrchestraCMSBundle\Area document.
 */
abstract class Area extends \Mandango\Document\EmbeddedDocument
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
     * @return \Model\PHPOrchestraCMSBundle\Area The document (fluent interface).
     */
    public function setDocumentData($data, $clean = false)
    {
        if ($clean) {
            $this->data = array();
            $this->fieldsModified = array();
        }

        if (isset($data['area_id'])) {
            $this->data['fields']['area_id'] = (string) $data['area_id'];
        } elseif (isset($data['_fields']['area_id'])) {
            $this->data['fields']['area_id'] = null;
        }
        if (isset($data['classes'])) {
            $this->data['fields']['classes'] = unserialize($data['classes']);
        } elseif (isset($data['_fields']['classes'])) {
            $this->data['fields']['classes'] = null;
        }
        if (isset($data['blocks'])) {
            $embedded = new \Mandango\Group\EmbeddedGroup('Model\PHPOrchestraCMSBundle\BlockReference');
            if ($rap = $this->getRootAndPath()) {
                $embedded->setRootAndPath($rap['root'], $rap['path'].'.blocks');
            }
            $embedded->setSavedData($data['blocks']);
            $this->data['embeddedsMany']['blocks'] = $embedded;
        }

        return $this;
    }

    /**
     * Set the "area_id" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Area The document (fluent interface).
     */
    public function setArea_id($value)
    {
        if (!isset($this->data['fields']['area_id'])) {
            if (($rap = $this->getRootAndPath()) && !$rap['root']->isNew()) {
                $this->getArea_id();
                if ($this->isFieldEqualTo('area_id', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['area_id'] = null;
                $this->data['fields']['area_id'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('area_id', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['area_id']) && !array_key_exists('area_id', $this->fieldsModified)) {
            $this->fieldsModified['area_id'] = $this->data['fields']['area_id'];
        } elseif ($this->isFieldModifiedEqualTo('area_id', $value)) {
            unset($this->fieldsModified['area_id']);
        }

        $this->data['fields']['area_id'] = $value;

        return $this;
    }

    /**
     * Returns the "area_id" field.
     *
     * @return mixed The $name field.
     */
    public function getArea_id()
    {
        if (!isset($this->data['fields']['area_id'])) {
            if (
                (!isset($this->data['fields']) || !array_key_exists('area_id', $this->data['fields']))
                &&
                ($rap = $this->getRootAndPath())
                &&
                !$this->isEmbeddedOneChangedInParent()
                &&
                !$this->isEmbeddedManyNew()
            ) {
                $field = $rap['path'].'.area_id';
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
                    $this->data['fields']['area_id'] = (string) $data;
                }
            }
            if (!isset($this->data['fields']['area_id'])) {
                $this->data['fields']['area_id'] = null;
            }
        }

        return $this->data['fields']['area_id'];
    }

    /**
     * Set the "classes" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Area The document (fluent interface).
     */
    public function setClasses($value)
    {
        if (!isset($this->data['fields']['classes'])) {
            if (($rap = $this->getRootAndPath()) && !$rap['root']->isNew()) {
                $this->getClasses();
                if ($this->isFieldEqualTo('classes', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['classes'] = null;
                $this->data['fields']['classes'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('classes', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['classes']) && !array_key_exists('classes', $this->fieldsModified)) {
            $this->fieldsModified['classes'] = $this->data['fields']['classes'];
        } elseif ($this->isFieldModifiedEqualTo('classes', $value)) {
            unset($this->fieldsModified['classes']);
        }

        $this->data['fields']['classes'] = $value;

        return $this;
    }

    /**
     * Returns the "classes" field.
     *
     * @return mixed The $name field.
     */
    public function getClasses()
    {
        if (!isset($this->data['fields']['classes'])) {
            if (
                (!isset($this->data['fields']) || !array_key_exists('classes', $this->data['fields']))
                &&
                ($rap = $this->getRootAndPath())
                &&
                !$this->isEmbeddedOneChangedInParent()
                &&
                !$this->isEmbeddedManyNew()
            ) {
                $field = $rap['path'].'.classes';
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
                    $this->data['fields']['classes'] = unserialize($data);
                }
            }
            if (!isset($this->data['fields']['classes'])) {
                $this->data['fields']['classes'] = null;
            }
        }

        return $this->data['fields']['classes'];
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
            $this->data['embeddedsMany']['blocks'] = $embedded = new \Mandango\Group\EmbeddedGroup('Model\PHPOrchestraCMSBundle\BlockReference');
            if ($rap = $this->getRootAndPath()) {
                $embedded->setRootAndPath($rap['root'], $rap['path'].'.blocks');
            }
        }

        return $this->data['embeddedsMany']['blocks'];
    }

    /**
     * Adds documents to the "blocks" embeddeds many.
     *
     * @param mixed $documents A document or an array or documents.
     *
     * @return \Model\PHPOrchestraCMSBundle\Area The document (fluent interface).
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
     * @return \Model\PHPOrchestraCMSBundle\Area The document (fluent interface).
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
        if ('area_id' == $name) {
            return $this->setArea_id($value);
        }
        if ('classes' == $name) {
            return $this->setClasses($value);
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
        if ('area_id' == $name) {
            return $this->getArea_id();
        }
        if ('classes' == $name) {
            return $this->getClasses();
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
     * @return \Model\PHPOrchestraCMSBundle\Area The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['area_id'])) {
            $this->setArea_id($array['area_id']);
        }
        if (isset($array['classes'])) {
            $this->setClasses($array['classes']);
        }
        if (isset($array['blocks'])) {
            $embeddeds = array();
            foreach ($array['blocks'] as $documentData) {
                $embeddeds[] = $embedded = new \Model\PHPOrchestraCMSBundle\BlockReference($this->getMandango());
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
        $array = array();

        $array['area_id'] = $this->getArea_id();
        $array['classes'] = $this->getClasses();

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
                if (isset($this->data['fields']['area_id'])) {
                    $query['area_id'] = (string) $this->data['fields']['area_id'];
                }
                if (isset($this->data['fields']['classes'])) {
                    $query['classes'] = serialize($this->data['fields']['classes']);
                }
                unset($query);
                $query = $rootQuery;
            } else {
                $rap = $this->getRootAndPath();
                $documentPath = $rap['path'];
                if (isset($this->data['fields']['area_id']) || array_key_exists('area_id', $this->data['fields'])) {
                    $value = $this->data['fields']['area_id'];
                    $originalValue = $this->getOriginalFieldValue('area_id');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set'][$documentPath.'.area_id'] = (string) $this->data['fields']['area_id'];
                        } else {
                            $query['$unset'][$documentPath.'.area_id'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['classes']) || array_key_exists('classes', $this->data['fields'])) {
                    $value = $this->data['fields']['classes'];
                    $originalValue = $this->getOriginalFieldValue('classes');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set'][$documentPath.'.classes'] = serialize($this->data['fields']['classes']);
                        } else {
                            $query['$unset'][$documentPath.'.classes'] = 1;
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