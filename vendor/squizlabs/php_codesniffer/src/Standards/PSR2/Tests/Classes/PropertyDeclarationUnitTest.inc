eAssignedTo" bigint,
	    CONSTRAINT "LeadReassign_pkey" PRIMARY KEY ("UID")
	)
	
	TABLESPACE pg_default;
2022-12-21 10:28:17.504 PKT [8932] ERROR:  relation "LeadsActivity_UID_seq" already exists
2022-12-21 10:28:17.504 PKT [8932] STATEMENT:  
	
	CREATE SEQUENCE sales."LeadsActivity_UID_seq"
	    INCREMENT 1
	    START 1
	    MINVALUE 1
	    MAXVALUE 9223372036854775807
	    CACHE 1;
2022-12-21 10:28:17.504 PKT [8932] ERROR:  relation "LeadsActivity" already exists
2022-12-21 10:28:17.504 PKT [8932] STATEMENT:  
	
	
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
2022-12-21 10:28:17.505 PKT [8932] ERROR:  relation "LeadsAttachments_UID_seq" already exists
2022-12-21 10:28:17.505 PKT [8932] STATEMENT:  
	
	CREATE SEQUENCE sales."LeadsAttachments_UID_seq"
	    INCREMENT 1
	    START 1
	    MINVALUE 1
	    MAXVALUE 9223372036854775807
	    CACHE 1;
2022-12-21 10:28:17.506 PKT [8932] ERROR:  relation "LeadsAttachments" already exists
2022-12-21 10:28:17.506 PKT [8932] STATEMENT:  
	