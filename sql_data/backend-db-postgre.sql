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

DROP TABLE IF EXISTS "app_sessions";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "app_sessions" (
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

DROP TABLE IF EXISTS "staffgroup";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "staffgroup" (
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

INSERT INTO "staffgroup" ("sdg_id", "sdg_name", "sdg_desc", "sdg_status") VALUES
(5, 'admin', '', 1);


--
-- Table structure for table "module"
--

DROP TABLE IF EXISTS "module";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "module" (
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
INSERT INTO "module" VALUES (2,'staff','','staff',1);
/*!40000 ALTER TABLE "module" ENABLE KEYS */;


--
-- Table structure for table "moduleaccess"
--

DROP TABLE IF EXISTS "moduleaccess";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "moduleaccess" (
  "mda_id" SERIAL NOT NULL,
  "mda_staffgroup" int NOT NULL,
  "mda_module" int NOT NULL,
  "mda_create" smallint DEFAULT 0,
  "mda_read" smallint DEFAULT 0,
  "mda_update" smallint DEFAULT 0,
  "mda_delete" smallint DEFAULT 0,
  PRIMARY KEY ("mda_id","mda_staffgroup","mda_module"),
  CONSTRAINT "fk_staffgroup_has_module_module1" FOREIGN KEY ("mda_module") REFERENCES "module" ("mdl_id") ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT "fk_staffgroup_has_module_staffgroup1" FOREIGN KEY ("mda_staffgroup") REFERENCES "staffgroup" ("sdg_id") ON DELETE NO ACTION ON UPDATE NO ACTION
);
/*!40101 SET character_set_client = @saved_cs_client */;

CREATE INDEX "fk_staffgroup_has_module_module1_idx" ON "moduleaccess" ("mda_module");
CREATE INDEX "fk_staffgroup_has_module_staffgroup1_idx" ON "moduleaccess" ("mda_staffgroup");

--
-- Dumping data for table "moduleaccess"
--

/*!40000 ALTER TABLE "moduleaccess" DISABLE KEYS */;
INSERT INTO "moduleaccess" VALUES (69,5,2,1,1,1,1);
/*!40000 ALTER TABLE "moduleaccess" ENABLE KEYS */;


--
-- Table structure for table "modulemenu"
--

DROP TABLE IF EXISTS "modulemenu";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "modulemenu" (
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
INSERT INTO "modulemenu" VALUES (22,'Pengguna','staff','5',NULL,'System','ik ik-users',20,1);
/*!40000 ALTER TABLE "modulemenu" ENABLE KEYS */;


--
-- Table structure for table "staff"
--

DROP TABLE IF EXISTS "staff";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "staff" (
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
INSERT INTO "staff" VALUES (3,'admin','admin','','$2y$10$rLa7p9zhJJxFFctE/J9qRO83rFtnGOF6wweBNezMywXKh2kvCcEbG','2020-07-22 05:01:12',1,'2020-07-22 04:57:36','2020-07-22 04:57:36');
/*!40000 ALTER TABLE "staff" ENABLE KEYS */;





--
-- Table structure for table "staffgroupaccess"
--

DROP TABLE IF EXISTS "staffgroupaccess";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "staffgroupaccess" (
  "sga_staffgroup" int NOT NULL,
  "sga_staff" int NOT NULL,
  PRIMARY KEY ("sga_staffgroup","sga_staff"),
  CONSTRAINT "fk_staffgroup_has_staff_staff1" FOREIGN KEY ("sga_staff") REFERENCES "staff" ("stf_id") ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT "fk_staffgroup_has_staff_staffgroup1" FOREIGN KEY ("sga_staffgroup") REFERENCES "staffgroup" ("sdg_id") ON DELETE NO ACTION ON UPDATE NO ACTION
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table "staffgroupaccess"
--





--
-- Table structure for table "stafflog"
--

DROP TABLE IF EXISTS "stafflog";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "stafflog" (
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


/*!40000 ALTER TABLE "stafflog" DISABLE KEYS */;
/*!40000 ALTER TABLE "stafflog" ENABLE KEYS */;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-22 12:08:12
