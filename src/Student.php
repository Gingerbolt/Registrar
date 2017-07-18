<?php
  class Student
  {
      private $name;
      private $enrollment_date;
      private $id;

      function __construct($name_param, $enroll_param, $id_param = null)
      {
          $this->name = $name_param;
          $this->enrollment_date = $enroll_param;
          $this->id = $id_param;
      }

      function getName()
      {
          return $this->name;
      }

      function setName($name_param)
      {
          $this->name = $name_param;
      }

      function getEnrollmentDate()
      {
          return $this->enrollment_date;
      }

      function setEnrollmentDate($enrollment_date_param)
      {
          $this->enrollment_date = $enrollment_date_param;
      }

      function getId()
      {
          return $this->id;
      }

      function save()
      {
          $executed = $GLOBALS['DB']->exec("INSERT INTO students (name, enrollment_date) VALUES ('{$this->getName()}', '{$this->getEnrollmentDate()}');");
          if ($executed) {
              $this->id= $GLOBALS['DB']->lastInsertId();
              return true;
          } else {
              return false;
          }
      }

      static function getAll()
      {
          $returned_students = $GLOBALS['DB']->query("SELECT * FROM students;");
          $students = array();
          foreach($returned_students as $student) {
              $name = $student['name'];
              $id = $student['id'];
              $enrollment_date = $student['enrollment_date'];
              $new_student = new Student($name, $enrollment_date, $id);
              array_push($students, $new_student);
          }
          return $students;
      }

      static function deleteAll()
      {
          $GLOBALS['DB']->exec("DELETE FROM students;");
      }

      static function find($search_id)
      {
          $found_student = null;
          $returned_students = $GLOBALS['DB']->prepare("SELECT * FROM students WHERE id = :id;");
          $returned_students->bindParam(':id', $search_id, PDO::PARAM_STR);
          $returned_students->execute();
          foreach($returned_students as $student) {
              $student_name = $student['name'];
              $student_id = $student['id'];
              $student_enrollment_date = $student['enrollment_date'];
              if ($student_id == $search_id) {
                  $found_student = new Student($student_name, $student_enrollment_date, $student_id);
              }
          }
          return $found_student;
      }

      function updateName($new_name)
      {
          $executed = $GLOBALS['DB']->exec("UPDATE students SET name = '{$new_name}' WHERE id = {$this->getId()};");
          if ($executed) {
             $this->setName($new_name);
             return true;
          } else {
             return false;
          }
      }

      function updateEnrollmentDate($new_enrollment_date)
      {
          $executed = $GLOBALS['DB']->exec("UPDATE students SET enrollment_date = '{$new_enrollment_date}' WHERE id = {$this->getId()};");
          if ($executed) {
             $this->setEnrollmentDate($new_enrollment_date);
             return true;
          } else {
             return false;
          }
      }

      function delete()
      {
          $executed = $GLOBALS['DB']->exec("DELETE FROM students WHERE id = {$this->getId()};");
           if (!$executed) {
               return false;
           } else {
               return true;
           }
      }

      function enrollInCourse($course_id)
      {
          $executed = $GLOBALS['DB']->exec("INSERT INTO enrollment (student_id, course_id) VALUES ('{$this->getId()}', '{$course_id}');");
          if ($executed) {
              $this->id= $GLOBALS['DB']->lastInsertId();
              return true;
          } else {
              return false;
          }
      }
  }
?>
