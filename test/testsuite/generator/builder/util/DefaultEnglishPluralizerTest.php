<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

require_once __DIR__ . '/../../../../../generator/lib/builder/util/DefaultEnglishPluralizer.php';

/**
 * Tests for the StandardEnglishPluralizer class
 *
 * @version    $Revision$
 * @package    generator.builder.util
 */
class DefaultEnglishPluralizerTest extends \PHPUnit\Framework\TestCase
{
    public function getPluralFormDataProvider()
    {
        return [['', 's'], ['user', 'users'], ['users', 'userss'], ['User', 'Users'], ['sheep', 'sheeps'], ['Sheep', 'Sheeps'], ['wife', 'wifes'], ['Wife', 'Wifes'], ['country', 'countrys'], ['Country', 'Countrys']];
    }

    /**
     * @dataProvider getPluralFormDataProvider
     */
    public function testgetPluralForm($input, $output)
    {
        $pluralizer = new DefaultEnglishPluralizer();
        $this->assertEquals($output, $pluralizer->getPluralForm($input));
    }
}
