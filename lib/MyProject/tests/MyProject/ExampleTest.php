<?php
/**
 * ExampleTest.php for MyProject in tests/
 *
 * @category   MyProject
 * @package    MyProject_UnitTest
 * @copyright  Copyright (c) 2008 MyProject
 * @author     Harold Thetiot (hthetiot)
 */

// Load PhpUnit Libs
require_once 'PHPUnit/Framework.php';

// Load tested class
require_once 'Example.php';

class MyProject_ExampleTest extends PHPUnit_Framework_TestCase
{
    protected $_example = null;

    /**
     * Call before all test and on class test loading
     */
    public function setUp()
    {
        // configure test here
    }

    public function testUpdatePropertyValue()
    {
        // use time to have floating value
        $value = time();

        $example = new MyProject_Example();

        $example->updateProperty($value);

        // compare waiting results with results
        $this->assertEquals($value, $example->getProperty());

        /*
        assertArrayHasKey()
        assertClassHasAttribute()
        assertClassHasStaticAttribute()
        assertContains()
        assertContainsOnly()
        assertEqualXMLStructure()
        assertEquals()
        assertFalse()
        assertFileEquals()
        assertFileExists()
        assertGreaterThan()
        assertGreaterThanOrEqual()
        assertLessThan()
        assertLessThanOrEqual()
        assertNotNull()
        assertObjectHasAttribute()
        assertRegExp()
        assertSame()
        assertSelectCount()
        assertSelectEquals()
        assertSelectRegExp()
        assertStringEqualsFile()
        assertTag()
        assertThat()
        assertTrue()
        assertType()
        assertXmlFileEqualsXmlFile()
        assertXmlStringEqualsXmlFile()
        assertXmlStringEqualsXmlString()
        */
    }

    /**
     * Call after all test and on class test loading
     */
    public function tearDown()
    {
        // clean database or test generated data for example
    }
}

