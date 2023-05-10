CREATE SCHEMA marketing AUTHORIZATION umrahfuras;


CREATE SEQUENCE IF NOT EXISTS marketing."EmailsLists_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE marketing."EmailsLists_UID_seq" OWNER TO umrahfuras;

CREATE TABLE IF NOT EXISTS marketing."EmailsLists"
(
    "UID" bigint NOT NULL DEFAULT nextval
(
    'marketing."EmailsLists_UID_seq"'::regclass
),
    "SystemDate" timestamp without time zone DEFAULT now
(
),
    "CreatedAt" timestamp
                           without time zone,
    "FullName" character varying
(
    1000
) COLLATE pg_catalog."default",
    "DomainID" bigint,
    "Archive" smallint,
    CONSTRAINT "EmailsLists_pkey" PRIMARY KEY
(
    "UID"
)
    )
                           WITH ( OIDS = FALSE )
    TABLESPACE pg_default;

ALTER TABLE IF EXISTS marketing."EmailsLists" OWNER to umrahfuras;

ALTER TABLE marketing."EmailsLists"
ALTER
"Archive" TYPE smallint,
ALTER
"Archive" SET DEFAULT '0',
ALTER
"Archive" DROP
NOT NULL;
COMMENT
ON COLUMN marketing."EmailsLists"."Archive" IS '';
COMMENT
ON TABLE marketing."EmailsLists" IS '';



CREATE SEQUENCE IF NOT EXISTS marketing."EmailIDs_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE marketing."EmailIDs_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE IF NOT EXISTS marketing."EmailIDs"
(
    "UID" bigint NOT NULL DEFAULT nextval
(
    'marketing."EmailIDs_UID_seq"'::regclass
),
    "SystemDate" timestamp without time zone DEFAULT now
(
),
    "EmailsListID" bigint,
    "FullName" character varying
(
    500
) COLLATE pg_catalog."default",
    "Email" character varying
(
    200
) COLLATE pg_catalog."default",
    "Status" character varying
(
    50
) COLLATE pg_catalog."default",
    "DomainID" bigint,
    CONSTRAINT "EmailIDs_pkey" PRIMARY KEY
(
    "UID"
)
    )
                           WITH (OIDS = FALSE)
    TABLESPACE pg_default;

ALTER TABLE IF EXISTS marketing."EmailIDs"
    OWNER to umrahfuras;



CREATE SEQUENCE IF NOT EXISTS marketing."Campaigns_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

CREATE TABLE IF NOT EXISTS marketing."Campaigns"
(
    "UID" bigint NOT NULL DEFAULT nextval
(
    'marketing."Campaigns_UID_seq"'::regclass
),
    "SystemDate" timestamp without time zone DEFAULT now
(
),
    "Title" character varying
(
    255
) COLLATE pg_catalog."default",
    "SenderFirstName" character varying
(
    50
) COLLATE pg_catalog."default",
    "SenderLastName" character varying
(
    50
) COLLATE pg_catalog."default",
    "SenderEmail" character varying
(
    150
) COLLATE pg_catalog."default",
    "EmailSubject" character varying
(
    150
) COLLATE pg_catalog."default",
    "EmailTemplate" character varying
(
    50
) COLLATE pg_catalog."default",
    "EmailBody" text COLLATE pg_catalog."default",
    "ExecDate" date,
    "Status" character varying COLLATE pg_catalog."default",
    "DomainID" bigint,
    "Archive" smallint DEFAULT 0,
    CONSTRAINT "Campaigns_pkey" PRIMARY KEY
(
    "UID"
)
    )
                           WITH (
                               OIDS = FALSE
                               )
    TABLESPACE pg_default;

ALTER TABLE IF EXISTS marketing."Campaigns"
    OWNER to umrahfuras;



CREATE SEQUENCE IF NOT EXISTS marketing."InfoLog_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

CREATE TABLE IF NOT EXISTS marketing."InfoLog"
(
    "UID" bigint NOT NULL DEFAULT nextval
(
    'marketing."InfoLog_UID_seq"'::regclass
),
    "LogDateTime" timestamp without time zone DEFAULT now
(
),
    "LoggedEmailID" bigint,
    "LoggedCampaignID" bigint,
    CONSTRAINT "InfoLog_pkey" PRIMARY KEY
(
    "UID"
)
    )
                            WITH (
                                OIDS = FALSE
                                )
    TABLESPACE pg_default;

ALTER TABLE IF EXISTS marketing."InfoLog"
    OWNER to umrahfuras;



CREATE SEQUENCE IF NOT EXISTS marketing."NewsletterCrone_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;


CREATE TABLE IF NOT EXISTS marketing."NewsletterCrone"
(
    "UID" bigint NOT NULL DEFAULT nextval
(
    'marketing."NewsletterCrone_UID_seq"'::regclass
),
    "SystemDate" timestamp without time zone DEFAULT now
(
),
    "CampaignID" bigint,
    "ListID" bigint,
    "ExecDate" date,
    "DomainID" bigint,
    CONSTRAINT "NewsletterCrone_pkey" PRIMARY KEY
(
    "UID"
)
    )
                           WITH (
                               OIDS = FALSE
                               )
    TABLESPACE pg_default;

ALTER TABLE IF EXISTS marketing."NewsletterCrone"
    OWNER to umrahfuras;