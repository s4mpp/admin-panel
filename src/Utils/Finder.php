<?php

namespace S4mpp\AdminPanel\Utils;

use S4mpp\AdminPanel\Elements\Card;
use Illuminate\Support\Facades\Auth;

abstract class Finder
{
    // public static function checkRoles(array $roles)
    // {
    // 	if(empty($roles))
    // 	{
    // 		return true;
    // 	}

    // 	return Auth::guard(config('admin.guard', 'web'))->user()->hasAnyRole($roles);
    // }

    // /**
    //  * @deprecated version
    //  */
    // public static function checkPermissions(array $permissions)
    // {
    // 	if(empty($permissions))
    // 	{
    // 		return true;
    // 	}

    // 	return Auth::guard(config('admin.guard', 'web'))->user()->can($permissions);
    // }

    /**
     * @param  array<mixed>  $arr_input
     * @return array<Card>
     */
    public static function fillInCard(array $arr_input): array
    {
        $items_filled_in_card = [];

        foreach ($arr_input as $item) {
            if (is_a($item, Card::class)) {
                $items_filled_in_card[] = $item;

                continue;
            }

            if (! isset($main_card)) {
                $main_card = new Card('');

                $items_filled_in_card[] = $main_card;
            }

            $main_card->addElement($item);
        }

        return $items_filled_in_card;
    }

    /**
     * @param  array<mixed>  $items
     * @param  string  $classes
     * @return array<mixed>
     */
    public static function onlyOf(?array $items = null, ...$classes): array
    {
        $classes = array_unique($classes);

        foreach ($items ?? [] as $item) {
            $class_found = false;

            foreach ($classes as $class) {
                if (is_subclass_of($item, $class) || is_a($item, $class)) {
                    $class_found = true;

                    break;
                }
            }

            if ($class_found) {
                $elements[] = $item;
            }
        }

        return $elements ?? [];
    }

    public static function findBySlug(array $items = null, string $slug_to_find): mixed
    {
        foreach ($items as $item) {
            if ($item->getSlug() == $slug_to_find) {
                return $item;
            }
        }

        return null;
    }

    // public static function getOnlyOfThisOrCard(array $items, $class): array
    // {
    // 	$elements = [];

    // 	foreach($items as $element)
    // 	{
    // 		if(is_a($element, Card::class))
    // 		{
    // 			$elements[] = $element;

    // 			continue;
    // 		}
    // 		else if(is_subclass_of($element, $class) || is_a($element, $class))
    // 		{
    // 			$main_card_elements[] = $element;
    // 		}
    // 	}

    // 	if(isset($main_card_elements))
    // 	{
    // 		array_unshift($elements, new Card('', $main_card_elements));
    // 	}

    // 	return $elements ?? [];
    // }

    /**
     * @param  array<mixed>  $elements
     * @param  array<mixed>  $fields_found
     * @return array<mixed>
     */
    public static function findElementsRecursive(array $elements, string $element_to_search, array $fields_found = []): array
    {
        foreach ($elements as $element) {
            if (is_subclass_of($element, $element_to_search) || is_a($element, $element_to_search)) {
                $fields_found[] = $element;
            } elseif (is_array($element)) {
                $fields_found = self::findElementsRecursive($element, $element_to_search, $fields_found);
            } elseif (is_a($element, Card::class)) {
                $fields_found = self::findElementsRecursive($element->getElements(), $element_to_search, $fields_found);
            }
        }

        return $fields_found;
    }
}
