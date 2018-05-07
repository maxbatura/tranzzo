<?php

declare(strict_types = 1);

namespace Tranzzo;

/**
 * Class Leaf
 *
 * @package Tranzzo
 */
class Leaf
{
    /**
     * @var null|Leaf
     */
    private $next;

    /**
     * @var int
     */
    private $value;

    /**
     * Leaf constructor.
     *
     * @param int $value
     * @param null|Leaf $next
     */
    public function __construct(int $value, ?Leaf $next = null)
    {
        $this->next = $next;
        $this->value = $value;
    }

    /**
     * @return null|Leaf
     */
    public function getNext(): ?Leaf
    {
        return $this->next;
    }

    /**
     * @param null|Leaf $next
     */
    public function setNext(?Leaf $next): void
    {
        $this->next = $next;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue(int $value): void
    {
        $this->value = $value;
    }
}
