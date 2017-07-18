<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Student.php";
    require_once __DIR__."/../src/Course.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=registrar';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' =>__DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/students", function() use ($app) {
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->get("/courses", function() use ($app) {
        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->post("/students", function() use ($app) {
        $name = $_POST['name'];
        $enrollment_date = $_POST['enrollment_date'];
        $new_student = new Student($name, $enrollment_date);
        $new_student->save();
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->post("/courses", function() use ($app) {
        $course_name = $_POST['course_name'];
        $course_number = $_POST['course_number'];
        $new_course = new Course($course_name, $course_number);
        $new_course->save();
        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->get("/course/{id}", function($id) use ($app) {
        return $app['twig']->render('course.html.twig', array('enrolled_students' => Course::findStudentsByCourse($id), 'course' => Course::find($id)));
    });

    $app->post("/course/{id}", function($id) use ($app) {
        $enrolled_student_id = $_POST['enrolled_student'];
        // save $enrolled_student_id to course id in database
        return $app['twig']->render('course.html.twig', array('enrolled_students' => Course::findStudentsByCourse($id), 'course' => Course::find($id)));
    });

    return $app;
?>
