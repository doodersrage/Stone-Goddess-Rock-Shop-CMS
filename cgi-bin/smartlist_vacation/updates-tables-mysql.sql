CREATE TABLE IF NOT EXISTS smartlist_vacation (
  list varchar(255) NOT NULL default '',
  email_id varchar(255) NOT NULL default '',
  confirm_str varchar(10) NOT NULL default '',
  is_confirm enum('Y','N') NOT NULL default 'Y'
) 
___ENTRY___
CREATE TABLE IF NOT EXISTS smartlist_version (
  version varchar(32) DEFAULT '' NOT NULL,
  installDate datetime default NULL,
  PRIMARY KEY (version)
);
___ENTRY___
INSERT INTO `smartlist_version` ( `version` , `installDate` )
VALUES ('3.15', NOW( ));
