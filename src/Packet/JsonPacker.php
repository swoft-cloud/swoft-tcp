<?php declare(strict_types=1);

namespace Swoft\Tcp\Protocol\Packet;

use Swoft\Stdlib\Helper\JsonHelper;
use Swoft\Tcp\Protocol\Contract\PackerInterface;
use Swoft\Tcp\Protocol\Package;

/**
 * Class JsonPacker
 *
 * @since 2.0.3
 */
class JsonPacker implements PackerInterface
{
    public const TYPE = 'json';

    /**
     * Encode Package object to string data.
     *
     * @param Package $package
     *
     * @return string
     */
    public function encode(Package $package): string
    {
        return JsonHelper::encode($package->toArray());
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
        $cmd = '';
        $ext = [];
        $map = JsonHelper::decode($data, true);

        // Find message route
        if (isset($map['cmd'])) {
            $cmd = (string)$map['cmd'];
            unset($map['cmd']);
        }

        if (isset($map['data'])) {
            $data = $map['data'];
            $ext  = $map['ext'] ?? [];
        } else {
            $data = $map;
        }

        return Package::new($cmd, $data, $ext);
    }

    /**
     * @return string
     */
    public static function getType(): string
    {
        return self::TYPE;
    }
}
