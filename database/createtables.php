<?php

$path=$_SERVER['DOCUMENT_ROOT'];
require_once $path."/attendanceapp/database/database.php";
function clearTable($dbo,$tabName)
{
    $c="delete from :tabname";
    $s=$dbo->conn->prepare($c);
    try{
    $s->execute([":tabname"=>$tabName]);
    }
    catch(PDOException $oo)
    {

    }
}
$dbo=new Database();
$c="create table student_details
(
    id int auto_increment primary key,
    roll_no varchar(20) unique,
    name varchar(50)
)";
$s=$dbo->conn->prepare($c);
try{
$s->execute();
echo("<br>student_details created");
}
catch(PDOException $o)
{
echo("<br>student_details not created");
}

$c="create table course_details
(
    id int auto_increment primary key,
    code varchar(20) unique,
    title varchar(50),
    credit int
)";
$s=$dbo->conn->prepare($c);
try{
$s->execute();
echo("<br>course_details created");
}
catch(PDOException $o)
{
echo("<br>course_details not created");
}


$c="create table faculty_details
(
    id int auto_increment primary key,
    user_name varchar(20) unique,
    name varchar(100),
    password varchar(50)
)";
$s=$dbo->conn->prepare($c);
try{
$s->execute();
echo("<br>faculty_details created");
}
catch(PDOException $o)
{
echo("<br>faculty_details not created");
}


$c="create table session_details
(
    id int auto_increment primary key,
    year int,
    term varchar(50),
    unique (year,term)
)";
$s=$dbo->conn->prepare($c);
try{
$s->execute();
echo("<br>session_details created");
}
catch(PDOException $o)
{
echo("<br>session_details not created");
}



$c="create table course_registration
(
    student_id int,
    course_id int,
    session_id int,
    primary key (student_id,course_id,session_id)
)";
$s=$dbo->conn->prepare($c);
try{
$s->execute();
echo("<br>course_registration created");
}
catch(PDOException $o)
{
echo("<br>course_registration not created");
}

$c="create table course_allotment
(
    faculty_id int,
    course_id int,
    session_id int,
    primary key (faculty_id,course_id,session_id)
)";
$s=$dbo->conn->prepare($c);
try{
$s->execute();
echo("<br>course_allotment created");
}
catch(PDOException $o)
{
echo("<br>course_allotment not created");
}

$c="create table attendance_details
(
    faculty_id int,
    course_id int,
    session_id int,
    student_id int,
    on_date date,
    status varchar(10),
    primary key (faculty_id,course_id,session_id,student_id,on_date)
)";
$s=$dbo->conn->prepare($c);
try{
$s->execute();
echo("<br>attendance_details created");
}
catch(PDOException $o)
{
echo("<br>attendance_details not created");
}

$c="insert into student_details
(id,roll_no,name)
values
  (1, 'CSB21001', 'ABI'),
  (2, 'CSB21002', 'ANU'),
  (3, 'CSB21003', 'ASWINI'),
  (4, 'CSB21004', 'BINDHU'),
  (5, 'CSB21005', 'CHITRAN'),
  (6, 'CSB21006', 'DEVA'),
  (7, 'CSB21007', 'GURLEEN KAUR'),
  (8, 'CSB21008', 'HARINI'),
  (9, 'CSB21009', 'HARSHINI'),
  (10, 'CSB21010', 'HEMA'),
  (11, 'CSB21011', 'HRITTIK BARUAH'),
  (12, 'CSB21012', 'ISHWARYA'),
  (13, 'CSM21001', 'JASWANTH'),
  (14, 'CSM21002', 'JEEVA'),
  (15, 'CSM21003', 'KAMATCHI'),
  (16, 'CSM21004', 'KAUSIKA'),
  (17, 'CSM21005', 'KEERTHANA'),
  (18, 'CSM21006', 'LAVANYA'),
  (19, 'CSM21007', 'MADHUMITHA'),
  (20, 'CSM21008', 'MANIKANDAN'),
  (21, 'CSM21009', 'MANOBLAN'),
  (22, 'CSM21010', 'MARESELVAM'),
  (23, 'CSM21011', 'MAHESH'),
  (24, 'CSM21012', 'Nivarsana')";


  $s=$dbo->conn->prepare($c);
  try{
    $s->execute();
  }
  catch(PDOException $o)
  {
    echo("<br>duplicate entry");
  }


  $c = "INSERT INTO faculty_details
  (id, user_name, password, name)
  VALUES
  (1, 'Sathya', '123', 'Sathya'),
  (2, 'Jayanthi', '123', 'Jayanthi'),
  (3, 'Preethi', '123', 'Preethi'),
  (4, 'Thomas', '123', 'Thomas'),
  (5, 'BenedictRaja', '123', 'BenedictRaja'),
  (6, 'Suresh', '123', 'Suresh')";
  

  $s=$dbo->conn->prepare($c);
  try{
    $s->execute();
  }
  catch(PDOException $o)
  {
    echo("<br>duplicate entry");
  }


  $c="insert into session_details
