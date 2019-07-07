<?php declare(strict_types=1);

namespace Swoft\Tcp\Protocol;

use ReflectionException;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Tcp\Protocol\Contract\PackerInterface;
use Swoft\Tcp\Protocol\Exception\ProtocolException;
use Swoft\Tcp\Protocol\Packet\JsonPacker;
use Swoft\Tcp\Protocol\Packet\TokenTextPacker;
use function array_keys;
use function array_merge;
use function bean;

/**
 * Class PackerFactory
 *
 * @since 2.0.3
 * @Bean()
 */
class Protocol
{
    /**
     * The default packers
     */
    public const DEFAULT_PACKERS = [
        JsonPacker::TYPE      => JsonPacker::class,
        TokenTextPacker::TYPE => TokenTextPacker::class,
    ];

    /**
     * The default packer type name
     *
     * @var string
     */
    private $type = JsonPacker::TYPE;

    /**
     * The available data packers
     *
     * @var array
     * [
     *  type name => packet bean name(PackerInterface)
     * ]
     */
    private $packers;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        // Ensure packers always available
        $this->packers = self::DEFAULT_PACKERS;
    }

    /**
     * @param string $type
     * @param string $packerClass
     */
    public function setPacker(string $type, string $packerClass): void
    {
        $this->packers[$type] = $packerClass;
    }

    /**
     * @param string $type
     *
     * @return PackerInterface
     * @throws ReflectionException
     * @throws ContainerException
     */
    public function getPacker(string $type = ''): PackerInterface
    {
        $type = $type ?: $this->type;
        if (isset($this->packers[$type])) {
            throw new ProtocolException("The data packer is not exist! type: $type");
        }

        $class = $this->packers[$type];
        $packer = bean($class);

        throw new ProtocolException("The data packer is not exist! type: $type");
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getPackers(): array
    {
        return $this->packers;
    }

    /**
     * @param array $packers
     */
    public function setPackers(array $packers): void
    {
        $this->packers = array_merge($this->packers, $packers);
    }

    /**
     * @return array
     */
    public function getPackerNames(): array
    {
        return array_keys($this->packers);
    }
}
