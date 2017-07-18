<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Student.php";

$server = 'mysql:host=localhost:8889;dbname=registrar_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class StudentTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Student::deleteAll();
    }
    function testGetName()
    {
        $name = "Sven";
        $enrollment_date = 6-6-1966;
        $id = 1;
        $test_student = new Student($name, $enrollment_date, $id);

        $result = $test_student->getName();

        $this->assertEquals($name, $result);
    }

    function testSetName()
    {
        $name = "Roberto";
        $enrollment_date = 5-5-1955;
        $id = 2;
        $test_student = new Student($name, $enrollment_date, $id);
        $new_name = "Sam";

        $test_student->setName($new_name);
        $result = $test_student->getName();

        $this->assertEquals($new_name, $result);
    }

    function testGetEnrollmentDate()
    {
        $name = "Hendrik";
        $enrollment_date = 4-4-1944;
        $id = 3;
        $test_student = new Student($name, $enrollment_date, $id);

        $result = $test_student->getEnrollmentDate();

        $this->assertEquals($enrollment_date, $result);
    }

    function testSetEnrollmentDate()
    {
        $name = "Larry";
        $enrollment_date = 3-3-1933;
        $id = 4;
        $test_student = new Student($name, $enrollment_date, $id);
        $new_name = "Ralph";

        $test_student->setEnrollmentDate($new_name);
        $result = $test_student->getEnrollmentDate();

        $this->assertEquals($new_name, $result);
    }

    function testGetId()
    {
        $name = "Kendra";
        $enrollment_date = 2-2-1922;
        $id = 5;
        $test_student = new Student($name, $enrollment_date, $id);

        $result = $test_student->getId();

        $this->assertEquals($id, $result);
    }

    function testSave()
    {
        $name = "Sarah";
        $enrollment_date = 8-8-1918;
        $test_student = new Student($name, $enrollment_date);

        $executed = $test_student->save();

        $this->assertTrue($executed, "Student not successfully saved to database");
    }

    function testDeleteAll()
    {

        $name = "Shandra";
        $enrollment_date = 8-8-1916;
        $name_2 = "Grunkla";
        $enrollment_date_2 = 8-8-1915;
        $test_student = new Student($name, $enrollment_date);
        $test_student->save();
        $test_student_2 = new Student($name_2, $enrollment_date_2);
        $test_student_2->save();

        Student::deleteAll();
        $result = Student::getAll();

        $this->assertEquals([], $result);
    }

    function testGetAll()
    {
        $name = "Falchia";
        $enrollment_date = "2014-08-08";
        $name_2 = "Naomi";
        $enrollment_date_2 = "2013-08-08";
        $test_student = new Student($name, $enrollment_date);
        $test_student->save();
        $test_student_2 = new Student($name_2, $enrollment_date_2);
        $test_student_2->save();

        $result = Student::getAll();

        $this->assertEquals([$test_student, $test_student_2], $result);
    }

    function testFind()
    {
        $name = "Aslan";
        $enrollment_date = "2014-07-07";
        $name2 = "Sam";
        $enrollment_date_2 = "2013-07-07";
        $test_student = new Student($name, $enrollment_date);
        $test_student->save();
        $test_student_2 = new Student($name2, $enrollment_date_2);
        $test_student_2->save();

        $result = Student::find($test_student->getId());

        $this->assertEquals($test_student, $result);
    }

    function testUpdateName()
    {
        $name = "Istambul";
        $enrollment_date = "2013-03-03";
        $test_student = new Student($name, $enrollment_date);
        $name_2 = "Constantinople";
        $test_student->save();

        $test_student->updateName($name_2);

        $this->assertEquals($name_2, $test_student->getName());
    }

    function testUpdateEnrollmentDate()
    {
        $name = "Istambul";
        $enrollment_date = "2011-11-11";
        $test_student = new Student($name, $enrollment_date);
        $enrollment_date_2 = "2012-12-12";
        $test_student->save();

        $test_student->updateEnrollmentDate($enrollment_date_2);

        $this->assertEquals($enrollment_date_2, $test_student->getEnrollmentDate());
    }

    function testDelete()
    {

        $name = "Greta";
        $enrollment_date = "2010-01-01";
        $test_student = new Student($name, $enrollment_date);
        $test_student->save();
        $name_2 = "Hanz";
        $enrollment_date_2 = "2001-01-01";
        $test_student_2 = new Student($name_2, $enrollment_date_2);
        $test_student_2->save();

        $test_student->delete();

        $this->assertEquals([$test_student_2], Student::getAll());
    }

}

?>
