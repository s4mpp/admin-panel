<?php

namespace S4mpp\AdminPanel\Factories;

use S4mpp\Format\Format;
use S4mpp\AdminPanel\Input\Date;
use S4mpp\AdminPanel\Input\File;
use S4mpp\AdminPanel\Input\Text;
use S4mpp\AdminPanel\Input\Email;
use S4mpp\AdminPanel\Input\Radio;
use Illuminate\Support\Collection;
use S4mpp\AdminPanel\Input\Number;
use S4mpp\AdminPanel\Input\Search;
use S4mpp\AdminPanel\Input\Select;
use S4mpp\AdminPanel\Input\Checkbox;
use S4mpp\AdminPanel\Input\Textarea;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

abstract class Input
{
    public static function text(string $title, string $field): Text
    {
        return (new Text($title, $field))->addRule('string');
    }

    public static function date(string $title, string $field): Date
    {
        return (new Date($title, $field))->prepareForForm(function ($value): ?string {

            dump($value);

            return $value; //$value?->format('Y-m-d');
        });
    }

    public static function email(string $title, string $field): Email
    {
        return (new Email($title, $field))->addRule('email');
    }

    public static function textarea(string $title, string $field, int $rows = 4): Textarea
    {
        return (new Textarea($title, $field, $rows))->addRule('string');
    }

    // public static function file(string $title, string $field, string $folder)
    // {
    // 	return (new File($title, $field, $folder))->addRule('file');
    // }

    public static function decimal(string $title, string $field, float $step = 0.01): Number
    {
        return (new Number($title, $field))->step($step)->addRule('numeric');
    }

    public static function integer(string $title, string $field, int $step = 1): Number
    {
        return (new Number($title, $field))->step($step)->addRule('integer');
    }

    // public static function currency(string $title, string $field, bool $has_cents = true)
    // {
    // 	$addRule = ($has_cents)
    // 	? ['integer', 'min:1', 'max:21000000000']
    // 	: ['numeric', 'min:0.01', 'max:21000000.00'];

    // 	extract($addRule);

    // 	return (new Text($title, $field))
    // 	->mask('$money($input, \',\', \'.\')')
    // 	->prepareForForm(function($value) use ($has_cents) { return Format::currency($value, $has_cents); })
    // 	->prepareForSave(function(string $value = null) use ($has_cents)
    // 	{
    // 		if(is_null($value) || !$value)
    // 		{
    // 			return null;
    // 		}

    // 		$nb_float = Format::numberToFloat($value);

    // 		if($has_cents)
    // 		{
    // 			return intval($nb_float * 100);
    // 		}

    // 		return $nb_float;
    // 	})
    // 	->addRule(...$addRule);
    // }

    // public static function boolean(string $title, string $field)
    // {
    // 	return (new Radio($title, $field, [
    // 		0 => 'Não',
    // 		1 => 'Sim',
    // 	]));
    // }

    // public static function search(
    // 	string $title,
    // 	string $field,
    // 	string $relationship,
    // 	string $model_field = null)
    // {
    // 	return (new Search($title, $field, $relationship, $model_field));
    // }

    public static function select(
        string $title,
        string $field,
        // array | Collection | EloquentCollection $options,
        // string $value_collection = null,
        // string $key_collection = null
    ): Select {
        return new Select($title, $field
            // , $options, $value_collection, $key_collection
        );
    }

    public static function checkbox(
        string $title,
        string $field,
        // array | Collection | EloquentCollection $options,
        // string $value_collection = null,
        // string $key_collection = null
    ): Checkbox {
        return (new Checkbox($title, $field
            // , $options, $value_collection, $key_collection
        ))->addRule('array');
    }

    public static function radio(
        string $title,
        string $field,
        // array | Collection | EloquentCollection $options,
        // string $value_collection = null,
        // string $key_collection = null
    ): Radio {
        return new Radio($title, $field
            // , $options, $value_collection, $key_collection
        );
    }
}
