<?php
// Name of the database that Online Grades Uses
$databasename = "vmsdemo";

// Name/IP of the database server
// Default: $databaseserver = "localhost";
$databaseserver = "localhost";

// User account that can access the database
$datausername = "myuser";

// Password for user that can access the database
$datapassword = "PaSsWoRd";


// This provides direct links to some SIS pages; we use infinite campus
// if you are using anther SIS you may need to change more then the URLs
// You must already be logged into campus for these to work

$campusSummaryUrl = 'https://url.to.your.campus.install/campus/core/person/summary/summary.icml?&x=census.CensusContactSummary-listSummary&personID='.$campusID.'&pattern=ContactIdentity&&formType=detail&framed=true&pageStyle=mainDefault&nodeID=519&objRights=519&&x=core.Person&x=custom.CustomStudent-list&x=core.RaceEthnicity-list&dictionary=Identity.raceEthnicity&dictionary=Identity.raceEthnicityDetermination&dictionary=Identity.stateHispanicEthnicity&dictionary=Person&loadModifiedByPerson=1&';

$campusScheduleUrl = 'https://url.to.your.campus.install/campus/student/schedule/schedule.icml?x=scheduling.StudentSchedule&personID='.$campusID.'&nodeID=404&objRights=404&noaddresses=1&framed=true&&x=calendar.Day&calendarID=calendarCookie&structureID=structureScope&&date=02/12/2014';

$campusAttendanceUrl = 'https://url.to.your.campus.install/campus/attendance/student/student.icml?x=processManagement.RecordsTransfer-linkReport&type=attendance&x=attendance.PeriodAttendance&calendarID=139&&formType=detail&framed=true&pageStyle=mainDefault&nodeID=406&objRights=406&&date=&personID='.$campusID.'&x=calendar.Calendar-loadCalendarStructure&x=attendance.AttendanceCourseCount-getAttendanceCourseCount&x=calendar.Term-termDays&outline=attendance.StudentAttendance&structureID=structureScope&';