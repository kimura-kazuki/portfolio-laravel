<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/10/12
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

declare(strict_types=1);

namespace App\Traits;

trait EnumTrait
{
    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getKey(): string
    {
        return $this->name;
    }

    public function equals($enum): bool
    {
        return $enum instanceof self
        && $this === $enum
        && static::class === \get_class($enum);
    }

    public static function keys(): array
    {
        return \array_keys(static::toArray());
    }

    public static function values()
    {
        $cases = static::cases();
        $values = [];
        foreach ($cases as $enum) {
            $values[$enum->name] = $enum;
        }

        return $values;
    }

    public static function toArray(): array
    {
        $cases = static::cases();
        $array = [];
        foreach ($cases as $enum) {
            $array[$enum->name] = $enum->value;
        }

        return $array;
    }

    public static function isValid($value): bool
    {
        return \in_array($value, static::toArray(), true);
    }

    public static function isValidKey($key): bool
    {
        $array = static::toArray();

        return isset($array[$key]) || \array_key_exists($key, $array);
    }

    public static function assertValidValue($value): void
    {
        if (static::search($value) === false) {
            throw new \UnexpectedValueException();
        }
    }

    public static function search($value)
    {
        return \array_search($value, static::toArray(), true);
    }

    public static function __callStatic($name, $arguments)
    {
        $cases = static::cases();
        foreach ($cases as $case) {
            if ($name === $case->name) {
                return $case;
            }
        }
    }
}
