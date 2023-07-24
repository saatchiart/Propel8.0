<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

require_once __DIR__ . '/../../../../../generator/lib/builder/util/StandardEnglishPluralizer.php';

/**
 * Tests for the StandardEnglishPluralizer class
 *
 * @version    $Revision$
 * @package    generator.builder.util
 */
class StandardEnglishPluralizerTest extends \PHPUnit\Framework\TestCase
{
    public function getPluralFormDataProvider()
    {
        return [['', 's'], ['user', 'users'], ['users', 'userss'], ['User', 'Users'], ['sheep', 'sheep'], ['Sheep', 'Sheep'], ['wife', 'wives'], ['Wife', 'Wives'], ['country', 'countries'], ['Country', 'Countries'], ['Video', 'Videos'], ['video', 'videos'], ['Photo', 'Photos'], ['photo', 'photos'], ['Tomato', 'Tomatoes'], ['tomato', 'tomatoes'], ['Buffalo', 'Buffaloes'], ['buffalo', 'buffaloes'], ['typo', 'typos'], ['Typo', 'Typos'], ['apple', 'apples'], ['Apple', 'Apples'], ['Man', 'Men'], ['man', 'men'], ['numen', 'numina'], ['Numen', 'Numina'], ['bus', 'buses'], ['Bus', 'Buses'], ['news', 'news'], ['News', 'News'], ['food_menu', 'food_menus'], ['Food_menu', 'Food_menus'], ['quiz', 'quizzes'], ['Quiz', 'Quizzes'], ['alumnus', 'alumni'], ['Alumnus', 'Alumni'], ['vertex', 'vertices'], ['Vertex', 'Vertices'], ['matrix', 'matrices'], ['Matrix', 'Matrices'], ['index', 'indices'], ['Index', 'Indices'], ['alias', 'aliases'], ['Alias', 'Aliases'], ['bacillus', 'bacilli'], ['Bacillus', 'Bacilli'], ['cactus', 'cacti'], ['Cactus', 'Cacti'], ['focus', 'foci'], ['Focus', 'Foci'], ['fungus', 'fungi'], ['Fungus', 'Fungi'], ['nucleus', 'nuclei'], ['Nucleus', 'Nuclei'], ['radius', 'radii'], ['Radius', 'Radii'], ['people', 'people'], ['People', 'People'], ['glove', 'gloves'], ['Glove', 'Gloves'], ['crisis', 'crises'], ['Crisis', 'Crises'], ['tax', 'taxes'], ['Tax', 'Taxes'], ['Tooth', 'Teeth'], ['tooth', 'teeth'], ['Foot', 'Feet']];
    }

    /**
     * @dataProvider getPluralFormDataProvider
     */
    public function testgetPluralForm($input, $output)
    {
        $pluralizer = new StandardEnglishPluralizer();
        $this->assertEquals($output, $pluralizer->getPluralForm($input));
    }
}
