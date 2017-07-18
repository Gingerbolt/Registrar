<?php
  class Course
  {
      private $course_name;
      private $course_number;
      private $id;

      function __construct($course_name, $course_number, $id = null)
      {
          $this->course_name = $course_name;
          $this->course_number = $course_number;
          $this->id = $id;
      }

      function getCourseName()
      {
          return $this->course_name;
      }

      function setCourseName($course_name)
      {
          $this->course_name = $course_name;
      }

      function getCourseNumber()
      {
          return $this->course_number;
      }

      function setCourseNumber($course_number)
      {
          $this->course_number = $course_number;
      }

      function getId()
      {
          return $this->id;
      }

      function save()
      {
          $executed = $GLOBALS['DB']->exec("INSERT INTO courses (course_name, course_number) VALUES ('{$this->getCourseName()}', '{$this->getCourseNumber()}');");
          if ($executed) {
              $this->id= $GLOBALS['DB']->lastInsertId();
              return true;
          } else {
              return false;
          }
      }

      static function getAll()
      {
          $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses;");
          $courses = array();
          foreach($returned_courses as $course) {
              $course_name = $course['course_name'];
              $course_id = $course['id'];
              $course_number = $course['course_number'];
              $new_course = new Course($course_name, $course_number, $course_id);
              array_push($courses, $new_course);
          }
          return $courses;
      }

      static function deleteAll()
      {
          $GLOBALS['DB']->exec("DELETE FROM courses;");
      }

      static function find($search_id)
      {
          $found_course = null;
          $returned_courses = $GLOBALS['DB']->prepare("SELECT * FROM courses WHERE id = :id;");
          $returned_courses->bindParam(':id', $search_id, PDO::PARAM_STR);
          $returned_courses->execute();
          foreach($returned_courses as $course) {
              $course_name = $course['course_name'];
              $course_id = $course['id'];
              $course_number = $course['course_number'];
              if ($course_id == $search_id) {
                  $found_course = new Course($course_name, $course_number, $course_id);
              }
          }
          return $found_course;
      }

      function updateCourseName($new_course_name)
      {
          $executed = $GLOBALS['DB']->exec("UPDATE courses SET course_name = '{$new_course_name}' WHERE id = {$this->getId()};");
          if ($executed) {
             $this->setCourseName($new_course_name);
             return true;
          } else {
             return false;
          }
      }

      function updateCourseNumber($new_course_number)
      {
          $executed = $GLOBALS['DB']->exec("UPDATE courses SET course_number = '{$new_course_number}' WHERE id = {$this->getId()};");
          if ($executed) {
             $this->setCourseNumber($new_course_number);
             return true;
          } else {
             return false;
          }
      }

      function delete()
      {
          $executed = $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getId()};");
           if (!$executed) {
               return false;
           } else {
               return true;
           }
      }

      function getStudentsByCourse()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT students.* FROM students
                JOIN enrollment ON (students.id = enrollment.student_id)
                JOIN courses ON (enrollment.course_id = courses.id)
                WHERE courses.id = {$this->getId()};");
            $enrolled_students = array();
            foreach($returned_students as $student) {
                $name = $student['name'];
                $enrollment_date = $student['enrollment_date'];
                $id = $student['id'];
                $new_student = new Student($name, $enrollment_date, $id);
                array_push($enrolled_students, $new_student);
            }
            return $enrolled_students;
        }

        function enrollStudent($student)
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO enrollment (course_id, student_id) VALUES ('{$this->getId()}', '{$student}');");
            if ($executed) {
                $this->id= $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }
  }
?>
