<?php

namespace Model\PHPOrchestraCMSBundle\Base;

/**
 * Base class of Model\PHPOrchestraCMSBundle\Node document.
 */
abstract class Node extends \Mandango\Document\Document
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
     * @return \Model\PHPOrchestraCMSBundle\Node The document (fluent interface).
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
        if (isset($data['node_id'])) {
            $this->data['fields']['node_id'] = (int) $data['node_id'];
        } elseif (isset($data['_fields']['node_id'])) {
            $this->data['fields']['node_id'] = null;
        }
        if (isset($data['site_id'])) {
            $this->data['fields']['site_id'] = (int) $data['site_id'];
        } elseif (isset($data['_fields']['site_id'])) {
            $this->data['fields']['site_id'] = null;
        }
        if (isset($data['parent_id'])) {
            $this->data['fields']['parent_id'] = (int) $data['parent_id'];
        } elseif (isset($data['_fields']['parent_id'])) {
            $this->data['fields']['parent_id'] = null;
        }
        if (isset($data['path'])) {
            $this->data['fields']['path'] = (string) $data['path'];
        } elseif (isset($data['_fields']['path'])) {
            $this->data['fields']['path'] = null;
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
        if (isset($data['language'])) {
            $this->data['fields']['language'] = (string) $data['language'];
        } elseif (isset($data['_fields']['language'])) {
            $this->data['fields']['language'] = null;
        }
        if (isset($data['status'])) {
            $this->data['fields']['status'] = (string) $data['status'];
        } elseif (isset($data['_fields']['status'])) {
            $this->data['fields']['status'] = null;
        }
        if (isset($data['template_id'])) {
            $this->data['fields']['template_id'] = (int) $data['template_id'];
        } elseif (isset($data['_fields']['template_id'])) {
            $this->data['fields']['template_id'] = null;
        }
        if (isset($data['areas'])) {
            $this->data['fields']['areas'] = $data['areas'];
        } elseif (isset($data['_fields']['areas'])) {
            $this->data['fields']['areas'] = null;
        }
        if (isset($data['blocks'])) {
            $embedded = new \Mandango\Group\EmbeddedGroup('Model\PHPOrchestraCMSBundle\Block');
            $embedded->setRootAndPath($this, 'blocks');
            $embedded->setSavedData($data['blocks']);
            $this->data['embeddedsMany']['blocks'] = $embedded;
        }

        return $this;
    }

    /**
     * Set the "node_id" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Node The document (fluent interface).
     */
    public function setNode_id($value)
    {
        if (!isset($this->data['fields']['node_id'])) {
            if (!$this->isNew()) {
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
            if ($this->isNew()) {
                $this->data['fields']['node_id'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('node_id', $this->data['fields'])) {
                $this->addFieldCache('node_id');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('node_id' => 1));
                if (isset($data['node_id'])) {
                    $this->data['fields']['node_id'] = (int) $data['node_id'];
                } else {
                    $this->data['fields']['node_id'] = null;
                }
            }
        }

        return $this->data['fields']['node_id'];
    }

    /**
     * Set the "site_id" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Node The document (fluent interface).
     */
    public function setSite_id($value)
    {
        if (!isset($this->data['fields']['site_id'])) {
            if (!$this->isNew()) {
                $this->getSite_id();
                if ($this->isFieldEqualTo('site_id', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['site_id'] = null;
                $this->data['fields']['site_id'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('site_id', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['site_id']) && !array_key_exists('site_id', $this->fieldsModified)) {
            $this->fieldsModified['site_id'] = $this->data['fields']['site_id'];
        } elseif ($this->isFieldModifiedEqualTo('site_id', $value)) {
            unset($this->fieldsModified['site_id']);
        }

        $this->data['fields']['site_id'] = $value;

        return $this;
    }

    /**
     * Returns the "site_id" field.
     *
     * @return mixed The $name field.
     */
    public function getSite_id()
    {
        if (!isset($this->data['fields']['site_id'])) {
            if ($this->isNew()) {
                $this->data['fields']['site_id'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('site_id', $this->data['fields'])) {
                $this->addFieldCache('site_id');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('site_id' => 1));
                if (isset($data['site_id'])) {
                    $this->data['fields']['site_id'] = (int) $data['site_id'];
                } else {
                    $this->data['fields']['site_id'] = null;
                }
            }
        }

        return $this->data['fields']['site_id'];
    }

    /**
     * Set the "parent_id" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Node The document (fluent interface).
     */
    public function setParent_id($value)
    {
        if (!isset($this->data['fields']['parent_id'])) {
            if (!$this->isNew()) {
                $this->getParent_id();
                if ($this->isFieldEqualTo('parent_id', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['parent_id'] = null;
                $this->data['fields']['parent_id'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('parent_id', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['parent_id']) && !array_key_exists('parent_id', $this->fieldsModified)) {
            $this->fieldsModified['parent_id'] = $this->data['fields']['parent_id'];
        } elseif ($this->isFieldModifiedEqualTo('parent_id', $value)) {
            unset($this->fieldsModified['parent_id']);
        }

        $this->data['fields']['parent_id'] = $value;

        return $this;
    }

    /**
     * Returns the "parent_id" field.
     *
     * @return mixed The $name field.
     */
    public function getParent_id()
    {
        if (!isset($this->data['fields']['parent_id'])) {
            if ($this->isNew()) {
                $this->data['fields']['parent_id'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('parent_id', $this->data['fields'])) {
                $this->addFieldCache('parent_id');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('parent_id' => 1));
                if (isset($data['parent_id'])) {
                    $this->data['fields']['parent_id'] = (int) $data['parent_id'];
                } else {
                    $this->data['fields']['parent_id'] = null;
                }
            }
        }

        return $this->data['fields']['parent_id'];
    }

    /**
     * Set the "path" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Node The document (fluent interface).
     */
    public function setPath($value)
    {
        if (!isset($this->data['fields']['path'])) {
            if (!$this->isNew()) {
                $this->getPath();
                if ($this->isFieldEqualTo('path', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['path'] = null;
                $this->data['fields']['path'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('path', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['path']) && !array_key_exists('path', $this->fieldsModified)) {
            $this->fieldsModified['path'] = $this->data['fields']['path'];
        } elseif ($this->isFieldModifiedEqualTo('path', $value)) {
            unset($this->fieldsModified['path']);
        }

        $this->data['fields']['path'] = $value;

        return $this;
    }

    /**
     * Returns the "path" field.
     *
     * @return mixed The $name field.
     */
    public function getPath()
    {
        if (!isset($this->data['fields']['path'])) {
            if ($this->isNew()) {
                $this->data['fields']['path'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('path', $this->data['fields'])) {
                $this->addFieldCache('path');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('path' => 1));
                if (isset($data['path'])) {
                    $this->data['fields']['path'] = (string) $data['path'];
                } else {
                    $this->data['fields']['path'] = null;
                }
            }
        }

        return $this->data['fields']['path'];
    }

    /**
     * Set the "name" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Node The document (fluent interface).
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
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('name' => 1));
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
     * @return \Model\PHPOrchestraCMSBundle\Node The document (fluent interface).
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
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('version' => 1));
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
     * Set the "language" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Node The document (fluent interface).
     */
    public function setLanguage($value)
    {
        if (!isset($this->data['fields']['language'])) {
            if (!$this->isNew()) {
                $this->getLanguage();
                if ($this->isFieldEqualTo('language', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['language'] = null;
                $this->data['fields']['language'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('language', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['language']) && !array_key_exists('language', $this->fieldsModified)) {
            $this->fieldsModified['language'] = $this->data['fields']['language'];
        } elseif ($this->isFieldModifiedEqualTo('language', $value)) {
            unset($this->fieldsModified['language']);
        }

        $this->data['fields']['language'] = $value;

        return $this;
    }

    /**
     * Returns the "language" field.
     *
     * @return mixed The $name field.
     */
    public function getLanguage()
    {
        if (!isset($this->data['fields']['language'])) {
            if ($this->isNew()) {
                $this->data['fields']['language'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('language', $this->data['fields'])) {
                $this->addFieldCache('language');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('language' => 1));
                if (isset($data['language'])) {
                    $this->data['fields']['language'] = (string) $data['language'];
                } else {
                    $this->data['fields']['language'] = null;
                }
            }
        }

        return $this->data['fields']['language'];
    }

    /**
     * Set the "status" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Node The document (fluent interface).
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
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('status' => 1));
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
     * Set the "template_id" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Node The document (fluent interface).
     */
    public function setTemplate_id($value)
    {
        if (!isset($this->data['fields']['template_id'])) {
            if (!$this->isNew()) {
                $this->getTemplate_id();
                if ($this->isFieldEqualTo('template_id', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['template_id'] = null;
                $this->data['fields']['template_id'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('template_id', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['template_id']) && !array_key_exists('template_id', $this->fieldsModified)) {
            $this->fieldsModified['template_id'] = $this->data['fields']['template_id'];
        } elseif ($this->isFieldModifiedEqualTo('template_id', $value)) {
            unset($this->fieldsModified['template_id']);
        }

        $this->data['fields']['template_id'] = $value;

        return $this;
    }

    /**
     * Returns the "template_id" field.
     *
     * @return mixed The $name field.
     */
    public function getTemplate_id()
    {
        if (!isset($this->data['fields']['template_id'])) {
            if ($this->isNew()) {
                $this->data['fields']['template_id'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('template_id', $this->data['fields'])) {
                $this->addFieldCache('template_id');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('template_id' => 1));
                if (isset($data['template_id'])) {
                    $this->data['fields']['template_id'] = (int) $data['template_id'];
                } else {
                    $this->data['fields']['template_id'] = null;
                }
            }
        }

        return $this->data['fields']['template_id'];
    }

    /**
     * Set the "areas" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Node The document (fluent interface).
     */
    public function setAreas($value)
    {
        if (!isset($this->data['fields']['areas'])) {
            if (!$this->isNew()) {
                $this->getAreas();
                if ($this->isFieldEqualTo('areas', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['areas'] = null;
                $this->data['fields']['areas'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('areas', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['areas']) && !array_key_exists('areas', $this->fieldsModified)) {
            $this->fieldsModified['areas'] = $this->data['fields']['areas'];
        } elseif ($this->isFieldModifiedEqualTo('areas', $value)) {
            unset($this->fieldsModified['areas']);
        }

        $this->data['fields']['areas'] = $value;

        return $this;
    }

    /**
     * Returns the "areas" field.
     *
     * @return mixed The $name field.
     */
    public function getAreas()
    {
        if (!isset($this->data['fields']['areas'])) {
            if ($this->isNew()) {
                $this->data['fields']['areas'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('areas', $this->data['fields'])) {
                $this->addFieldCache('areas');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('areas' => 1));
                if (isset($data['areas'])) {
                    $this->data['fields']['areas'] = $data['areas'];
                } else {
                    $this->data['fields']['areas'] = null;
                }
            }
        }

        return $this->data['fields']['areas'];
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
            $this->data['embeddedsMany']['blocks'] = $embedded = new \Mandango\Group\EmbeddedGroup('Model\PHPOrchestraCMSBundle\Block');
            $embedded->setRootAndPath($this, 'blocks');
        }

        return $this->data['embeddedsMany']['blocks'];
    }

    /**
     * Adds documents to the "blocks" embeddeds many.
     *
     * @param mixed $documents A document or an array or documents.
     *
     * @return \Model\PHPOrchestraCMSBundle\Node The document (fluent interface).
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
     * @return \Model\PHPOrchestraCMSBundle\Node The document (fluent interface).
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
        if ('node_id' == $name) {
            return $this->setNode_id($value);
        }
        if ('site_id' == $name) {
            return $this->setSite_id($value);
        }
        if ('parent_id' == $name) {
            return $this->setParent_id($value);
        }
        if ('path' == $name) {
            return $this->setPath($value);
        }
        if ('name' == $name) {
            return $this->setName($value);
        }
        if ('version' == $name) {
            return $this->setVersion($value);
        }
        if ('language' == $name) {
            return $this->setLanguage($value);
        }
        if ('status' == $name) {
            return $this->setStatus($value);
        }
        if ('template_id' == $name) {
            return $this->setTemplate_id($value);
        }
        if ('areas' == $name) {
            return $this->setAreas($value);
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
        if ('site_id' == $name) {
            return $this->getSite_id();
        }
        if ('parent_id' == $name) {
            return $this->getParent_id();
        }
        if ('path' == $name) {
            return $this->getPath();
        }
        if ('name' == $name) {
            return $this->getName();
        }
        if ('version' == $name) {
            return $this->getVersion();
        }
        if ('language' == $name) {
            return $this->getLanguage();
        }
        if ('status' == $name) {
            return $this->getStatus();
        }
        if ('template_id' == $name) {
            return $this->getTemplate_id();
        }
        if ('areas' == $name) {
            return $this->getAreas();
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
     * @return \Model\PHPOrchestraCMSBundle\Node The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['id'])) {
            $this->setId($array['id']);
        }
        if (isset($array['node_id'])) {
            $this->setNode_id($array['node_id']);
        }
        if (isset($array['site_id'])) {
            $this->setSite_id($array['site_id']);
        }
        if (isset($array['parent_id'])) {
            $this->setParent_id($array['parent_id']);
        }
        if (isset($array['path'])) {
            $this->setPath($array['path']);
        }
        if (isset($array['name'])) {
            $this->setName($array['name']);
        }
        if (isset($array['version'])) {
            $this->setVersion($array['version']);
        }
        if (isset($array['language'])) {
            $this->setLanguage($array['language']);
        }
        if (isset($array['status'])) {
            $this->setStatus($array['status']);
        }
        if (isset($array['template_id'])) {
            $this->setTemplate_id($array['template_id']);
        }
        if (isset($array['areas'])) {
            $this->setAreas($array['areas']);
        }
        if (isset($array['blocks'])) {
            $embeddeds = array();
            foreach ($array['blocks'] as $documentData) {
                $embeddeds[] = $embedded = new \Model\PHPOrchestraCMSBundle\Block($this->getMandango());
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
        $array = array('id' => $this->getId());

        $array['node_id'] = $this->getNode_id();
        $array['site_id'] = $this->getSite_id();
        $array['parent_id'] = $this->getParent_id();
        $array['path'] = $this->getPath();
        $array['name'] = $this->getName();
        $array['version'] = $this->getVersion();
        $array['language'] = $this->getLanguage();
        $array['status'] = $this->getStatus();
        $array['template_id'] = $this->getTemplate_id();
        $array['areas'] = $this->getAreas();

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
                if (isset($this->data['fields']['node_id'])) {
                    $query['node_id'] = (int) $this->data['fields']['node_id'];
                }
                if (isset($this->data['fields']['site_id'])) {
                    $query['site_id'] = (int) $this->data['fields']['site_id'];
                }
                if (isset($this->data['fields']['parent_id'])) {
                    $query['parent_id'] = (int) $this->data['fields']['parent_id'];
                }
                if (isset($this->data['fields']['path'])) {
                    $query['path'] = (string) $this->data['fields']['path'];
                }
                if (isset($this->data['fields']['name'])) {
                    $query['name'] = (string) $this->data['fields']['name'];
                }
                if (isset($this->data['fields']['version'])) {
                    $query['version'] = (int) $this->data['fields']['version'];
                }
                if (isset($this->data['fields']['language'])) {
                    $query['language'] = (string) $this->data['fields']['language'];
                }
                if (isset($this->data['fields']['status'])) {
                    $query['status'] = (string) $this->data['fields']['status'];
                }
                if (isset($this->data['fields']['template_id'])) {
                    $query['template_id'] = (int) $this->data['fields']['template_id'];
                }
                if (isset($this->data['fields']['areas'])) {
                    $query['areas'] = $this->data['fields']['areas'];
                }
            } else {
                if (isset($this->data['fields']['node_id']) || array_key_exists('node_id', $this->data['fields'])) {
                    $value = $this->data['fields']['node_id'];
                    $originalValue = $this->getOriginalFieldValue('node_id');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['node_id'] = (int) $this->data['fields']['node_id'];
                        } else {
                            $query['$unset']['node_id'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['site_id']) || array_key_exists('site_id', $this->data['fields'])) {
                    $value = $this->data['fields']['site_id'];
                    $originalValue = $this->getOriginalFieldValue('site_id');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['site_id'] = (int) $this->data['fields']['site_id'];
                        } else {
                            $query['$unset']['site_id'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['parent_id']) || array_key_exists('parent_id', $this->data['fields'])) {
                    $value = $this->data['fields']['parent_id'];
                    $originalValue = $this->getOriginalFieldValue('parent_id');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['parent_id'] = (int) $this->data['fields']['parent_id'];
                        } else {
                            $query['$unset']['parent_id'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['path']) || array_key_exists('path', $this->data['fields'])) {
                    $value = $this->data['fields']['path'];
                    $originalValue = $this->getOriginalFieldValue('path');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['path'] = (string) $this->data['fields']['path'];
                        } else {
                            $query['$unset']['path'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['name']) || array_key_exists('name', $this->data['fields'])) {
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
                if (isset($this->data['fields']['version']) || array_key_exists('version', $this->data['fields'])) {
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
                if (isset($this->data['fields']['language']) || array_key_exists('language', $this->data['fields'])) {
                    $value = $this->data['fields']['language'];
                    $originalValue = $this->getOriginalFieldValue('language');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['language'] = (string) $this->data['fields']['language'];
                        } else {
                            $query['$unset']['language'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['status']) || array_key_exists('status', $this->data['fields'])) {
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
                if (isset($this->data['fields']['template_id']) || array_key_exists('template_id', $this->data['fields'])) {
                    $value = $this->data['fields']['template_id'];
                    $originalValue = $this->getOriginalFieldValue('template_id');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['template_id'] = (int) $this->data['fields']['template_id'];
                        } else {
                            $query['$unset']['template_id'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['areas']) || array_key_exists('areas', $this->data['fields'])) {
                    $value = $this->data['fields']['areas'];
                    $originalValue = $this->getOriginalFieldValue('areas');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['areas'] = $this->data['fields']['areas'];
                        } else {
                            $query['$unset']['areas'] = 1;
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