(id,year,term)
values
(1,2023,'EVEN SEMESTER'),
(2,2023,'ODD SEMESTER')";

  $s=$dbo->conn->prepare($c);
  try{
    $s->execute();
  }
  catch(PDOException $o)
  {
    echo("<br>duplicate entry");
  }


  $c="insert into course_details
(id,title,code,credit)
values
  (1,'Database management system lab','CO321',2),
  (2,'Pattern Recognition','CO215',3),
  (3,'Data Mining & Data Warehousing','CS112',4),
  (4,'ARTIFICIAL INTELLIGENCE','CS670',4),
  (5,'THEORY OF COMPUTATION ','CO432',3),
  (6,'DEMYSTIFYING NETWORKING ','CS673',1)";
  $s=$dbo->conn->prepare($c);
  try{
    $s->execute();
  }
  catch(PDOException $o)
  {
    echo("<br>duplicate entry");
  }

  //if any record already there in the table delete them
  clearTable($dbo,"course_registration");
  $c="insert into course_registration
  (student_id,course_id,session_id)
  values
  (:sid,:cid,:sessid)";
  $s=$dbo->conn->prepare($c);
  //iterate over all the 24 students
  //for each of them chose max 3 random courses, from 1 to 6

  for($i=1;$i<=24;$i++)
  {
    for($j=0;$j<3;$j++)
    {
        $cid=rand(1,6);
        //insert the selected course into course_registration table for 
        //session 1 and student_id $i
        try{
           $s->execute([":sid"=>$i,":cid"=>$cid,":sessid"=>1]); 
        }
        catch(PDOException $pe)
        {

        }

        //repeat for session 2
        $cid=rand(1,6);
        //insert the selected course into course_registration table for 
        //session 2 and student_id $i
        try{
           $s->execute([":sid"=>$i,":cid"=>$cid,":sessid"=>2]); 
        }
        catch(PDOException $pe)
        {

        }
    }
  }


  //if any record already there in the table delete them
  clearTable($dbo,"course_allotment");
  $c="insert into course_allotment
  (faculty_id,course_id,session_id)
  values
  (:fid,:cid,:sessid)";
  $s=$dbo->conn->prepare($c);
  //iterate over all the 6 teachers
  //for each of them chose max 2 random courses, from 1 to 6

  for($i=1;$i<=6;$i++)
  {
    for($j=0;$j<2;$j++)
    {
        $cid=rand(1,6);
        //insert the selected course into course_allotment table for 
        //session 1 and fac_id $i
        try{
           $s->execute([":fid"=>$i,":cid"=>$cid,":sessid"=>1]); 
        }
        catch(PDOException $pe)
        {

        }

        //repeat for session 2
        $cid=rand(1,6);
        //insert the selected course into course_allotment table for 
        //session 2 and student_id $i
        try{
           $s->execute([":fid"=>$i,":cid"=>$cid,":sessid"=>2]); 
        }
        catch(PDOException $pe)
        {

        }
    }
  }