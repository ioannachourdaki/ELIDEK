
CREATE SCHEMA elidek_db;

USE elidek_db;

CREATE TABLE organization (
    organization_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    abbreviation VARCHAR(20) DEFAULT NULL,
    org_name VARCHAR(50),
    street_name VARCHAR(50),
    street_number INT,
    zip VARCHAR(20),
    city VARCHAR(50),
    org_type ENUM('university', 'research_center', 'company'),
    PRIMARY KEY (organization_id)
    );

CREATE TABLE phone_number (
    organization_id INT UNSIGNED NOT NULL,
    pnumber VARCHAR(20) NOT NULL,
    PRIMARY KEY (organization_id, pnumber),
    CONSTRAINT fk_number_organization FOREIGN KEY (organization_id) REFERENCES organization (organization_id)
    ON DELETE RESTRICT ON UPDATE CASCADE
    );

CREATE TABLE executive (
    executive_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    PRIMARY KEY (executive_id)
);

CREATE TABLE program (
    program_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    title VARCHAR(50),
    department VARCHAR(50),
    PRIMARY KEY (program_id)
);

CREATE TABLE field (
	field_name VARCHAR (50) NOT NULL,
    PRIMARY KEY (field_name)
);

CREATE TABLE researcher (
	researcher_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	first_name VARCHAR(50),
    last_name VARCHAR(50),
	sex ENUM('Female', 'Male', 'Other'),
    birth_date DATE,
    organization_id INT UNSIGNED NOT NULL,
    org_start_date DATE,
    PRIMARY KEY (researcher_id),
    CONSTRAINT fk_reasearcher_organization FOREIGN KEY (organization_id) REFERENCES organization(organization_id)
    ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT researcher_dates_check CHECK ( birth_date < org_start_date )
);


CREATE TABLE project (
	project_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    title VARCHAR(200),
    ammount INT UNSIGNED,
    start_date DATE,
    end_date DATE,
    grade ENUM('A', 'B', 'C', 'D', 'E', 'F'),
    grade_date DATE,
    evaluator_id INT UNSIGNED NOT NULL,
    supervisor_id INT UNSIGNED NOT NULL,
    organization_id INT UNSIGNED NOT NULL,
    executive_id INT UNSIGNED NOT NULL,
    program_id INT UNSIGNED NOT NULL,
    summary VARCHAR(200),
    PRIMARY KEY(project_id),
    CONSTRAINT fk_evaluator_id FOREIGN KEY (evaluator_id) REFERENCES researcher(researcher_id)
    ON DELETE RESTRICT ON UPDATE RESTRICT,
    CONSTRAINT fk_supervisor_id FOREIGN KEY (supervisor_id) REFERENCES researcher(researcher_id)
    ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_org_id FOREIGN KEY (organization_id) REFERENCES organization(organization_id)
    ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_executive_id FOREIGN KEY (executive_id) REFERENCES executive(executive_id)
    ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_program_id FOREIGN KEY (program_id) REFERENCES program(program_id)
    ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT check_ammount CHECK ( ammount >= 100000 AND ammount <= 1000000),
    CONSTRAINT check_min_duration CHECK (end_date >= DATE_ADD(start_date, INTERVAL 1 YEAR)),
    CONSTRAINT check_max_duration CHECK (end_date <= DATE_ADD(start_date, INTERVAL 4 YEAR)),
    CONSTRAINT check_gr_date CHECK (grade_date < start_date )
    );


CREATE TABLE deliverable (
    project_id INT UNSIGNED NOT NULL,
    title VARCHAR(50) NOT NULL,
    summary VARCHAR(200) NOT NULL,
    deadline DATE,
    PRIMARY KEY (project_id, title, summary),
    CONSTRAINT fk_deliverable_project FOREIGN KEY (project_id) REFERENCES project (project_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE works_on(
	project_id INT UNSIGNED NOT NULL ,
    researcher_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (project_id, researcher_id),
	CONSTRAINT fk_researcher_works_on FOREIGN KEY (researcher_id) REFERENCES researcher(researcher_id)
    ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_project_works_on FOREIGN KEY (project_id) REFERENCES project(project_id)
    ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE field_project (
	project_id INT UNSIGNED NOT NULL,
    field_name VARCHAR (50) NOT NULL,
    PRIMARY KEY (project_id, field_name),
    CONSTRAINT fk_project_field_p FOREIGN KEY (project_id) REFERENCES project (project_id)
    ON DELETE CASCADE ON UPDATE CASCADE,
	  CONSTRAINT fk_project_field_f FOREIGN KEY (field_name) REFERENCES field (field_name)
    ON DELETE RESTRICT ON UPDATE CASCADE
);

/*----------------------------------------------------------------------------*/
/* views */
/* Firrst two views are the answer to 3.2 */
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
/* indexes */

CREATE INDEX idx_researcher_full_name ON researcher (first_name, last_name);
CREATE INDEX idx_executive_full_name ON executive (first_name, last_name);
CREATE INDEX idx_organization_name ON organization (org_name);


/*----------------------------------------------------------------------------*/
/* triggers */

DELIMITER ;;

CREATE TRIGGER check_evaluator AFTER INSERT ON project FOR EACH ROW
BEGIN
	IF 	new.evaluator_id = new.supervisor_id OR
		new.organization_id = (	SELECT organization_id
								FROM researcher
                                WHERE researcher.researcher_id = new.evaluator_id	)
	THEN
		SIGNAL sqlstate '45001' set message_text = "No way ! You cannot do this !";
	END IF;
END;;

DELIMITER ;;
CREATE TRIGGER check_works_on AFTER INSERT ON works_on FOR EACH ROW
BEGIN
	IF (SELECT organization_id
		FROM researcher
		WHERE researcher.researcher_id = new.researcher_id) !=
        (	SELECT organization_id
			FROM project
			WHERE project.project_id = new.project_id)
	THEN
		SIGNAL sqlstate '45001' set message_text = "No way ! You cannot do this !";
	END IF;
END;;

DELIMITER ;;

CREATE TRIGGER check_deliverable AFTER INSERT ON deliverable FOR EACH ROW
BEGIN
	IF (	new.deadline < (SELECT start_date from project where project_id=new.project_id)
    OR  new.deadline > (SELECT end_date from project where project_id=new.project_id) )
	THEN
		SIGNAL sqlstate '45001' set message_text = "No way ! You cannot do this !";
	END IF;
END;;

DELIMITER ;;

CREATE TRIGGER check_deliverable_update AFTER UPDATE ON deliverable FOR EACH ROW
BEGIN
	IF (	new.deadline < (SELECT start_date from project where project_id=new.project_id)
    OR  new.deadline > (SELECT end_date from project where project_id=new.project_id) )
	THEN
		SIGNAL sqlstate '45001' set message_text = "No way ! You cannot do this !";
	END IF;
END;;
