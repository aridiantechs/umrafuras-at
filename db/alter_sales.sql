CREATE SCHEMA sales
    AUTHORIZATION umrahfuras;

CREATE SEQUENCE sales."Projects_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE sales."Projects_UID_seq"
    OWNER TO umrahfuras;

    CREATE TABLE sales."Projects"
(
    "UID" bigserial NOT NULL,
    "SystemDate" timestamp without time zone DEFAULT now(),
    "ProjectName" text,
    "Target" bigint,
    "Floors" bigint,
    "Rooms" bigint,
    "Location" text,
    "DomainID" bigint,
    "Archive" smallint DEFAULT 0,
    PRIMARY KEY ("UID")
);

ALTER TABLE IF EXISTS sales."Projects"
    OWNER to umrahfuras;

    CREATE SEQUENCE main."UsersProject_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE main."UsersProject_UID_seq"
    OWNER TO umrahfuras;

    CREATE TABLE main."UsersProject"
(
    "UID" bigint NOT NULL DEFAULT nextval('main."UsersProject_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "UserUID" bigint,
    "ProjectID" bigint,
    "ThresholdValue" bigint,
    CONSTRAINT "UsersProject_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS main."UsersProject"
    OWNER to umrahfuras;


CREATE SEQUENCE main."UsersTarget_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE main."UsersTarget_UID_seq"
    OWNER TO umrahfuras;

    CREATE TABLE main."UsersTarget"
(
    "UID" bigint NOT NULL DEFAULT nextval('main."UsersTarget_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "UserUID" bigint,
    "StaffUID" bigint,
    "Month" character varying(150) COLLATE pg_catalog."default",
    "Year" bigint,
    "Target" bigint,
    CONSTRAINT "UsersTarget_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS main."UsersTarget"
    OWNER to umrahfuras;


CREATE SEQUENCE main."UserTimetrack_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE main."UserTimetrack_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE main."UserTimetrack"
(
    "UID" bigint NOT NULL DEFAULT nextval('main."UserTimetrack_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "UserID" bigint,
    "ActivityType" character varying(150) COLLATE pg_catalog."default",
    "ActivityStart" time without time zone,
    "ActivityStop" time without time zone,
    "TrackDate" date,
    CONSTRAINT "UserTimetrack_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS main."UserTimetrack"
    OWNER to umrahfuras;

CREATE SEQUENCE main."UserMeta_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE main."UserMeta_UID_seq"
    OWNER TO umrahfuras;

    CREATE TABLE main."UserMeta"
(
    "UID" bigint NOT NULL DEFAULT nextval('main."UserMeta_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "UserID" bigint,
    "Options" character varying(155) COLLATE pg_catalog."default",
    "Value" character varying(155) COLLATE pg_catalog."default",
    CONSTRAINT "UserMeta_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS main."UserMeta"
    OWNER to umrahfuras;

CREATE SEQUENCE main."UserNotifications_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE main."UserNotifications_UID_seq"
    OWNER TO umrahfuras;


    CREATE TABLE main."UserNotifications"
(
    "UID" bigint NOT NULL DEFAULT nextval('main."UserNotifications_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "UserID" bigint,
    "Description" text COLLATE pg_catalog."default",
    "RefType" character varying(150) COLLATE pg_catalog."default",
    "RefUID" bigint,
    "ReadFlag" smallint DEFAULT 0,
    CONSTRAINT "UserNotifications_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS main."UserNotifications"
    OWNER to umrahfuras;



CREATE SEQUENCE sales."Worksheet_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE sales."Worksheet_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE sales."Worksheet"
(
    "UID" bigint NOT NULL DEFAULT nextval('sales."Worksheet_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "UserID" bigint,
    "CreatedAt" date,
    "DomainID" bigint,
    "Archive" smallint DEFAULT 0,
    CONSTRAINT "Worksheet_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS sales."Worksheet"
    OWNER to umrahfuras;


CREATE SEQUENCE sales."WorksheetMeta_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE sales."WorksheetMeta_UID_seq"
    OWNER TO umrahfuras;

 CREATE TABLE sales."WorksheetMeta"
(
    "UID" bigint NOT NULL DEFAULT nextval('sales."WorksheetMeta_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "WorkSheetUID" bigint,
    "OptionUID" bigint,
    "Performed" bigint,
    "Remarks" text COLLATE pg_catalog."default",
    CONSTRAINT "WorksheetMeta_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS sales."WorksheetMeta"
    OWNER to umrahfuras;



CREATE SEQUENCE sales."TrainingTopic_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE sales."TrainingTopic_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE sales."TrainingTopic"
(
    "UID" bigint NOT NULL DEFAULT nextval('sales."TrainingTopic_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "Heading" text COLLATE pg_catalog."default",
    "Description" text COLLATE pg_catalog."default",
    "LinkedlnLearningResources" character varying(155) COLLATE pg_catalog."default",
    "YoutubeEmbeddedVideo" character varying(155) COLLATE pg_catalog."default",
    "GoogleDriveLink" character varying(155) COLLATE pg_catalog."default",
    "DueDate" date,
    "DomainID" bigint,
    "Archive" smallint DEFAULT 0,
    CONSTRAINT "TrainingTopic_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS sales."TrainingTopic"
    OWNER to umrahfuras;


CREATE SEQUENCE sales."TrainingTopicsQuestions_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE sales."TrainingTopicsQuestions_UID_seq"
    OWNER TO umrahfuras;


CREATE TABLE sales."TrainingTopicsQuestions"
(
    "UID" bigint NOT NULL DEFAULT nextval('sales."TrainingTopicsQuestions_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone,
    "TopicID" bigint,
    "QuestionName" text COLLATE pg_catalog."default",
    "RightAnswer" character varying COLLATE pg_catalog."default",
    "Archive" smallint DEFAULT 0,
    CONSTRAINT "TrainingTopicsQuestions_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS sales."TrainingTopicsQuestions"
    OWNER to umrahfuras;


CREATE SEQUENCE sales."TrainingTopicsQuestionsOptions_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE sales."TrainingTopicsQuestionsOptions_UID_seq"
    OWNER TO umrahfuras;

    CREATE TABLE sales."TrainingTopicsQuestionsOptions"
(
    "UID" bigint NOT NULL DEFAULT nextval('sales."TrainingTopicsQuestionsOptions_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "QuestionID" bigint,
    "Options" text COLLATE pg_catalog."default",
    "OptionNumber" bigint,
    CONSTRAINT "TrainingTopicsQuestionsOptions_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS sales."TrainingTopicsQuestionsOptions"
    OWNER to umrahfuras;

CREATE SEQUENCE sales."TrainingTopicsQuestionsResults_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE sales."TrainingTopicsQuestionsResults_UID_seq"
    OWNER TO umrahfuras;


CREATE TABLE sales."TrainingTopicsQuestionsResults"
(
    "UID" bigint NOT NULL DEFAULT nextval('sales."TrainingTopicsQuestionsResults_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "UserID" bigint,
    "SubmissionDate" date,
    "TopicID" bigint,
    "TotalQuestions" bigint,
    "TotalRightAnswers" bigint,
    "ObtainedPercentage" bigint,
    CONSTRAINT "TrainingTopicsQuestionsResults_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS sales."TrainingTopicsQuestionsResults"
    OWNER to umrahfuras;

CREATE SEQUENCE sales."TopicParticipants_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE sales."TopicParticipants_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE sales."TopicParticipants"
(
    "UID" bigint NOT NULL DEFAULT nextval('sales."TopicParticipants_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "TopicUID" bigint,
    "UserUID" bigint,
    "Value" bigint,
    CONSTRAINT "TopicParticipants_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS sales."TopicParticipants"
    OWNER to umrahfuras;


    CREATE SEQUENCE sales."TopicsAttachments_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE sales."TopicsAttachments_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE sales."TopicsAttachments"
(
    "UID" bigint NOT NULL DEFAULT nextval('sales."TopicsAttachments_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "TopicID" bigint,
    "FileDescription" text COLLATE pg_catalog."default",
    "FileID" bigint,
    CONSTRAINT "TopicsAttachments_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS sales."TopicsAttachments"
    OWNER to umrahfuras;



CREATE SEQUENCE sales."FacebookApiCall_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE sales."FacebookApiCall_UID_seq"
    OWNER TO umrahfuras;

    CREATE TABLE sales."FacebookApiCall"
(
    "UID" bigint NOT NULL DEFAULT nextval('sales."FacebookApiCall_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "APIResponce" text COLLATE pg_catalog."default",
    "DomainID" bigint,
    CONSTRAINT "FacebookApiCall_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS sales."FacebookApiCall"
    OWNER to umrahfuras;


CREATE SEQUENCE sales."FacebookForms_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE sales."FacebookForms_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE sales."FacebookForms"
(
    "UID" bigint NOT NULL DEFAULT nextval('sales."FacebookForms_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "ProjectUID" bigint,
    CONSTRAINT "FacebookForms_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS sales."FacebookForms"
    OWNER to umrahfuras;


CREATE SEQUENCE sales."FacebookLeads_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE sales."FacebookLeads_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE sales."FacebookLeads"
(
    "UID" bigint NOT NULL DEFAULT nextval('sales."FacebookLeads_UID_seq"'::regclass),
    "CreatedDate" timestamp without time zone,
    "FBCreateDate" character varying(150) COLLATE pg_catalog."default",
    "AdID" bigint,
    "FullName" character varying(150) COLLATE pg_catalog."default",
    "PhoneNumber" text COLLATE pg_catalog."default",
    "Email" character varying(150) COLLATE pg_catalog."default",
    "SystemLeadUID" bigint,
    "DomainID" bigint,
    CONSTRAINT "FacebookLeads_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS sales."FacebookLeads"
    OWNER to umrahfuras;

CREATE SEQUENCE sales."Leads_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE sales."Leads_UID_seq"
    OWNER TO umrahfuras;

    CREATE TABLE sales."Leads"
(
    "UID" bigint NOT NULL DEFAULT nextval('sales."Leads_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "CreatedAt" timestamp without time zone,
    "FullName" character varying(155) COLLATE pg_catalog."default",
    "Email" character varying(155) COLLATE pg_catalog."default",
    "ContactNo" character varying(155) COLLATE pg_catalog."default",
    "WhatsAppNo" character varying(155) COLLATE pg_catalog."default",
    "Source" character varying(155) COLLATE pg_catalog."default",
    "SourceDesc" text COLLATE pg_catalog."default",
    "Status" character varying(155) COLLATE pg_catalog."default",
    "Interest" bigint,
    "Agent" bigint,
    "LeadAssignmentDate" timestamp without time zone,
    "Personal" smallint DEFAULT 0,
    "CallBackDateTime" timestamp without time zone,
    "ProjectID" bigint,
    "LeadQuality" bigint,
    "Organic" bigint,
    "FollowUpReason" bigint,
    "DomainID" bigint,
    "Archive" smallint DEFAULT 0,
    CONSTRAINT "Leads_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS sales."Leads"
    OWNER to umrahfuras;


CREATE SEQUENCE sales."LeadsMeta_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE sales."LeadsMeta_UID_seq"
    OWNER TO umrahfuras;

    CREATE TABLE sales."LeadsMeta"
(
    "UID" bigint NOT NULL DEFAULT nextval('sales."LeadsMeta_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "LeadID" bigint,
    "Options" character varying(155) COLLATE pg_catalog."default",
    "Value" character varying(155) COLLATE pg_catalog."default",
    CONSTRAINT "LeadsMeta_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS sales."LeadsMeta"
    OWNER to umrahfuras;


CREATE SEQUENCE sales."LeadReassign_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE sales."LeadReassign_UID_seq"
    OWNER TO umrahfuras;

    CREATE TABLE sales."LeadReassign"
(
    "UID" bigint NOT NULL DEFAULT nextval('sales."LeadReassign_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "LeadsUID" bigint,
    "ReAssignedFrom" bigint,
    "ReAssignedTo" bigint,
    CONSTRAINT "LeadReassign_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS sales."LeadReassign"
    OWNER to umrahfuras;

CREATE SEQUENCE sales."LeadsActivity_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE sales."LeadsActivity_UID_seq"
    OWNER TO umrahfuras;


    CREATE TABLE sales."LeadsActivity"
(
    "UID" bigint NOT NULL DEFAULT nextval('sales."LeadsActivity_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "LeadsUID" bigint,
    "UserUID" bigint,
    "Activity" text COLLATE pg_catalog."default",
    "FileID" bigint,
    "Visit" bigint,
    CONSTRAINT "LeadsActivity_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS sales."LeadsActivity"
    OWNER to umrahfuras;

CREATE SEQUENCE sales."LeadsAttachments_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE sales."LeadsAttachments_UID_seq"
    OWNER TO umrahfuras;

    CREATE TABLE sales."LeadsAttachments"
(
    "UID" bigint NOT NULL DEFAULT nextval('sales."LeadsAttachments_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "LeadID" bigint,
    "FileDescription" text COLLATE pg_catalog."default",
    "FileID" bigint,
    CONSTRAINT "LeadsAttachments_pkey" PRIMARY KEY ("UID")
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS sales."LeadsAttachments"
    OWNER to umrahfuras;


    ALTER TABLE main."UsersProject"
ALTER "ProjectID" TYPE character varying(150),
ALTER "ProjectID" DROP DEFAULT,
ALTER "ProjectID" DROP NOT NULL;
COMMENT ON COLUMN main."UsersProject"."ProjectID" IS '';
COMMENT ON TABLE main."UsersProject" IS '';