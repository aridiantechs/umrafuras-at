CREATE SCHEMA hr
	AUTHORIZATION umrahfuras;

CREATE SEQUENCE hr."leaves_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE hr."leaves_UID_seq" OWNER TO umrahfuras;

CREATE TABLE hr."leaves"
(
    "UID" bigint NOT NULL DEFAULT nextval('hr."leaves_UID_seq"'::regclass),
    "SystemDate" timestamp with time zone DEFAULT now(),
    "Station" character varying(50) NOT NULL,
    "EmployeeID" integer NOT NULL DEFAULT 0,
    "LeaveCategory" character varying(100) DEFAULT NULL,
    "From" timestamp without time zone NOT NULL,
    "To" timestamp without time zone NOT NULL,
    "Reason" text DEFAULT NULL,
    "BackupPerson" integer NOT NULL DEFAULT 0,
    "ApprovalAuthority" integer NOT NULL DEFAULT 0,
    "Status" character varying(100) DEFAULT NULL,
    "SubmittedBy" integer NOT NULL DEFAULT 0,
    CONSTRAINT leaves_pkey PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE hr."leaves"
    OWNER to umrahfuras;

CREATE SEQUENCE hr."att_punches_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE hr."att_punches_UID_seq" OWNER TO umrahfuras;

CREATE TABLE hr."att_punches"
(
    "UID" bigint NOT NULL DEFAULT nextval('hr."att_punches_UID_seq"'::regclass),
    "SystemDate" timestamp with time zone DEFAULT now(),
    "EmployeeID" integer NOT NULL DEFAULT 0,
    "PunchTime" timestamp without time zone NOT NULL,
    "WorkCode" integer NOT NULL DEFAULT 0,
    "WorkState" integer NOT NULL DEFAULT 0,
    "VerifyCode" character varying(100) DEFAULT NULL,
    "TerminalID" integer NOT NULL DEFAULT 0,
    "PunchType" character varying(100) DEFAULT NULL,
    "Operator" character varying(100) DEFAULT NULL,
    "OperatorReason" character varying(100) DEFAULT NULL,
    "OperatorTime" timestamp without time zone NOT NULL,
    "IsSelect" integer NOT NULL DEFAULT 0,
    "MiddleWareID" bigint NOT NULL DEFAULT 0,
    "AttendanceEvent" character varying(100) DEFAULT NULL,
    "LoginCombination" integer NOT NULL DEFAULT 0,
    "Status" integer NOT NULL DEFAULT 0,
    "Annotation" character varying(255) DEFAULT NULL,
    "Processed" integer NOT NULL DEFAULT 0,
    CONSTRAINT att_punches_pkey PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE hr."att_punches"
    OWNER to umrahfuras;

ALTER TABLE hr."att_punches"
ALTER "OperatorTime" TYPE timestamp,
ALTER "OperatorTime" DROP DEFAULT,
ALTER "OperatorTime" DROP NOT NULL;
COMMENT ON COLUMN hr."att_punches"."OperatorTime" IS '';
COMMENT ON TABLE hr."att_punches" IS '';

CREATE SEQUENCE IF NOT EXISTS hr."roaster_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE hr."roaster_UID_seq"
    OWNER TO umrahfuras;


CREATE TABLE IF NOT EXISTS hr.roaster
(
    "UID" bigint NOT NULL DEFAULT nextval('hr."roaster_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "RoasterID" bigint,
    "EmployeeID" bigint,
    CONSTRAINT roaster_pkey PRIMARY KEY ("UID")
    )

    TABLESPACE pg_default;

ALTER TABLE IF EXISTS hr.roaster
    OWNER to umrahfuras;


ALTER TABLE hr."roaster"
DROP "RoasterID",
ADD "RoasterDate" timestamp NULL;
COMMENT ON TABLE hr."roaster" IS '';


ALTER TABLE hr."leaves"
ALTER "SystemDate" TYPE timestamp,
ALTER "SystemDate" SET DEFAULT now(),
ALTER "SystemDate" DROP NOT NULL;
COMMENT ON COLUMN hr."leaves"."SystemDate" IS '';
COMMENT ON TABLE hr."leaves" IS '';

