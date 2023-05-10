ALTER TABLE pilgrim."mofa"
ADD "BRN" bigint NULL DEFAULT '0';
COMMENT ON TABLE pilgrim."mofa" IS '';

ALTER TABLE main."Groups"
ADD "GroupType" text NULL;
COMMENT ON TABLE main."Groups" IS '';

ALTER TABLE pilgrim."master"
    ADD "PilgrimType" text NOT NULL DEFAULT 'B2B';
COMMENT ON TABLE pilgrim."master" IS '';

ALTER TABLE "main"."GroupHotel"
    ADD "BRNType" character varying NULL;
COMMENT ON TABLE "main"."GroupHotel" IS '';

ALTER TABLE "main"."Groups"
    ADD "RefundAmount" bigint NOT NULL DEFAULT '0',
ADD "TotalAmount" double precision NOT NULL DEFAULT '0';
COMMENT ON TABLE "main"."Groups" IS '';




  CREATE SEQUENCE websites."NewsLetter_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE websites."NewsLetter_UID_seq"
    OWNER TO umrahfuras;


CREATE TABLE websites."NewsLetter"
(
    "UID" bigint NOT NULL DEFAULT nextval('websites."NewsLetter_UID_seq"'::regclass),
    "SystemDate" timestamp with time zone DEFAULT now(),
    "Name" text COLLATE pg_catalog."default",
    "Email" character varying(250) COLLATE pg_catalog."default",
    "ContactNumber" character varying(250) COLLATE pg_catalog."default",
    CONSTRAINT "NewsLetter_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE websites."NewsLetter"
    OWNER to umrahfuras;


ALTER TABLE "main"."GroupTransport"
    ADD "BRNType" character varying NULL;
COMMENT ON TABLE "main"."GroupTransport" IS '';



ALTER TABLE packages."HotelImage"
ADD "CoverImage" bigint NOT NULL DEFAULT '0';
COMMENT ON TABLE packages."HotelImage" IS '';

CREATE SCHEMA api AUTHORIZATION umrahfuras;

CREATE SEQUENCE api."list_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE api."list_UID_seq" OWNER TO umrahfuras;

CREATE TABLE api.list
(
    "UID" bigint NOT NULL DEFAULT nextval('api."list_UID_seq"'::regclass),
    "SystemDate" timestamp with time zone DEFAULT now(),
    "Segment" character varying(250) COLLATE pg_catalog."default",
    "IpAddress" character varying(250) COLLATE pg_catalog."default",
    "Request" text COLLATE pg_catalog."default",
    "Response" text COLLATE pg_catalog."default",
    CONSTRAINT list_pkey PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE api.list
    OWNER to umrahfuras;

ALTER TABLE "pilgrim"."auth"
ADD "VerifyToken" text NULL;
COMMENT ON TABLE "pilgrim"."auth" IS '';

ALTER TABLE "BRN"."PromoCode"
ADD "AgentUID" bigint NOT NULL DEFAULT '0',
ADD "HotelUID" bigint NOT NULL DEFAULT '0',
ADD "CareOf" character varying(255) NULL,
ADD "Status" character varying(100) NOT NULL DEFAULT 'Block';
COMMENT ON TABLE "BRN"."PromoCode" IS '';

ALTER TABLE "pilgrim"."travel"
ADD "Flag" character varying(100) NOT NULL DEFAULT 'Arrival';
COMMENT ON TABLE "pilgrim"."travel" IS '';

ALTER TABLE "websites"."Domains"
ADD "MobileDomainID" bigint NULL;
COMMENT ON TABLE "websites"."Domains" IS '';


CREATE SEQUENCE main."UmrahCalender_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE main."UmrahCalender_UID_seq" OWNER TO umrahfuras;

CREATE TABLE main."UmrahCalender"
(
    "UID" bigint NOT NULL DEFAULT nextval('main."UmrahCalender_UID_seq"'::regclass),
    "SystemDate" timestamp with time zone DEFAULT now(),
    "Year" character varying(100) COLLATE pg_catalog."default",
    "Title" character varying(250) COLLATE pg_catalog."default",
    "StartDate" date             DEFAULT NULL,
    "EndDate" date             DEFAULT NULL,
    CONSTRAINT UmrahCalender_pkey PRIMARY KEY ("UID")
)
    TABLESPACE pg_default;

ALTER TABLE main."UmrahCalender"
    OWNER to umrahfuras;

ALTER TABLE packages."Packages"
ADD "GroupCode" text NULL;
COMMENT ON TABLE packages."Packages" IS '';

CREATE SEQUENCE IF NOT EXISTS websites."CronActivities_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE websites."CronActivities_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE IF NOT EXISTS websites."CronActivities"
(
    "UID" bigint NOT NULL DEFAULT nextval('websites."CronActivities_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    CONSTRAINT "CronActivities_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS websites."CronActivities"
    OWNER to umrahfuras;


ALTER TABLE websites."CronActivities"
ADD "FunctionName" text NULL,
ADD "Flag" integer NOT NULL DEFAULT '0';
COMMENT ON TABLE websites."CronActivities" IS '';

ALTER TABLE websites."CronActivities"
ADD "LoadTime" time NULL DEFAULT '00:00:00';
COMMENT ON TABLE websites."CronActivities" IS '';


ALTER TABLE pilgrim."master"
ALTER "AgentUID" TYPE bigint,
ALTER "AgentUID" SET DEFAULT '0',
ALTER "AgentUID" SET NOT NULL;
COMMENT ON COLUMN pilgrim."master"."AgentUID" IS '';
COMMENT ON TABLE pilgrim."master" IS '';


ALTER TABLE main."Groups"
ALTER "Visa" TYPE character varying,
ALTER "Visa" DROP DEFAULT,
ALTER "Visa" DROP NOT NULL;
COMMENT ON COLUMN main."Groups"."Visa" IS '';
COMMENT ON TABLE main."Groups" IS '';


ALTER TABLE "BRN"."brn"
ADD "Agent" bigint NULL,
ADD "Country" bigint NULL;
COMMENT ON TABLE "BRN"."brn" IS '';


ALTER TABLE "BRN"."brn"
ALTER "Country" TYPE character varying,
ALTER "Country" DROP DEFAULT,
ALTER "Country" DROP NOT NULL;
COMMENT ON COLUMN "BRN"."brn"."Country" IS '';
COMMENT ON TABLE "BRN"."brn" IS '';

ALTER TABLE "api"."list"
ADD "Type" character varying(50) NOT NULL DEFAULT 'website';
COMMENT ON TABLE "api"."list" IS '';

ALTER TABLE "main"."Users"
ADD "VerifyToken" text NULL;
COMMENT ON TABLE "main"."Users" IS '';

ALTER TABLE "main"."Agents"
ADD "VerifyToken" text NULL;
COMMENT ON TABLE "main"."Agents" IS '';

ALTER TABLE "sale_agent"."Agents"
ADD "VerifyToken" text NULL;
COMMENT ON TABLE "sale_agent"."Agents" IS '';

ALTER TABLE packages."HotelsRate"
ADD "HotelCategory" bigint NULL;
COMMENT ON TABLE packages."HotelsRate" IS '';


CREATE SEQUENCE IF NOT EXISTS websites."CustomerSupport_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE websites."CustomerSupport_UID_seq"
    OWNER TO umrahfuras;


CREATE TABLE IF NOT EXISTS websites."CustomerSupport"
(
    "UID" bigint NOT NULL DEFAULT nextval('websites."CustomerSupport_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "Name" text COLLATE pg_catalog."default",
    "ContactNumber" character varying(160) COLLATE pg_catalog."default",
    "Email" character varying(160) COLLATE pg_catalog."default",
    "Product" text COLLATE pg_catalog."default",
    "BookingReference" character varying(160) COLLATE pg_catalog."default",
    "TravelDate" date,
    "Subject" text COLLATE pg_catalog."default",
    "Query" text COLLATE pg_catalog."default",
    "DomainID" bigint,
    CONSTRAINT "CustomerSupport_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS websites."CustomerSupport"
    OWNER to umrahfuras;


ALTER TABLE websites."CustomerSupport"
ADD "Status" text NOT NULL,
ADD "Featured" smallint NOT NULL DEFAULT '0';
COMMENT ON TABLE websites."CustomerSupport" IS '';

ALTER TABLE websites."CustomerSupport"
ALTER "Status" TYPE text,
ALTER "Status" SET DEFAULT 'Pending',
ALTER "Status" SET NOT NULL;
COMMENT ON COLUMN websites."CustomerSupport"."Status" IS '';
COMMENT ON TABLE websites."CustomerSupport" IS '';


ALTER TABLE main."Users"
ADD "ParentID" bigint NULL;
COMMENT ON TABLE main."Users" IS '';


ALTER TABLE main."Operators"
ADD "Color" character varying(150) NULL;
COMMENT ON TABLE main."Operators" IS '';

ALTER TABLE voucher."Master"
ADD "UmrahOperator" bigint NULL;
COMMENT ON TABLE voucher."Master" IS '';

ALTER TABLE main."AccessLevel"
ADD "AccountType" character varying(150) NULL;
COMMENT ON TABLE main."AccessLevel" IS '';

ALTER TABLE temp."mofa_file"
ADD "FileID" integer NOT NULL DEFAULT '0';
COMMENT ON TABLE temp."mofa_file" IS '';

ALTER TABLE pilgrim."mofa"
ADD "FileID" integer NOT NULL DEFAULT '0';
COMMENT ON TABLE pilgrim."mofa" IS '';

ALTER TABLE pilgrim."mofa"
ADD "Operator" character varying(255) NULL;
COMMENT ON TABLE pilgrim."mofa" IS '';

ALTER TABLE voucher."Master"
ADD "Visa" character varying(50) NULL,
ADD "VisaRate" bigint NOT NULL DEFAULT '0';
COMMENT ON TABLE voucher."Master" IS '';

CREATE SEQUENCE IF NOT EXISTS voucher."VisaRate_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE voucher."VisaRate_UID_seq"
    OWNER TO umrahfuras;


CREATE TABLE IF NOT EXISTS voucher."VisaRate"
(
    "UID" bigint NOT NULL DEFAULT nextval('voucher."VisaRate_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "VoucherID" bigint,
    "Option" bigint,
    "DomainID" bigint,
    "Rate" character varying(255) COLLATE pg_catalog."default",
    CONSTRAINT "VisaRate_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS voucher."VisaRate"
    OWNER to umrahfuras;

ALTER TABLE  pilgrim."travel"
ADD "ExitDate" date NULL,
ADD "ExitTime" time NULL,
ADD "ExitPort" text NULL,
ADD "ExitTransportMode" text NULL,
ADD "ExitCareer" text NULL,
ADD "ExitFlightNo" text NULL,
ADD "ActualStayingDuration" bigint NOT NULL DEFAULT '0';
COMMENT ON TABLE  pilgrim."travel" IS '';