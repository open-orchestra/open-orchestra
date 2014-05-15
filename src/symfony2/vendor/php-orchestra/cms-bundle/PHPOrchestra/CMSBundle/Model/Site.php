<?php

namespace PHPOrchestra\CMSBundle\Model;

/**
 * Model\PHPOrchestraCMSBundle\Site bundle document.
 */
abstract class Site extends \Model\PHPOrchestraCMSBundle\Base\Site
{
	
    /**
     * Set the "languages" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Site The document (fluent interface).
     */
    public function setLanguages($value)
    {
        $value = implode(',', $value);
    	if (!isset($this->data['fields']['languages'])) {
            if (!$this->isNew()) {
                $this->getLanguages();
                if ($this->isFieldEqualTo('languages', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['languages'] = null;
                $this->data['fields']['languages'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('languages', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['languages']) && !array_key_exists('languages', $this->fieldsModified)) {
            $this->fieldsModified['languages'] = $this->data['fields']['languages'];
        } elseif ($this->isFieldModifiedEqualTo('languages', $value)) {
            unset($this->fieldsModified['languages']);
        }

        $this->data['fields']['languages'] = $value;

        return $this;
    }

    /**
     * Returns the "languages" field.
     *
     * @return mixed The $name field.
     */
    public function getLanguages()
    {
        if (!isset($this->data['fields']['languages'])) {
            if ($this->isNew()) {
                $this->data['fields']['languages'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('languages', $this->data['fields'])) {
                $this->addFieldCache('languages');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('languages' => 1)
                );
                if (isset($data['languages'])) {
                    $this->data['fields']['languages'] = (string) $data['languages'];
                } else {
                    $this->data['fields']['languages'] = null;
                }
            }
        }

        return explode(',', $this->data['fields']['languages']);
    }

    /**
     * Set the "blocks" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\PHPOrchestraCMSBundle\Site The document (fluent interface).
     */
    public function setBlocks($value)
    {
    	$value = implode(',', $value);
        if (!isset($this->data['fields']['blocks'])) {
            if (!$this->isNew()) {
                $this->getBlocks();
                if ($this->isFieldEqualTo('blocks', $value)) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['blocks'] = null;
                $this->data['fields']['blocks'] = $value;
                return $this;
            }
        } elseif ($this->isFieldEqualTo('blocks', $value)) {
            return $this;
        }

        if (!isset($this->fieldsModified['blocks']) && !array_key_exists('blocks', $this->fieldsModified)) {
            $this->fieldsModified['blocks'] = $this->data['fields']['blocks'];
        } elseif ($this->isFieldModifiedEqualTo('blocks', $value)) {
            unset($this->fieldsModified['blocks']);
        }

        $this->data['fields']['blocks'] = $value;

        return $this;
    }

    /**
     * Returns the "blocks" field.
     *
     * @return mixed The $name field.
     */
    public function getBlocks()
    {
        if (!isset($this->data['fields']['blocks'])) {
            if ($this->isNew()) {
                $this->data['fields']['blocks'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('blocks', $this->data['fields'])) {
                $this->addFieldCache('blocks');
                $data = $this->getRepository()->getCollection()->findOne(
                    array('_id' => $this->getId()),
                    array('blocks' => 1)
                );
                if (isset($data['blocks'])) {
                    $this->data['fields']['blocks'] = (string) $data['blocks'];
                } else {
                    $this->data['fields']['blocks'] = null;
                }
            }
        }

        return explode(',', $this->data['fields']['blocks']);
    }
	
}
