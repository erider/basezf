<?php
/**
 * AllTests.php for MyProject in tests/MyProject/
 *
 * @category   MyProject_UnitTest
 * @package    MyProject
 * @copyright  Copyright (c) 2008 MyProject
 * @author     Harold Thétiot (hthetiot)
 */

// include PhpUnit Library
require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

class MyProject_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('MyProject Framework');

        $testClasses = glob(dirname(__FILE__) . '/*Test.php');

        // get all *Test.php file in current directory and add them as Test
        foreach ($testClasses as $testClass) {

            // include Test Class
            require_once($testClass);

            // add has test suite
            $testClassName = basename(dirname($testClass)) . '_' . basename($testClass, '.php');
            $suite->addTestSuite($testClassName);
        }

        return $suite;
    }
}

