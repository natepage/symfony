<?php

return static function (mixed $data, \Psr\Container\ContainerInterface $valueTransformers, array $options): \Traversable {
    yield '{';
    $prefix = '';
    foreach ($data as $key => $value) {
        $key = \substr(\json_encode($key), 1, -1);
        yield "{$prefix}\"{$key}\":";
        yield '{"@id":';
        yield \json_encode($value->id);
        yield ',"name":';
        yield \json_encode($value->name);
        yield '}';
        $prefix = ',';
    }
    yield '}';
};
