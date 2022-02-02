<?php

namespace Rikudou\DynamoDbCache\Encoder;

use RuntimeException;

final class JsonItemEncoder implements CacheItemEncoderInterface
{
    private int $encodeFlags;

    private int $depth;

    private int $decodeFlags;

    public function __construct(int $encodeFlags = 0, int $decodeFlags = 0, int $depth = 512)
    {
        $this->encodeFlags = $encodeFlags;
        $this->depth = $depth;
        $this->decodeFlags = $decodeFlags;
    }

    public function encode($input): string
    {
        // this is not a default implementation and thus ext-json is
        // not in required extensions, users that use this encoder should check
        // for themselves if the json extension is loaded

        /** @phpstan-ignore-next-line */
        $json = json_encode($input, $this->encodeFlags, $this->depth);
        if ($json === false) {
            throw new RuntimeException('JSON Error: ' . json_last_error_msg());
        }

        return $json;
    }

    public function decode(string $input)
    {
        /** @phpstan-ignore-next-line */
        return json_decode($input, true, $this->depth, $this->decodeFlags);
    }
}
