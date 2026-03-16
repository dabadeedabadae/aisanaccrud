-- Update news table to store images in database (base64)
ALTER TABLE `tbl_news` 
MODIFY COLUMN `image` LONGTEXT DEFAULT NULL COMMENT 'Base64 encoded image data';

-- Update projects table to store logo in database (base64)
ALTER TABLE `tbl_projects` 
MODIFY COLUMN `logo` LONGTEXT DEFAULT NULL COMMENT 'Base64 encoded logo image data';

-- Screenshots in projects are already stored as JSON, but we'll store base64 inside
-- No need to change the column type, just the content format

