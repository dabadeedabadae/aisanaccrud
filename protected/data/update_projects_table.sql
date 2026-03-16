-- Add new fields to projects table
ALTER TABLE `tbl_projects` 
ADD COLUMN `goals` TEXT DEFAULT NULL AFTER `description`,
ADD COLUMN `developers` TEXT DEFAULT NULL AFTER `goals`,
ADD COLUMN `contacts` TEXT DEFAULT NULL AFTER `developers`;


