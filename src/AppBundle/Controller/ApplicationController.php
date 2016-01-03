<?php
/**
 * Created by PhpStorm.
 * User: Yasas
 * Date: 1/2/2016
 * Time: 10:39 AM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Student;
use DateTime;

class ApplicationController
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function applicationSearch($index)
    {
        // Get connection
        $conn = $this->connection;
        // Get Application -------------------------------------------------
        $db_res = $conn->fetchAssoc('SELECT * FROM application WHERE student_index = ?', array($index));
        $student = new Student($db_res['student_index'], 'trial', $db_res['mark']);
        // Build Application ------------------------------------------------
        $application = $student->getApplication();
        $application->setName($db_res['name']);
        $application->setAddress($db_res['address']);
        $application->setApproved($db_res['approve_status']);
        $application->setBirthday(new DateTime($db_res['birthday']));
        $application->setEducationalZone($db_res['edu_zone']);
        $application->setMedium($db_res['medium']);
        $application->setGuardiansName($db_res['guardian_name']);
        $application->setGender($db_res['gender']);
        $application->setCurrentSchool(InMemoryStorage::getInstance()->getSchoolByName($db_res['current_school']));
        // - Add selected schools -------------------------------------------
        $stmt = $conn->prepare('SELECT * FROM applied_schools WHERE student_index = ?');
        $stmt->bindValue(1, $index);
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $application->addAppliedSchools(InMemoryStorage::getInstance()->getSchoolByName($row['school_applied']));
        }
        // Set application --------------------------------------------------
        $student->setApplication($application);
        return $student;
    }

    public function applicationUpdate(Student $student)
    {
        $this->connection->beginTransaction();
        try {
            $sql = 'UPDATE application SET `name`=?, address=?, approve_status=?, birthday=?, edu_zone=?, medium=?, guardian_name=?, gender=?, current_school=? WHERE student_index=?';
            $statement = $this->connection->prepare($sql);
            $application = $student->getApplication();
            $statement->bindValue(1, $application->getName());
            $statement->bindValue(2, $application->getAddress());
            $statement->bindValue(3, $application->getApproved());
            $statement->bindValue(4, $application->getBirthday()->format('Y-m-d'));
            $statement->bindValue(5, $application->getEducationalZone());
            $statement->bindValue(6, $application->getMedium());
            $statement->bindValue(7, $application->getGuardiansName());
            $statement->bindValue(8, $application->getGender());
            $statement->bindValue(9, $application->getCurrentSchool()->getName());
            $statement->bindValue(10, $application->getStudentIndex());
            $statement->execute();

            // Remove all applied schools from table ------------------------------
            $sql = 'DELETE FROM applied_schools WHERE student_index=?';
            $statement = $this->connection->prepare($sql);
            $statement->bindValue(1, $application->getStudentIndex());
            $statement->execute();

            // Add all new schools (Updated) -------------------------------------
            $schools = $application->getAppliedSchools();
            $sql = 'INSERT INTO applied_schools (student_index, school_applied) VALUES (?, ?)';
            $statement = $this->connection->prepare($sql);
            foreach ($schools as $school) {
                $statement->bindValue(1, $application->getStudentIndex());
                $statement->bindValue(2, $school->getName());
                $statement->execute();
            }
            $this->connection->commit();
        } catch (Exception $e) {
            $this->connection->rollBack();
            // throw $e;
        }
    }
}
