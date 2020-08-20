# PhpKeyChanger

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/714b6325e36b48d0bd38ae9b3b214dc9)](https://app.codacy.com/manual/ronappleton/php-key-changer?utm_source=github.com&utm_medium=referral&utm_content=ronappleton/php-key-changer&utm_campaign=Badge_Grade_Dashboard)

Simple, PhpKeyChanger allows you to pass a json string, object or an array and it will recursively re-key the array using the case you give it.

-   Camel Case
-   Pascal Case
-   Snake Case
-   Kebab Case
-   Studly Case

## Installation

*Note:* Php key changer requires php ^7.4

`composer require ronappleton/php-key-changer`

## Usage

`use RonAppleton\PhpKeyChanger\PhpKeyChanger;`

`$reKeyed = PhpKeyChanger::reKey($array, 'snake');`

You can use any of the above cases, and you can pass in a Json object, a Json string or an Array, it will be return the same type that you pass in.

## Credits

I used `Illuminate\Support\Str` as the basis of the StringConverters class`, many thanks Taylor Otwell and all contributors.
