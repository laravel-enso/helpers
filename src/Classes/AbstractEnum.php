<?php

namespace LaravelEnso\Helpers\Classes;

abstract class AbstractEnum extends AbstractObject {

    protected $data = [];

    public function getData() {

        return $this->data;
    }

    public function getJsonData() {

        return json_encode($this->data);
    }

    public function getKeys() {

        return array_keys($this->data);
    }

    public function getValues() {

        return array_values($this->data);
    }

    public function getKeyByValue($value) {

        $key = array_search($value, $this->data);

        return $key !== false ? $key : null;
    }

    public function getValueByKey($key) {

        return $this->hasKey($key) ? $this->data[$key] : null;
    }

    public function hasKey($key) {

        return isset($this->data[$key]);
    }

    public function hasValue($value) {

        return array_search($value, $this->data) !== false;
    }
}