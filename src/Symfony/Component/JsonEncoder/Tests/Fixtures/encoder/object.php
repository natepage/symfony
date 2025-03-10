<?php

return static function (mixed $data, \Psr\Container\ContainerInterface $valueTransformers, array $options): \Traversable {
    yield '{"@id":';
    yield \json_encode($data->id);
    yield ',"name":';
    yield \json_encode($data->name);
    yield '}';
};
