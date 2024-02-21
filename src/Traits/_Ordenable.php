<?php

namespace S4mpp\AdminPanel\Traits;

trait Ordenable
{
    // private ?int $order = null;

    // public function setOrder(int $order = null)
    // {
    // 	$this->order = $order;

    // 	return $this;
    // }

    // public function getOrder(): ?int
    // {
    // 	return $this->order ?? null;
    // }

    // public static function sort(array $items): array
    // {
    // 	usort($items, function ($a, $b): int
    // 	{
    // 		if($a->getOrder() === null && $b->getOrder() === null)
    // 		{
    // 			return self::_sortByString($a, $b);
    // 		}

    // 		if($a->getOrder() === null)
    // 		{
    // 			return 1;
    // 		}

    // 		if($b->getOrder() === null)
    // 		{
    // 			return -1;
    // 		}

    // 		if($a->getOrder() !== $b->getOrder())
    // 		{
    // 			return $a->getOrder() - $b->getOrder();
    // 		}

    // 		return self::_sortByString($a, $b);
    // 	});

    // 	return $items;
    // }

    // private static function _sortByString($a, $b): int
    // {
    // 	if(is_string($a) && is_string($b))
    // 	{
    // 		return strcasecmp((string)$a, (string)$b);
    // 	}

    // 	return 0;
    // }
}
