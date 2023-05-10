igint NOT NULL DEFAULT nextval('sales."TrainingTopicsQuestionsOptions_UID_seq"'::regclass),
	    "SystemDate" timestamp without time zone DEFAULT now(),
	    "QuestionID" bigint,
	    "Options" text COLLATE pg_catalog."default",
	    "OptionNumber" bigint,
	    CONSTRAINT "TrainingTopicsQuestionsOptions_pkey" PRIMARY KEY ("UID")
	)
	
	TABLESPACE pg_default;
2022-12-21 10:40:26.321 PKT [8000] ERROR:  relation "TrainingTopicsQuestionsResults_UID_seq" already exists
2022-12-21 10:40:26.321 PKT [8000] STATEMENT:  
	
	CREATE SEQUENCE sales."TrainingTopicsQuestionsResults_UID_seq"
	    INCREMENT 1
	    START 1
	    MINVALUE 1
	    MAXVALUE 9223372036854775807
	    CACHE 1;
2022-12-21 10:40:26.322 PKT [8000] ERROR:  relation "TrainingTopicsQuestionsResults" already exists
2022-12-21 10:40:26.322 PKT [8000] STATEMENT:  
	
	
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
2022-12-21 10:40:26.322 PKT [8000] ERROR:  relation "TopicParticipants_UID_seq" already exists
2022-12-21 10:40:26.322 PKT [8000] STATEMENT:  
	
	CREATE SEQUENCE sales."TopicParticipants_UID_seq"
	    INCREMENT 1
	    START 1
	    MINVALUE 1
	    MAXVALUE 9223372036854775807
	    CACHE 1;
2022-12-21 10:40:26.323 PKT [8000] ERROR:  relation "TopicParticipants" already exists
2022-12-21 10:40:26.323 PKT [8000] STATEMENT:  
	
	CREATE TABLE s