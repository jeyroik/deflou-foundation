<?php
namespace deflou\interfaces\applications\activities;

use extas\interfaces\fields\IField;

/**
 * Interface IHasActivityFields
 *
 * @package deflou\interfaces\applications\activities
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IHasActivityFields
{
    public const FIELD__FIELDS = 'fields';

    /**
     * @param mixed ...$names
     * @return array
     */
    public function getFields(...$names): array;

    /**
     * @param mixed ...$names
     * @return array
     */
    public function getFieldsValues(...$names): array;

    /**
     * @param string $name
     * @return IField|null
     */
    public function getField(string $name): ?IField;

    /**
     * @param mixed ...$names
     * @return bool
     */
    public function hasFields(...$names): bool;

    /**
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getFieldValue(string $name, string $default = ''): string;

    /**
     * Rewrite all fields.
     *
     * @param array $fields
     * @return mixed
     */
    public function setFields(array $fields);

    /**
     * @param IField $field
     * @return mixed
     */
    public function setField(IField $field);

    /**
     * @param array $values
     * @return $this
     */
    public function setFieldsValues(array $values);

    /**
     * Rewrite existing field.
     * Throw an error if a field is missed.
     *
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function setFieldValue(string $name, string $value);

    /**
     * @param IField[] $fields
     * @return $this
     */
    public function addFields(array $fields);

    /**
     * @param IField $field
     * @return $this
     */
    public function addField(IField $field);

    /**
     * @param array $values
     * @return $this
     */
    public function addFieldsByValues(array $values);

    /**
     * Add new field (will throw an error if a field is already exist).
     *
     * @param string $name
     * @param string $value
     * @param array $parameters
     * @return $this
     */
    public function addFieldByValue(string $name, string $value, array $parameters = []);
}
