DROP TABLE IF EXISTS animal_facts;

CREATE TABLE animal_facts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    animal_id INT UNSIGNED NOT NULL,

    fact_number INT UNSIGNED NOT NULL,

    fact TEXT NOT NULL,

    INDEX (animal_id)
);


INSERT INTO animal_facts (animal_id, fact_number, fact) VALUES
(1, 1, 'Lions are the only big cats that regularly live in large social groups.'),
(1, 2, 'A lion''s roar can be heard from several kilometres away under suitable conditions.'),
(1, 3, 'Lion cubs are born with spots that usually fade as they grow older.'),
(1, 4, 'Female lions usually do most of the hunting for their pride.'),
(1, 5, 'Lions can spend many hours resting after feeding, often sleeping for up to 20 hours a day.');