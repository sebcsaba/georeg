CREATE TABLE event (
	id INT PRIMARY KEY NOT NULL auto_increment,
	name VARCHAR(2000) NOT NULL,
	event_date DATE NOT NULL,
	registration_end DATETIME NOT NULL,
	international BOOL NOT NULL
) CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE participant (
	id INT PRIMARY KEY NOT NULL auto_increment,
	fk_event INT NOT NULL REFERENCES event(id) ON DELETE CASCADE,
	fk_driver INT NULL,
	fk_navigator INT NULL,
	fk_technical_driver INT NULL,
	reg_number INT NULL,
	car_type VARCHAR(2000) NULL,
	car_reg_number VARCHAR(2000) NULL,
	country VARCHAR(2) NOT NULL,
	additional_guests INT NOT NULL,
	comment VARCHAR(2000) NULL,
	date DATETIME NOT NULL
) CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE player (
	id INT PRIMARY KEY NOT NULL auto_increment,
	fk_participant INT NOT NULL REFERENCES participant(id) ON DELETE CASCADE,
	name VARCHAR(2000) NOT NULL,
	email VARCHAR(2000) NULL,
	phone VARCHAR(2000) NULL
) CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE participant ADD CONSTRAINT FOREIGN KEY (fk_driver) REFERENCES player (id);
ALTER TABLE participant ADD CONSTRAINT FOREIGN KEY (fk_navigator) REFERENCES player (id);
ALTER TABLE participant ADD CONSTRAINT FOREIGN KEY (fk_technical_driver) REFERENCES player (id);
