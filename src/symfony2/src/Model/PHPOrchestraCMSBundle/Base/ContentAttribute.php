<?php

namespace Model\PHPOrchestraCMSBundle\Base;

/**
 * Base class of Model\PHPOrchestraCMSBundle\ContentAttribute document.
 */
abstract class ContentAttribute extends \Mandango\Document\EmbeddedDocument
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
            if (($rap = $this->getRootAndPath()) && !$rap['root']->isNew()) {
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
            if ((!isset($this->data['fields']) || !array_key_exists('name', $this->data['fields']))
                && ($rap = $this->getRootAndPath())
                && !$this->isEmbeddedOneChangedInParent()
                && !$this->isEmbeddedManyNew()) {
                $field = $rap['path'].'.name';
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
                    $this->data['fields']['name'] = (string) $data;
                }
            }
            if (!isset($this->data['fields']['name'])) {
                $this->data['fields']['name'] = null;
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
            if (($rap = $this->getRootAndPath()) && !$rap['root']->isNew()) {
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
            if ((!isset($this->data['fields']) || !array_key_exists('value', $this->data['fields']))
                && ($rap = $this->getRootAndPath())
                && !$this->isEmbeddedOneChangedInParent()
                && !$this->isEmbeddedManyNew()) {
                $field = $rap['path'].'.value';
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
                    $this->data['fields']['value'] = (string) $data;
                }
            }
            if (!isset($this->data['fields']['value'])) {
                $this->data['fields']['value'] = null;
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
        $array = array();

        $array['name'] = $this->getName();
        $array['value'] = $this->getValue();

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
                if (isset($this->data['fields']['name'])) {
                    $query['name'] = (string) $this->data['fields']['name'];
                }
                if (isset($this->data['fields']['value'])) {
                    $query['value'] = (string) $this->data['fields']['value'];
                }
                unset($query);
                $query = $rootQuery;
            } else {
                $rap = $this->getRootAndPath();
                $documentPath = $rap['path'];
                if (isset($this->data['fields']['name'])
                    || array_key_exists('name', $this->data['fields'])) {
                    $value = $this->data['fields']['name'];
                    $originalValue = $this->getOriginalFieldValue('name');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set'][$documentPath.'.name'] = (string) $this->data['fields']['name'];
                        } else {
                            $query['$unset'][$documentPath.'.name'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['value'])
                    || array_key_exists('value', $this->data['fields'])) {
                    $value = $this->data['fields']['value'];
                    $originalValue = $this->getOriginalFieldValue('value');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set'][$documentPath.'.value'] = (string) $this->data['fields']['value'];
                        } else {
                            $query['$unset'][$documentPath.'.value'] = 1;
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
