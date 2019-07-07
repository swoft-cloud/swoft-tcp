<?php declare(strict_types=1);

namespace Swoft\Tcp\Protocol\Packet;

use Swoft\Tcp\Protocol\Contract\PackerInterface;
use Swoft\Tcp\Protocol\Package;

/**
 * Class TextTokenPacker
 *
 * @since 2.0.3
 */
class TokenTextPacker implements PackerInterface
{
    public const TYPE = 'token-text';

    /**
     * @return string
     */
    public static function getType(): string
    {
        return self::TYPE;
    }

    /**
     * Encode Package object to string data.
     *
     * @param Package $package
     *
     * @return string
     */
    public function encode(Package $package): string
    {
        // TODO: Implement encode() method.
    }

    /**
     * Decode tcp package data to Package object
     *
     * @param string $data package data
     *
     * @return Package
     */
    public function decode(string $data): Package
    {
        // TODO: Implement decode() method.
    }
}
