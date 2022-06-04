/* 3.1 - find researchers */

SELECT r.first_name as 'First Name', r.last_name as 'Last Name'
FROM researcher r INNER JOIN works_on
ON r.researcher_id = works_on.researcher_id
WHERE works_on.project_id = project_id;

SELECT p.title, p.ammount, e.first_name, e.last_name, p.start_date, TIMESTAMPDIFF(year, start_date, end_date) as Duration
FROM project p INNER JOIN executive e
ON p.executive_id=e.executive_id
WHERE (p.start_date >= $date1
       AND p.start_date <= date2
       AND DATEDIFF(end_date,start_date) DIV 365 = $dur
       AND e.executive_id = $ex );

/*----------------------------------------------------------------------------*/

 /* 3.2 */

/*Project/Researcher */

CREATE VIEW project_researcher_vw (researcher_id, full_name, r_age, project_id, title, start_date, end_date)
AS
  SELECT r.researcher_id, concat(r.first_name, " ", r.last_name) AS full_name, TIMESTAMPDIFF(year, birth_date, now())  as r_age,
         p.project_id, p.title, p.start_date, p.end_date
  FROM (researcher r INNER JOIN works_on wo ON r.researcher_id = wo.researcher_id)
  INNER JOIN project p ON p.project_id = wo.project_id
  ORDER BY r.researcher_id;


/*Organization - Number of projects per year vw */

CREATE VIEW organization_proj_vw (organization_id, org_name, cnt, grade_date)
AS
   SELECT o.organization_id AS ID,o.org_name AS NAME, count(*) AS cnt, extract(YEAR FROM p.grade_date) AS YEAR
   FROM organization o INNER JOIN project p
   ON o.organization_id=p.organization_id
   GROUP BY NAME,YEAR,ID
   ORDER BY o.organization_id;

/*EXTRAs:

1) ACTIVE PROJECTS */

CREATE VIEW active_projects (project_id,title,ammount,start_date,end_date,grade,grade_date,evaluator_id,supervisor_id,organization_id,executive_id,program_id,summary)
AS
 SELECT * FROM project
 WHERE start_date<=CURDATE() AND end_date>=CURDATE();

 /*
2) Researcher/Number of projects  */

CREATE VIEW researcher_proj_vw (researcher_id, first_name, last_name, age, cnt)
AS
  SELECT r.researcher_id, r.first_name, r.last_name , TIMESTAMPDIFF(year, birth_date, now())  as r_age, count(*) as cnt
  FROM researcher r INNER JOIN works_on wo
  ON r.researcher_id=wo.researcher_id
  GROUP BY r.researcher_id,r.first_name,r.last_name, r_age;


/*----------------------------------------------------------------------------*/

/* 3.3 */

/* 3.3 - Projects */
SELECT ap.project_id, ap.title FROM active_projects ap
INNER JOIN field_project fp ON
ap.project_id = fp.project_id
WHERE fp.field_name=$field;

/* 3.3 - Researchers */
SELECT r.researcher_id,r.first_name, r.last_name FROM researcher r
INNER JOIN works_on wo
ON r.researcher_id = wo.researcher_id
WHERE wo.project_id IN
( SELECT ap.project_id FROM active_projects ap
  INNER JOIN field_project fp
  ON ap.project_id = fp.project_id
  WHERE (fp.field_name='Agricultural Sciences'
          AND ap.start_date<=DATE_SUB(CURDATE(),INTERVAL 1 YEAR) )
);



/*----------------------------------------------------------------------------*/

/* 3.4 */

SELECT distinct u.organization_id, u.org_name as 'ORGANIZATION NAME', u.grade_date as 'FIRST YEAR', (u.grade_date+1) AS 'SECOND YEAR', u.cnt AS 'COUNT'
FROM
organization_proj_vw u
inner join
organization_proj_vw v
ON u.organization_id = v.organization_id
WHERE u.grade_date = v.grade_date+1 AND u.cnt=v.cnt AND u.cnt>=10;

/*----------------------------------------------------------------------------*/

/* 3.5*/

SELECT count(fp1.project_id) as cnt, fp1.field_name as field1, fp2.field_name as field2
FROM field_project fp1 INNER JOIN field_project fp2
ON (fp1.project_id=fp2.project_id and fp1.field_name<fp2.field_name)
GROUP BY fp1.field_name, fp2.field_name
ORDER BY cnt DESC LIMIT 3;

/*----------------------------------------------------------------------------*/

/*3.6*/

SELECT researcher_id, full_name, r_age, count(project_id) as cnt
FROM project_researcher_vw
WHERE project_id IN (SELECT project_id FROM active_projects)
GROUP BY researcher_id,full_name, r_age
HAVING r_age < 40
ORDER BY cnt DESC LIMIT 10;

/*----------------------------------------------------------------------------*/

/* 3.7*/
SELECT e.first_name, e.last_name, c.company_name, sum(c.amt) as total_ammount
FROM executive e
INNER JOIN
  (SELECT o.org_name as company_name, p.ammount as amt, p.executive_id as executive_id
  FROM project p
  INNER JOIN organization o
  ON p.organization_id=o.organization_id
  WHERE o.org_type="company") c
ON e.executive_id= c.executive_id
GROUP BY e.first_name, e.last_name, c.company_name
ORDER BY total_ammount DESC
LIMIT 5;

/*----------------------------------------------------------------------------*/

/* 3.8*/
SELECT researcher_id, full_name, count(project_id) as cnt
FROM project_researcher_vw
WHERE project_id IN (SELECT project_id FROM active_projects)
  AND project_id NOT IN (SELECT project_id FROM deliverable)
GROUP BY researcher_id, full_name
HAVING cnt >= 5;
