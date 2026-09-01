DROP TRIGGER IF EXISTS `after_new_user_insert`;

DELIMITER $$


CREATE TRIGGER `after_new_user_insert`
AFTER INSERT ON `users`
FOR EACH ROW
BEGIN
    INSERT INTO user_score(userID, username, score) VALUES (NEW.userID, NEW.username, 0);
END $$

DELIMITER ;