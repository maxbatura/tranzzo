<?php

declare(strict_types = 1);

namespace Tranzzo;

/**
 * Class Node
 *
 * @package Tranzzo
 */
class Node
{
    /**
     * @var null|Leaf
     */
    private $leafList;

    /**
     * @var null|Node[]
     */
    private $childNodes;

    /**
     * Node constructor.
     *
     * @param null|Leaf $leafList
     * @param null|Node[] $childNodes
     */
    public function __construct(?Leaf $leafList = null, ?array $childNodes = null)
    {
        $this->leafList = $leafList;
        $this->childNodes = $childNodes;
    }

    /**
     * @return null|Leaf
     */
    public function getLeafList(): ?Leaf
    {
        return $this->leafList;
    }

    /**
     * @param null|Leaf $leafList
     */
    public function setLeafList(?Leaf $leafList): void
    {
        $this->leafList = $leafList;
    }

    /**
     * @return null|Node[]
     */
    public function getChildNodes(): ?array
    {
        return $this->childNodes;
    }

    /**
     * @param null|Node[] $childNodes
     */
    public function setChildNodes(?array $childNodes): void
    {
        $this->childNodes = $childNodes;
    }

    public function addLeafList(Leaf $leafList): void
    {
        /** @var Leaf $leaf */
        $leaf = $this->getLeafList();

        if (null === $leaf) {
            $this->setLeafList($leafList);
            return;
        }

        while ($leaf->getNext()) {
            $leaf = $leaf->getNext();
        }

        $leaf->setNext($leafList);
    }

    public function sortLeafs(): void
    {
        if (null === $this->getLeafList()) {
            return;
        }

        do {
            $sorted = true;

            /** @var Leaf $leaf */
            $leaf = $this->getLeafList();
            /** @var Leaf $prev */
            $prev = null;

            while (null !== $leaf->getNext()) {
                /** @var Leaf $next */
                $next = $leaf->getNext();

                if ($leaf->getValue() > $next->getValue()) {
                    $leaf->setNext($next->getNext());
                    $next->setNext($leaf);

                    if (null === $prev) {
                        $this->setLeafList($next);
                    } else {
                        $prev->setNext($next);
                    }

                    $sorted = false;
                    continue;
                }

                $prev = $leaf;
                $leaf = $next;
            }
        } while (!$sorted);
    }

    public function processW(int $w): ?Leaf
    {
        if (null === $this->getLeafList()) {
            return null;
        }

        $this->sortLeafs();

        $curSum = 0;

        /** @var Leaf $leaf */
        $leaf = $this->getLeafList();
        $prev = null;

        while ($leaf && $curSum + $leaf->getValue() <= $w) {
            $curSum += $leaf->getValue();
            $prev = $leaf;
            $leaf = $leaf->getNext();
        }

        if (null !== $leaf) {
            if (null === $prev) {
                $this->setLeafList(null);
            } else {
                $prev->setNext(null);
            }
        }



        return $this->processChildW($w, $leaf);
    }

    protected function processChildW(int $w, ?Leaf $list = null): ?Leaf
    {
        if (null === $this->getChildNodes()) {
            return $list;
        }

        foreach ($this->getChildNodes() as $child) {
            if (null !== $list) {
                $child->addLeafList($list);
            }

            $list = $child->processW($w);
        }

        return $list;
    }

    public function getArray(): array
    {
        $res = [
            'leafs' => [],
            'child' => [],
        ];

        $leaf = $this->getLeafList();

        while (null !== $leaf) {
            $res['leafs'][] = $leaf->getValue();
            $leaf = $leaf->getNext();
        }

        if (null !== $this->getChildNodes()) {
            return $res;
        }

        /** @var Node $child */
        foreach ($this->getChildNodes() as $child) {
            $res['child'][] = $child->getArray();
        }

        return $res;
    }
}