<?php

return static function (mixed $stream, \Psr\Container\ContainerInterface $valueTransformers, \Symfony\Component\JsonEncoder\Decode\LazyInstantiator $instantiator, array $options): mixed {
    $providers['array<int,mixed>'] = static function ($stream, $offset, $length) use ($options, $valueTransformers, $instantiator, &$providers) {
        $data = \Symfony\Component\JsonEncoder\Decode\Splitter::splitList($stream, $offset, $length);
        $iterable = static function ($stream, $data) use ($options, $valueTransformers, $instantiator, &$providers) {
            foreach ($data as $k => $v) {
                yield $k => \Symfony\Component\JsonEncoder\Decode\NativeDecoder::decodeStream($stream, $v[0], $v[1]);
            }
        };
        return \iterator_to_array($iterable($stream, $data));
    };
    return $providers['array<int,mixed>']($stream, 0, null);
};
