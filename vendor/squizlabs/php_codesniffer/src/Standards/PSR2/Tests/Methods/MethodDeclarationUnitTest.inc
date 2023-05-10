:26.333 PKT [8000] ERROR:  relation "LeadReassign_UID_seq" already exists
2022-12-21 10:40:26.333 PKT [8000] STATEMENT:  
	
	
	CREATE SEQUENCE sales."LeadReassign_UID_seq"
	    INCREMENT 1
	    START 1
	    MINVALUE 1
	    MAXVALUE 9223372036854775807
	    CACHE 1;
2022-12-21 10:40:26.334 PKT [8000] ERROR:  relation "LeadReassign" already exists
2022-12-21 10:40:26.334 PKT [8000] STATEMENT:  
	
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
2022-12-21 10:40:26.334 PKT [8000] ERROR:  relation "LeadsActivity_UID_seq" already exists
2022-12-21 10:40:26.334 PKT [8000] STATEMENT:  
	
	CREATE SEQUENCE sales."LeadsActivity_UID_seq"
	    INCREMENT 1
	    START 1
	    MINVALUE 1
	    MAXVALUE 9223372036854775807
	    CACHE 1;
2022-12-21 10:40:26.335 PKT [8000] ERROR:  relation "LeadsActivity" already exists
2022-12-21 10:40:26.335 PKT [8000] STATEMENT:  
	
	
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
2022-12-21 10:40:26.335 PKT [8000] ERROR:  relation "LeadsAttachments_UID_seq" already exists
2022-12-21 10:40:26.335 PKT [8000] STATEMENT:  
	
	CREATE SEQUENCE sales."LeadsAttachments_UID_seq"
	    INCREMENT 1
	    START 1
	    MINVALUE 1
	    MAXVALUE 9223372036854775807
	    CACHE 1;
2022-12-21 10:40:26.336 PKT [8000] ERROR:  relation "LeadsAttachments" already exists
2022-12-21 10:40:26.336 PKT [8000] STATEMENT:  
	
	    CREATE TABLE sales."LeadsAttachments"
	(
	    "UID" bigint NOT NULL DEFAULT nextval('sales."LeadsAttach