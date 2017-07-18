<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Course.php";

$server = 'mysql:host=localhost:8889;dbcourse_name=registrar_test';
$usercourse_name = 'root';
$password = 'root';
$DB = new PDO($server, $usercourse_name, $password);

class CourseTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Course::deleteAll();
    }
    function testGetName()
    {
        $course_course_name = "History of Civilization";
        $course_number = "HIS301";
        $id = 1;
        $test_course = new Course($course_name, $course_number, $id);

        $result = $test_course->getCourseName();

        $this->assertEquals($course_name, $result);
    }

    function testSetName()
    {
        $course_name = "Introduction to Robotics";
        $course_number = "CS321";
        $id = 2;
        $test_course = new Course($course_name, $course_number, $id);
        $new_course_name = "Robotic Programming";

        $test_course->setCourseName($new_course_name);
        $result = $test_course->getCourseName();

        $this->assertEquals($new_course_name, $result);
    }

    function testGetCourseNumber()
    {
        $course_name = "Underwater Basket Weaving";
        $course_number = "ART211";
        $id = 3;
        $test_course = new Course($course_name, $course_number, $id);

        $result = $test_course->getCourseNumber();

        $this->assertEquals($course_number, $result);
    }

    function testSetCourseNumber()
    {
        $course_name = "Music Appreciation";
        $course_number = 'MUS101';
        $id = 4;
        $test_course = new Course($course_name, $course_number, $id);
        $new_course_number = "MUS102";

        $test_course->setCourseNumber($new_course_name);
        $result = $test_course->getCourseNumber();

        $this->assertEquals($new_course_name, $result);
    }

    function testGetId()
    {
        $course_name = "Graffiti Art from Prehistory to Present";
        $course_number = "ANT212";
        $id = 5;
        $test_course = new Course($course_name, $course_number, $id);

        $result = $test_course->getId();

        $this->assertEquals($id, $result);
    }

    function testSave()
    {
        $course_name = "Energy-Efficient Design";
        $course_number = "ENV301";
        $test_course = new Course($course_name, $course_number);

        $executed = $test_course->save();

        $this->assertTrue($executed, "Course not successfully saved to database");
    }

    function testDeleteAll()
    {

        $course_name = "Introduction to Forensics";
        $course_number = "FOR101";
        $course_name_2 = "Introduction to Astronomy";
        $course_number_2 = "SCI201";
        $test_course = new Course($course_name, $course_number);
        $test_course->save();
        $test_course_2 = new Course($course_name_2, $course_number_2);
        $test_course_2->save();

        Course::deleteAll();
        $result = Course::getAll();

        $this->assertEquals([], $result);
    }

    function testGetAll()
    {
        $course_name = "Introduction to Five Element Theory";
        $course_number = "MED201";
        $course_name_2 = "Criminal Law";
        $course_number_2 = "LAW201";
        $test_course = new Course($course_name, $course_number);
        $test_course->save();
        $test_course_2 = new Course($course_name_2, $course_number_2);
        $test_course_2->save();

        $result = Course::getAll();

        $this->assertEquals([$test_course, $test_course_2], $result);
    }

    function testFind()
    {
        $course_name = "Human Anatomy 2";
        $course_number = "SCI102";
        $course_name2 = "Victim Studies";
        $course_number_2 = "LAW322";
        $test_course = new Course($course_name, $course_number);
        $test_course->save();
        $test_course_2 = new Course($course_name2, $course_number_2);
        $test_course_2->save();

        $result = Course::find($test_course->getId());

        $this->assertEquals($test_course, $result);
    }

    function testUpdateCourseName()
    {
        $course_name = "Creative Writing";
        $course_number = "ENG322";
        $test_course = new Course($course_name, $course_number);
        $course_name_2 = "Writing Poetry";
        $test_course->save();

        $test_course->updateCourseName($course_name_2);

        $this->assertEquals($course_name_2, $test_course->geCoursetName());
    }

    function testUpdateCourseNumber()
    {
        $course_name = "World Geography";
        $course_number = "GEO222";
        $test_course = new Course($course_name, $course_number);
        $course_number_2 = "GEO221";
        $test_course->save();

        $test_course->updateCourseNumber($course_number_2);

        $this->assertEquals($course_number_2, $test_course->getCourseNumber());
    }

    function testDelete()
    {

        $course_name = "Buddhist Studies";
        $course_number = "REL301";
        $test_course = new Course($course_name, $course_number);
        $test_course->save();
        $course_name_2 = "Philosoph of Reason";
        $course_number_2 = "PHIL302";
        $test_course_2 = new Course($course_name_2, $course_number_2);
        $test_course_2->save();

        $test_course->delete();

        $this->assertEquals([$test_course_2], Course::getAll());
    }

}

?>
