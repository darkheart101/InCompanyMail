/* 15 - 03 - 17 */

ALTER TABLE `icmail`.`users` ADD lastname VARCHAR(45) NULL;
ALTER TABLE `icmail`.`users` ADD name VARCHAR(45) NULL;
ALTER TABLE `icmail`.`receivedemails` ADD emailStatus BIT(1) NULL;
