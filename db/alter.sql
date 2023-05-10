ALTER TABLE main."LookupsOptions"
ADD "OtherDescription" bigint NULL;
COMMENT ON TABLE main."LookupsOptions" IS '';

CREATE SEQUENCE IF NOT EXISTS main."GroupVisaRate_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE main."GroupVisaRate_UID_seq"
    OWNER TO umrahfuras;


CREATE TABLE IF NOT EXISTS main."GroupVisaRate"
(
    "UID" bigint NOT NULL DEFAULT nextval('main."GroupVisaRate_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "GroupUID" bigint,
    "Option" bigint,
    "DomainID" bigint,
    "Rate" character varying(255) COLLATE pg_catalog."default",
    CONSTRAINT "GroupVisaRate_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS main."GroupVisaRate"
    OWNER to umrahfuras;



ALTER TABLE "sales"."Leads"
ALTER "ProjectID" TYPE character varying(15),
ALTER "ProjectID" DROP DEFAULT,
ALTER "ProjectID" DROP NOT NULL;
ALTER TABLE "sales"."Leads" RENAME "ProjectID" TO "ProductID";
COMMENT ON COLUMN "sales"."Leads"."ProductID" IS '';
COMMENT ON TABLE "sales"."Leads" IS '';

ALTER TABLE "sales"."Leads"
ALTER "Agent" TYPE bigint,
ALTER "Agent" DROP DEFAULT,
ALTER "Agent" DROP NOT NULL;
ALTER TABLE "sales"."Leads" RENAME "Agent" TO "UserID";
COMMENT ON COLUMN "sales"."Leads"."UserID" IS '';
COMMENT ON TABLE "sales"."Leads" IS '';


ALTER TABLE sales."Leads"
ADD "LeadCategory" character varying(10) NULL;
COMMENT ON TABLE sales."Leads" IS '';


ALTER TABLE sales."Leads"
ADD "Agent" bigint NULL;
COMMENT ON TABLE sales."Leads" IS '';

ALTER TABLE main."UserNotifications"
ADD "DomainID" bigint NULL;
COMMENT ON TABLE main."UserNotifications" IS '';


CREATE SEQUENCE sales."InitialTraining_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE sales."InitialTraining_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE sales."InitialTraining"
(
    "UID" bigint NOT NULL DEFAULT nextval('sales."InitialTraining_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "StaffID" bigint,
    "OptionUID" bigint,
    "Performed" bigint,
    "Remarks" bigint,
    CONSTRAINT "InitialTraining_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS sales."InitialTraining"
    OWNER to umrahfuras;


--     ALTER TABLE sales."InitialTraining"
-- ADD "DomainID" bigint NULL;
-- COMMENT ON TABLE sales."InitialTraining" IS '';


ALTER TABLE sales."InitialTraining"
DROP "DomainID";
COMMENT ON TABLE sales."InitialTraining" IS '';


ALTER TABLE sales."InitialTraining"
ALTER "Remarks" TYPE text,
ALTER "Remarks" DROP DEFAULT,
ALTER "Remarks" DROP NOT NULL;
COMMENT ON COLUMN sales."InitialTraining"."Remarks" IS '';
COMMENT ON TABLE sales."InitialTraining" IS '';


ALTER TABLE sales."Leads"
DROP "Agent";
COMMENT ON TABLE sales."Leads" IS '';


ALTER TABLE sales."Leads"
ALTER "UserID" TYPE bigint,
ALTER "UserID" SET DEFAULT '0',
ALTER "UserID" DROP NOT NULL;
COMMENT ON COLUMN sales."Leads"."UserID" IS '';
COMMENT ON TABLE sales."Leads" IS ''; 





ALTER TABLE marketing."EmailsLists"
ALTER "Archive" TYPE smallint,
ALTER "Archive" SET DEFAULT '0',
ALTER "Archive" DROP NOT NULL;
COMMENT ON COLUMN marketing."EmailsLists"."Archive" IS '';
COMMENT ON TABLE marketing."EmailsLists" IS '';



ALTER TABLE marketing."EmailIDs"
ALTER "Status" TYPE character varying(50),
ALTER "Status" SET DEFAULT 'active',
ALTER "Status" DROP NOT NULL;
COMMENT ON COLUMN "EmailIDs"."Status" IS '';
COMMENT ON TABLE marketing."EmailIDs" IS '';


ALTER TABLE sales."Leads"
ADD "Country" character varying(50) NULL;
COMMENT ON TABLE sales."Leads" IS '';


ALTER TABLE main."Users"
ADD "LastLoginDetails" timestamp NULL;
COMMENT ON TABLE main."Users" IS '';


ALTER TABLE main."Agents"
ADD "LastLoginDetails" timestamp NULL;
COMMENT ON TABLE main."Agents" IS '';

ALTER TABLE sale_agent."Agents"
ADD "LastLoginDetails" timestamp NULL;
COMMENT ON TABLE sale_agent."Agents" IS '';


ALTER TABLE temp."mofa_file"
ADD "HotelBrn" text NULL,
ADD "TransportBrn" text NULL;
COMMENT ON TABLE temp."mofa_file" IS '';

ALTER TABLE sales."Leads"
ADD "CloseReason" bigint NOT NULL DEFAULT '0';
COMMENT ON TABLE sales."Leads" IS '';


CREATE SEQUENCE sales."LeadsProduct_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1 ;

ALTER SEQUENCE sales."LeadsProduct_UID_seq"
    OWNER TO umrahfuras;


CREATE TABLE IF NOT EXISTS sales."LeadsProduct"
(
    "UID" bigint NOT NULL DEFAULT nextval('sales."LeadsProduct_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "LeadID" bigint,
    "ProductName" character varying COLLATE pg_catalog."default",
    CONSTRAINT "LeadsProduct_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS sales."LeadsProduct"
    OWNER to umrahfuras;


ALTER TABLE "BRN"."brn"
ADD "TransportSectors" integer NOT NULL DEFAULT '0';
COMMENT ON TABLE "BRN"."brn" IS '';



ALTER TABLE "main"."Users"
ADD "MachineCode" character varying(150) NULL;
COMMENT ON TABLE "main"."Users" IS '';


ALTER TABLE voucher."AccommodationDetails"
ALTER "City" TYPE bigint USING "City"::bigint,
ALTER "City" DROP DEFAULT,
ALTER "City" DROP NOT NULL;

ALTER TABLE voucher."AccommodationDetails"
ALTER "Hotel" TYPE bigint USING "Hotel"::bigint,
ALTER "Hotel" DROP DEFAULT,
ALTER "Hotel" DROP NOT NULL;

ALTER TABLE voucher."AccommodationDetails"
ALTER "RoomType" TYPE bigint USING "RoomType"::bigint,
ALTER "RoomType" DROP DEFAULT,
ALTER "RoomType" DROP NOT NULL;


CREATE SCHEMA IF NOT EXISTS hr
    AUTHORIZATION umrahfuras;


ALTER TABLE "hr"."leaves"
ADD "Archive" smallint NOT NULL DEFAULT '0';
COMMENT ON TABLE "hr"."leaves" IS '';    