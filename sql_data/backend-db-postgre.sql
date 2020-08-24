-- MariaDB dump 10.17  Distrib 10.4.11-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: backend-db
-- ------------------------------------------------------
-- Server version	10.4.11-MariaDB
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO,POSTGRESQL' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table "app_sessions"
--

DROP TABLE IF EXISTS "hrdocs"."app_sessions";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "hrdocs"."app_sessions" (
  "id" varchar(40) NOT NULL,
  "ip_address" varchar(255) DEFAULT NULL,
  "timestamp" int DEFAULT NULL,
  "data" TEXT DEFAULT NULL,
  PRIMARY KEY ("id")
);
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table "staffgroup"
--

DROP TABLE IF EXISTS "hrdocs"."staffgroup";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "hrdocs"."staffgroup" (
  "sdg_id" SERIAL NOT NULL,
  "sdg_name" varchar(45) DEFAULT NULL,
  "sdg_desc" varchar(45) DEFAULT NULL,
  "sdg_status" smallint DEFAULT NULL,
  PRIMARY KEY ("sdg_id")
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table "staffgroup"
--

INSERT INTO "hrdocs"."staffgroup" ("sdg_id", "sdg_name", "sdg_desc", "sdg_status") VALUES
(5, 'admin', '', 1);


--
-- Table structure for table "module"
--

DROP TABLE IF EXISTS "hrdocs"."module";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "hrdocs"."module" (
  "mdl_id" SERIAL NOT NULL,
  "mdl_name" varchar(45) DEFAULT NULL,
  "mdl_desc" varchar(45) DEFAULT NULL,
  "mdl_relativeurl" varchar(45) DEFAULT NULL,
  "mdl_status" smallint DEFAULT NULL,
  PRIMARY KEY ("mdl_id")
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table "module"
--


/*!40000 ALTER TABLE "module" DISABLE KEYS */;
INSERT INTO "hrdocs"."module" VALUES (2,'staff','','staff',1);
/*!40000 ALTER TABLE "module" ENABLE KEYS */;


--
-- Table structure for table "moduleaccess"
--

DROP TABLE IF EXISTS "hrdocs"."moduleaccess";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "hrdocs"."moduleaccess" (
  "mda_id" SERIAL NOT NULL,
  "mda_staffgroup" int NOT NULL,
  "mda_module" int NOT NULL,
  "mda_create" smallint DEFAULT 0,
  "mda_read" smallint DEFAULT 0,
  "mda_update" smallint DEFAULT 0,
  "mda_delete" smallint DEFAULT 0,
  PRIMARY KEY ("mda_id","mda_staffgroup","mda_module"),
  CONSTRAINT "fk_staffgroup_has_module_module1" FOREIGN KEY ("mda_module") REFERENCES "hrdocs"."module" ("mdl_id") ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT "fk_staffgroup_has_module_staffgroup1" FOREIGN KEY ("mda_staffgroup") REFERENCES "hrdocs"."staffgroup" ("sdg_id") ON DELETE NO ACTION ON UPDATE NO ACTION
);
/*!40101 SET character_set_client = @saved_cs_client */;

CREATE INDEX "fk_staffgroup_has_module_module1_idx" ON "hrdocs"."moduleaccess" ("mda_module");
CREATE INDEX "fk_staffgroup_has_module_staffgroup1_idx" ON "hrdocs"."moduleaccess" ("mda_staffgroup");

--
-- Dumping data for table "moduleaccess"
--

/*!40000 ALTER TABLE "moduleaccess" DISABLE KEYS */;
INSERT INTO "hrdocs"."moduleaccess" VALUES (69,5,2,1,1,1,1);
/*!40000 ALTER TABLE "moduleaccess" ENABLE KEYS */;


--
-- Table structure for table "modulemenu"
--

DROP TABLE IF EXISTS "hrdocs"."modulemenu";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "hrdocs"."modulemenu" (
  "mdm_id" SERIAL NOT NULL,
  "mdm_title" varchar(45) DEFAULT NULL,
  "mdm_url" varchar(45) DEFAULT NULL,
  "mdm_staffgroup" varchar(255) DEFAULT NULL,
  "mdm_parent" int DEFAULT 0,
  "mdm_group" varchar(45) DEFAULT NULL,
  "mdm_class" varchar(45) DEFAULT NULL,
  "mdm_order" smallint DEFAULT NULL,
  "mdm_status" smallint DEFAULT NULL,
  PRIMARY KEY ("mdm_id")
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table "modulemenu"
--


/*!40000 ALTER TABLE "modulemenu" DISABLE KEYS */;
INSERT INTO "hrdocs"."modulemenu" VALUES (22,'Pengguna','staff','5',NULL,'System','ik ik-users',20,1);
/*!40000 ALTER TABLE "modulemenu" ENABLE KEYS */;


--
-- Table structure for table "staff"
--

DROP TABLE IF EXISTS "hrdocs"."staff";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "hrdocs"."staff" (
  "stf_id" SERIAL NOT NULL,
  "stf_name" varchar(45) DEFAULT NULL,
  "stf_username" varchar(45) DEFAULT NULL,
  "stf_email" varchar(255) DEFAULT NULL,
  "stf_password" varchar(255) DEFAULT NULL,
  "stf_lastlogin" timestamp NULL DEFAULT NULL,
  "stf_status" smallint DEFAULT NULL,
  "stf_created" timestamp NULL DEFAULT NULL,
  "stf_updated" timestamp NULL DEFAULT NULL,
  PRIMARY KEY ("stf_id")
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table "staff"
--


/*!40000 ALTER TABLE "staff" DISABLE KEYS */;
INSERT INTO "hrdocs"."staff" VALUES (3,'admin','admin','','$2y$10$rLa7p9zhJJxFFctE/J9qRO83rFtnGOF6wweBNezMywXKh2kvCcEbG','2020-07-22 05:01:12',1,'2020-07-22 04:57:36','2020-07-22 04:57:36');
/*!40000 ALTER TABLE "staff" ENABLE KEYS */;





--
-- Table structure for table "staffgroupaccess"
--

DROP TABLE IF EXISTS "hrdocs"."staffgroupaccess";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "hrdocs"."staffgroupaccess" (
  "sga_staffgroup" int NOT NULL,
  "sga_staff" int NOT NULL,
  PRIMARY KEY ("sga_staffgroup","sga_staff"),
  CONSTRAINT "fk_staffgroup_has_staff_staff1" FOREIGN KEY ("sga_staff") REFERENCES "hrdocs"."staff" ("stf_id") ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT "fk_staffgroup_has_staff_staffgroup1" FOREIGN KEY ("sga_staffgroup") REFERENCES "hrdocs"."staffgroup" ("sdg_id") ON DELETE NO ACTION ON UPDATE NO ACTION
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table "staffgroupaccess"
--





--
-- Table structure for table "stafflog"
--

DROP TABLE IF EXISTS "hrdocs"."stafflog";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "hrdocs"."stafflog" (
  "sdl_id" SERIAL NOT NULL,
  "sdl_module" varchar(45) DEFAULT NULL,
  "sdl_action" varchar(45) DEFAULT NULL,
  "sdl_staff" varchar(45) DEFAULT NULL,
  "sdl_date" timestamp DEFAULT NULL,
  "sdl_note" text DEFAULT NULL,
  "sdl_ip" varchar(45) DEFAULT NULL,
  PRIMARY KEY ("sdl_id")
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table "stafflog"
--

--
-- Table structure for table "doc_m_role_view"
--
DROP TABLE IF EXISTS "hrdocs"."doc_m_role_view";

CREATE TABLE "hrdocs"."doc_m_role_view" (
  "sort_id" SERIAL NOT NULL,
  "role_view" varchar(20) ,
  "role_view_desc" varchar(50),
  "service_account" varchar(50),
  "service_account_path_key" varchar(50),
  CONSTRAINT "doc_m_role_view_pkey" PRIMARY KEY ("role_view")
);
comment on table hrdocs.doc_m_role_view is 'Table for store credential to access document on google cloud storage based service account already give permission';


--
-- Table structure for table "doc_m_type"
--
DROP TABLE IF EXISTS "hrdocs"."doc_m_type";

CREATE TABLE "hrdocs"."doc_m_type" (
  "sort_id" SERIAL NOT NULL,
  "doc_type" varchar(20) NOT NULL,
  "doc_type_desc" varchar(50),
  "default_role_view" varchar(20),
  CONSTRAINT "doc_m_type_pkey" PRIMARY KEY ("doc_type")
);
comment on table hrdocs.doc_m_type is 'Table like category for document';
comment on column hrdocs.doc_m_type.default_role_view is 'If filled will reference to table role view';


--
-- Table structure for table "doc_mime"
--
DROP TABLE IF EXISTS "hrdocs"."doc_mime";

CREATE TABLE "hrdocs"."doc_mime" (
  "sort_id" SERIAL NOT NULL,
  "doc_mime" varchar(20) NOT NULL,
  "doc_mime_desc" varchar(50),
  "doc_mime_icon" varchar(50),
  CONSTRAINT "doc_mime_pkey" PRIMARY KEY ("doc_mime")
);

--
-- Table structure for table "doc_detail"
--

DROP TABLE IF EXISTS "hrdocs"."doc_detail";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "hrdocs"."doc_detail" (
  "doc_id" SERIAL NOT NULL,
  "parentdoc_id" int8,
  "nik" varchar(10),
  "doc_title" varchar(45) DEFAULT NULL,
  "doc_no" varchar(45) DEFAULT NULL,
  "doc_date" timestamp(6),
  "doc_version" varchar(10),
  "doc_mime" varchar(20),
  "doc_type" varchar(20),
  "doc_tag" varchar(50),
  "doc_remark" varchar(200) DEFAULT NULL,
  "pagecount" int8,
  "role_view" varchar(15),
  "doc_url" varchar(255) DEFAULT NULL,
  "doc_filename" varchar(255) DEFAULT NULL,
  "inputted_date" timestamp NULL DEFAULT NULL,
  "inputted_by" varchar(20) NULL DEFAULT NULL,
  "inputted_from" varchar(50) NULL DEFAULT NULL,
  "edited_date" timestamp NULL DEFAULT NULL,
  "edited_by" varchar(20) NULL DEFAULT NULL,
  "edited_from" varchar(50) NULL DEFAULT NULL,
  PRIMARY KEY ("doc_id")
);
comment on column hrdocs.doc_detail.nik is 'If filled, user login with this nikk will allow read this document';
comment on column hrdocs.doc_detail.doc_remark is 'The detail of document';
comment on column hrdocs.doc_detail.pagecount is 'The total of page if this is a pdf/word';
comment on column hrdocs.doc_detail.role_view is 'The role of access document, get from role type data';
comment on column hrdocs.doc_detail.doc_url is 'The url to request presigned url to access object on google cloud storage';
comment on column hrdocs.doc_detail.doc_filename is 'The object location to access document on google cloud storage';
comment on column hrdocs.doc_detail.doc_mime is 'The mime type of document, referenced to table doc_mime';

--
-- Table structure for table "doc_detail_his"
--


DROP TABLE IF EXISTS "hrdocs"."doc_detail_his";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "hrdocs"."doc_detail_his" (
  "doc_id" int8,
  "parentdoc_id" int8,
  "nik" varchar(10),
  "doc_title" varchar(45) DEFAULT NULL,
  "doc_no" varchar(45) DEFAULT NULL,
  "doc_date" timestamp(6),
  "doc_version" varchar(10),
  "doc_mime" varchar(20),
  "doc_type" varchar(20),
  "doc_tag" varchar(50),
  "doc_remark" varchar(200) DEFAULT NULL,
  "pagecount" int8,
  "role_view" varchar(15),
  "doc_url" varchar(255) DEFAULT NULL,
  "doc_filename" varchar(255) DEFAULT NULL,
  "inputted_date" timestamp NULL DEFAULT NULL,
  "inputted_by" varchar(20) NULL DEFAULT NULL,
  "inputted_from" varchar(50) NULL DEFAULT NULL,
  "edited_date" timestamp NULL DEFAULT NULL,
  "edited_by" varchar(20) NULL DEFAULT NULL,
  "edited_from" varchar(50) NULL DEFAULT NULL,
  "deleted_date" timestamp NULL DEFAULT NULL,
  "deleted_by" varchar(20) NULL DEFAULT NULL,
  "deleted_from" varchar(50) NULL DEFAULT NULL
);
comment on table hrdocs.doc_detail_his is 'Table for record history on doc_detail';


--
-- Table structure for table "doc_note"
--
DROP TABLE IF EXISTS "hrdocs"."doc_note";
CREATE TABLE "hrdocs"."doc_note" (
  "note_id" SERIAL NOT NULL,
  "doc_Id" int8,
  "note" varchar,
  "note_date" timestamp(6),
  "pinned" bit(1),
  "inputted_by" varchar(20),
  "updated_by" varchar(20),
  CONSTRAINT "doc_note_pkey" PRIMARY KEY ("note_id")
);
comment on table hrdocs.doc_note is 'Table for record note for document';

/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE "stafflog" DISABLE KEYS */;
/*!40000 ALTER TABLE "stafflog" ENABLE KEYS */;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-22 12:08:12
