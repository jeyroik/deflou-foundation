<?php
namespace deflou\components\applications\activities;

use deflou\interfaces\applications\activities\IHasActivityFields;
use extas\components\exceptions\AlreadyExist;
use extas\components\exceptions\MissedOrUnknown;
use extas\components\fields\Field;
use extas\interfaces\fields\IField;

/**
 * Class THasActivityFields
 *
 * @property array $config
 *
 * @package deflou\components\applications\activities
 * @author jeyroik <jeyroik@gmail.com>
 */
trait THasActivityFields
{
    /**
     * @param mixed ...$names
     * @return array
     * @throws MissedOrUnknown
     */
    public function getFields(...$names): array
    {
        $fields = [];
        $fieldsConfigs = $this->config[IHasActivityFields::FIELD__FIELDS] ?? [];
        $names = empty($names) ? array_keys($fieldsConfigs) : $names;

        if (!$this->hasFields(...$names)) {
            throw new MissedOrUnknown('some fields');
        }

        foreach ($names as $name) {
            $fields[$name] = new Field($fieldsConfigs[$name]);
        }

        return $fields;
    }

    /**
     * @param mixed ...$names
     * @return array
     */
    public function getFieldsValues(...$names): array
    {
        $fieldsValues = [];
        
        if (empty($names)) {
            $fields = $this->config[IHasActivityFields::FIELD__FIELDS] ?? [];
            $names = array_keys($fields);
        }

        foreach ($names as $name) {
            $fieldsValues[$name] = $this->getFieldValue($name);
        }

        return $fieldsValues;
    }

    /**
     * @param string $name
     * @return IField|null
     */
    public function getField(string $name): ?IField
    {
        $fields = $this->config[IHasActivityFields::FIELD__FIELDS] ?? [];

        return isset($fields[$name]) ? new Field($fields[$name]) : null;
    }

    /**
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getFieldValue(string $name, string $default = ''): string
    {
        return $this->getField($name)->getValue($default);
    }

    /**
     * @param mixed ...$names
     * @return bool
     */
    public function hasFields(...$names): bool
    {
        $fields = $this->config[IHasActivityFields::FIELD__FIELDS] ?? [];

        foreach ($names as $name) {
            if (!isset($fields[$name])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $fields
     * @return $this|mixed
     */
    public function setFields(array $fields)
    {
        foreach ($fields as $field) {
            $this->setField($field);
        }

        return $this;
    }

    /**
     * @param array $values
     * @return $this|THasActivityFields
     */
    public function setFieldsValues(array $values)
    {
        foreach ($values as $name => $value) {
            $this->setFieldValue($name, $value);
        }

        return $this;
    }

    /**
     * @param IField $field
     * @return $this|mixed
     */
    public function setField(IField $field)
    {
        $fields = $this->config[IHasActivityFields::FIELD__FIELDS] ?? [];
        $fields[$field->getName()] = $field->__toArray();
        $this->config[IHasActivityFields::FIELD__FIELDS] = $fields;

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return $this|THasActivityFields
     */
    public function setFieldValue(string $name, string $value)
    {
        $fields = $this->config[IHasActivityFields::FIELD__FIELDS] ?? [];
        $field = isset($fields[$name]) ? new Field($fields[$name]) : $this->getDefaultField($name, $value);
        $fields[$name] = $field->setValue($value)->__toArray();
        $this->config[IHasActivityFields::FIELD__FIELDS] = $fields;

        return $this;
    }

    /**
     * @param array $fields
     * @return $this|THasActivityFields
     * @throws AlreadyExist|MissedOrUnknown
     */
    public function addFields(array $fields)
    {
        foreach ($fields as $field) {
            $this->addField($field);
        }

        return $this;
    }

    /**
     * @param IField $field
     * @return $this|THasActivityFields
     * @throws AlreadyExist
     * @throws MissedOrUnknown|AlreadyExist
     */
    public function addField(IField $field)
    {
        if ($this->hasFields($field->getName())) {
            throw new AlreadyExist('field "' . $field->getName() . '"');
        }

        $fields = $this->getFields();
        $fields[] = $field;
        $this->setFields($fields);

        return $this;
    }

    /**
     * @param array $values
     * @return $this|THasActivityFields
     * @throws AlreadyExist|MissedOrUnknown
     */
    public function addFieldsByValues(array $values)
    {
        foreach ($values as $name => $value) {
            $this->addFieldByValue($name, $value);
        }

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $parameters
     * @return $this|THasActivityFields
     * @throws AlreadyExist|MissedOrUnknown
     */
    public function addFieldByValue(string $name, string $value, array $parameters = [])
    {
        if ($this->hasFields($name)) {
            throw new AlreadyExist('field "' . $name . '"');
        }

        $fields = $this->getFields();
        $fields[] = $this->getDefaultField($name, $value, $parameters);

        $this->setFields($fields);

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $parameters
     * @return Field
     */
    protected function getDefaultField(string $name, string $value, array $parameters = [])
    {
        return new Field([
            Field::FIELD__NAME => $name,
            Field::FIELD__VALUE => $value,
            Field::FIELD__TYPE => 'string',
            Field::FIELD__SAMPLE_NAME => 'string',
            Field::FIELD__CREATED_AT => time(),
            Field::FIELD__PARAMETERS => $parameters
        ]);
    }
}
