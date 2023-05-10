ALTER TABLE packages."Transport"
ALTER "Approval" TYPE character varying,
ALTER "Approval" DROP DEFAULT,
ALTER "Approval" SET NOT NULL,
DROP "Visa",
DROP "Transport",
ADD "Images" text NOT NULL;

ALTER TABLE packages."Transport" RENAME "Approval" TO "LuggageCapacity";
COMMENT ON COLUMN packages."Transport"."LuggageCapacity" IS '';
COMMENT ON TABLE packages."Transport" IS '';


ALTER TABLE packages."Transport"
DROP "Images";
COMMENT ON TABLE packages."Transport" IS '';


ALTER TABLE packages."Transport"
    ADD "PAXDetail" character varying NOT NULL;
COMMENT ON TABLE packages."Transport" IS '';

CREATE SEQUENCE packages."Meta_UID_seq"
    INCREMENT 1    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE packages."Meta_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE packages."Meta"
(
    "UID" bigint NOT NULL DEFAULT nextval('packages."Meta_UID_seq"'::regclass),
    "ReferenceID" character varying COLLATE pg_catalog."default",
    "ReferenceType" character varying COLLATE pg_catalog."default",
    "Option" character varying COLLATE pg_catalog."default",
    "Value" character varying COLLATE pg_catalog."default",
    CONSTRAINT "Meta_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE packages."Meta"
    OWNER to umrahfuras;

CREATE SCHEMA voucher AUTHORIZATION umrahfuras;

CREATE SEQUENCE voucher."Master_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE voucher."Master_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE voucher."Master"
(
    "UID" bigint NOT NULL DEFAULT nextval('voucher."Master_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "AgentUID" bigint,
    "Status" character varying COLLATE pg_catalog."default" DEFAULT 'Draft'::character varying,
    CONSTRAINT "Master_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE voucher."Master"
    OWNER to umrahfuras;

CREATE SEQUENCE voucher."Pilgrim_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE voucher."Pilgrim_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE voucher."Pilgrim"
(
    "UID" bigint NOT NULL DEFAULT nextval('voucher."Pilgrim_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "VoucherUID" bigint,
    "GroupUID" bigint,
    "PilgrimUID" bigint,
    CONSTRAINT "Pilgrim_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE voucher."Pilgrim"
    OWNER to umrahfuras;





ALTER TABLE packages."TransportRate"
ALTER "RouteFrom" TYPE character varying(500),
ALTER "RouteFrom" DROP DEFAULT,
ALTER "RouteFrom" DROP NOT NULL,
DROP "RouteTo";
ALTER TABLE packages."TransportRate" RENAME "RouteFrom" TO "Routes";
COMMENT ON COLUMN packages."TransportRate"."Routes" IS '';
COMMENT ON TABLE packages."TransportRate" IS '';

ALTER TABLE packages."Packages"
ALTER "FoodCharges" TYPE character varying,
ALTER "FoodCharges" DROP DEFAULT,
ALTER "FoodCharges" DROP NOT NULL;
COMMENT ON COLUMN packages."Packages"."FoodCharges" IS '';
COMMENT ON TABLE packages."Packages" IS '';

ALTER TABLE packages."TransportRate"
DROP "Routes",
ADD "RowID" smallint NULL;
COMMENT ON TABLE packages."TransportRate" IS '';

ALTER TABLE packages."TransportRate"
    ADD "Routes" bigint NULL;
COMMENT ON TABLE packages."TransportRate" IS '';


ALTER TABLE packages."Hotels"
    ADD "Status" character varying NULL;
COMMENT ON TABLE packages."Hotels" IS '';

ALTER TABLE packages."Packages"
    ADD "AgentUID" smallint NULL DEFAULT '0';
COMMENT ON TABLE packages."Packages" IS '';

ALTER TABLE packages."Hotels"
DROP "Amenitie";
COMMENT ON TABLE packages."Hotels" IS '';

ALTER TABLE packages."TransportRate"
ALTER "TransportUID" TYPE bigint,
ALTER "TransportUID" DROP DEFAULT,
ALTER "TransportUID" DROP NOT NULL;
ALTER TABLE packages."TransportRate" RENAME "TransportUID" TO "TransportTypeUID";
COMMENT ON COLUMN "TransportRate"."TransportTypeUID" IS '';
COMMENT ON TABLE packages."TransportRate" IS '';

ALTER TABLE packages."ZiyaratsRate"
    ADD "TransportTypeUID" bigint NULL;
COMMENT ON TABLE packages."ZiyaratsRate" IS '';


ALTER TABLE main."Agents"
ALTER "ContactNumber" TYPE character varying,
ALTER "ContactNumber" DROP DEFAULT,
ALTER "ContactNumber" DROP NOT NULL,
DROP "Type",
ADD "FaxNumber" character varying NULL,
ADD "MobileNumber" character varying NULL,
ADD "CityID" bigint NULL,
ADD "CountryID" bigint NULL,
ADD "ContactPersonName" text NULL;
ALTER TABLE main."Agents" RENAME "ContactNumber" TO "PhoneNumber";
COMMENT ON COLUMN "Agents"."PhoneNumber" IS '';
COMMENT ON TABLE main."Agents" IS '';



ALTER TABLE main."Agents"
ALTER "CityID" TYPE character varying,
ALTER "CityID" DROP DEFAULT,
ALTER "CityID" DROP NOT NULL,
ALTER "CountryID" TYPE character varying,
ALTER "CountryID" DROP DEFAULT,
ALTER "CountryID" DROP NOT NULL;
COMMENT ON COLUMN main."Agents"."CityID" IS '';
COMMENT ON COLUMN main."Agents"."CountryID" IS '';
COMMENT ON TABLE main."Agents" IS '';

ALTER TABLE main."Agents"
    ADD "SalesmanName" bigint NOT NULL DEFAULT '0';
COMMENT ON TABLE main."Agents" IS '';



CREATE SEQUENCE main."AgentFiles_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE main."AgentFiles_UID_seq"
    OWNER TO umrahfuras;


CREATE TABLE main."AgentFiles"
(
    "UID" bigint NOT NULL DEFAULT nextval('main."AgentFiles_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "AgentID" character varying COLLATE pg_catalog."default",
    "FileDescription" character varying COLLATE pg_catalog."default",
    "FileID" character varying COLLATE pg_catalog."default",
    CONSTRAINT "AgentImages_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE main."AgentFiles"
    OWNER to umrahfuras;

ALTER TABLE main."Agents"
ALTER "SalesmanName" TYPE bigint,
ALTER "SalesmanName" SET DEFAULT '0',
ALTER "SalesmanName" SET NOT NULL;
ALTER TABLE main."Agents" RENAME "SalesmanName" TO "SalesmanID";
COMMENT ON COLUMN main."Agents"."SalesmanID" IS '';
COMMENT ON TABLE main."Agents" IS '';COMMENT ON TABLE packages."Hotels" IS '';

CREATE SEQUENCE packages."ServiceRate_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE packages."ServiceRate_UID_seq" OWNER TO umrahfuras;

CREATE TABLE packages."ServiceRate"
(
    "UID" bigint NOT NULL DEFAULT nextval('packages."ServiceRate_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "PackageUID" bigint,
    "ServiceUID" bigint,
    "Rate" double precision,
    CONSTRAINT "ServiceRate_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE packages."ServiceRate" OWNER to umrahfuras;


ALTER TABLE pilgrim."master"
ALTER "Country" TYPE character varying,
ALTER "Country" DROP DEFAULT,
ALTER "Country" DROP NOT NULL;
COMMENT ON COLUMN pilgrim."master"."Country" IS '';
COMMENT ON TABLE pilgrim."master" IS '';


-- DROP TABLE pilgrim."passport";


CREATE SEQUENCE pilgrim."passport_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE pilgrim."passport_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE pilgrim.passport
(
    "UID" bigint NOT NULL DEFAULT nextval('pilgrim."passport_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "PilgrimID" bigint,
    "PassportNumber" character varying COLLATE pg_catalog."default",
    "PassportType" character varying COLLATE pg_catalog."default",
    "Nationality" character varying COLLATE pg_catalog."default",
    "DateOfIssue" date,
    "DateOfExpiry" date,
    "TrackingNumber" character varying COLLATE pg_catalog."default",
    "CitizenshipNumber" character varying COLLATE pg_catalog."default",
    "BookletNumber" character varying COLLATE pg_catalog."default",
    CONSTRAINT passport_pkey PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE pilgrim.passport
    OWNER to umrahfuras;


CREATE SEQUENCE temp."elm_file_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE temp."elm_file_UID_seq" OWNER TO umrahfuras;

CREATE TABLE temp.elm_file
(
    "UID" bigint NOT NULL DEFAULT nextval('temp."elm_file_UID_seq"'::regclass),
    "EACode" text COLLATE pg_catalog."default",
    "EAName" text COLLATE pg_catalog."default",
    "GroupCode" text COLLATE pg_catalog."default",
    "GroupDesc" text COLLATE pg_catalog."default",
    "PilgrimID" text COLLATE pg_catalog."default",
    "Name" text COLLATE pg_catalog."default",
    "BirthDate" text COLLATE pg_catalog."default",
    "PassportNo" text COLLATE pg_catalog."default",
    "MOINumber" text COLLATE pg_catalog."default",
    "VisaNo" text COLLATE pg_catalog."default",
    "EntryDate" text COLLATE pg_catalog."default",
    "EntryTime" text COLLATE pg_catalog."default",
    "EntryPort" text COLLATE pg_catalog."default",
    "TransportMode" text COLLATE pg_catalog."default",
    "EntryCarrier" text COLLATE pg_catalog."default",
    "FlightNo" text COLLATE pg_catalog."default",
    "Package" text COLLATE pg_catalog."default",
    CONSTRAINT elm_file_pkey PRIMARY KEY ("UID"),
    CONSTRAINT "Passport" UNIQUE ("PassportNo")
)

    TABLESPACE pg_default;

ALTER TABLE temp.elm_file
    OWNER to umrahfuras;


ALTER TABLE main."Groups"
DROP "Agent",
ADD "AgentID" bigint NULL;
COMMENT ON TABLE main."Groups" IS '';


ALTER TABLE main."Agents"
    ADD "Status" text NULL;
COMMENT ON TABLE main."Agents" IS '';


ALTER TABLE pilgrim."passport"
    ADD "File" text NULL;
COMMENT ON TABLE pilgrim."passport" IS '';


CREATE SEQUENCE pilgrim."travel_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE pilgrim."travel_UID_seq" OWNER TO umrahfuras;

CREATE TABLE pilgrim.travel
(
    "UID" bigint NOT NULL DEFAULT nextval('pilgrim."travel_UID_seq"'::regclass),
    "PilgrimID" bigint,
    "MOFAPilgrimID" bigint,
    "PassportNo" text COLLATE pg_catalog."default",
    "MOINumber" text COLLATE pg_catalog."default",
    "VisaNo" text COLLATE pg_catalog."default",
    "EntryDate" date,
    "EntryTime" time without time zone,
    "EntryPort" text COLLATE pg_catalog."default",
    "TransportMode" text COLLATE pg_catalog."default",
    "EntryCarrier" text COLLATE pg_catalog."default",
    "FlightNo" text COLLATE pg_catalog."default",
    CONSTRAINT travel_pkey PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE pilgrim.travel OWNER to umrahfuras;


ALTER TABLE pilgrim."mofa" DROP CONSTRAINT "mofa_pkey";

ALTER TABLE pilgrim."mofa"
ALTER "MOFANumber" TYPE bigint,
ALTER "MOFANumber" DROP DEFAULT,
ALTER "MOFANumber" DROP NOT NULL;
COMMENT ON COLUMN pilgrim."mofa"."MOFANumber" IS '';
COMMENT ON TABLE pilgrim."mofa" IS '';

CREATE SEQUENCE websites."contents_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE websites."contents_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE websites.contents
(
    "UID" bigint NOT NULL DEFAULT nextval('websites."contents_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "PagePhysical" character varying COLLATE pg_catalog."default",
    "Title" character varying COLLATE pg_catalog."default",
    "Description" text COLLATE pg_catalog."default",
    "SeoTitle" character varying COLLATE pg_catalog."default",
    "SeoMetaKeywords" character varying COLLATE pg_catalog."default",
    "SeoDescription" character varying COLLATE pg_catalog."default",
    "ShowOnFooter" smallint NOT NULL DEFAULT 0,
    "Archive" smallint NOT NULL DEFAULT 0,
    CONSTRAINT contents_pkey PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE websites.contents
    OWNER to umrahfuras;

CREATE SEQUENCE websites."contents_meta_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE websites."contents_meta_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE websites.contents_meta
(
    "UID" bigint NOT NULL DEFAULT nextval('websites."contents_meta_UID_seq"'::regclass),
    "PagePhysical" character varying COLLATE pg_catalog."default",
    "Key" character varying COLLATE pg_catalog."default",
    "Description" text COLLATE pg_catalog."default",
    "OrderID" smallint NOT NULL DEFAULT 0,
    CONSTRAINT contents_meta_pkey PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE websites.contents_meta
    OWNER to umrahfuras;

ALTER TABLE websites."contents"
    ADD "DomainID" bigint NOT NULL DEFAULT '0';
COMMENT ON TABLE websites."contents" IS '';

ALTER TABLE websites."contents_meta"
    ADD "DomainID" bigint NOT NULL DEFAULT '0';
COMMENT ON TABLE websites."contents_meta" IS '';

ALTER TABLE websites."contents"
    ADD "Segment" smallint NOT NULL DEFAULT '0';
COMMENT ON TABLE websites."contents" IS '';

ALTER TABLE websites."contents_meta"
    ADD "Archive" smallint NOT NULL DEFAULT '0';
COMMENT ON TABLE websites."contents_meta" IS '';

CREATE SEQUENCE main."UsersMeta_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE main."UsersMeta_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE main."UsersMeta"
(
    "UID" bigint NOT NULL DEFAULT nextval('main."UsersMeta_UID_seq"'::regclass),
    "UserUID" character varying COLLATE pg_catalog."default",
    "Option" character varying(250) COLLATE pg_catalog."default",
    "Value" text COLLATE pg_catalog."default",
    CONSTRAINT "UsersMeta_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE main."UsersMeta" OWNER to umrahfuras;


ALTER TABLE pilgrim."master"
    ADD "Email" character varying(250) NULL,
ADD "Password" character varying(200) NULL;
COMMENT ON TABLE pilgrim."master" IS '';


ALTER TABLE pilgrim."master"
    ADD "ContactNumber" character varying(200) NULL;
COMMENT ON TABLE pilgrim."master" IS '';


CREATE SEQUENCE pilgrim."attachments_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE pilgrim."attachments_UID_seq"
    OWNER TO umrahfuras;


CREATE TABLE pilgrim.attachments
(
    "UID" bigint NOT NULL DEFAULT nextval('pilgrim."attachments_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "PilgrimID" bigint,
    "FileDescription" text COLLATE pg_catalog."default",
    "FileID" bigint,
    CONSTRAINT attachments_pkey PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE pilgrim.attachments
    OWNER to umrahfuras;




CREATE SEQUENCE pilgrim."auth_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE pilgrim."auth_UID_seq"
    OWNER TO umrahfuras;


CREATE TABLE pilgrim.auth
(
    "UID" bigint NOT NULL DEFAULT nextval('pilgrim."auth_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "DomainID" bigint,
    "PilgrimID" bigint,
    "Email" character varying(255) COLLATE pg_catalog."default",
    "Password" character varying(255) COLLATE pg_catalog."default",
    "LastLoginDateTime" timestamp without time zone,
    "LastLoginIPAddress" character varying(255) COLLATE pg_catalog."default",
    "Status" smallint,
    CONSTRAINT auth_pkey PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE pilgrim.auth
    OWNER to umrahfuras;


ALTER TABLE pilgrim."master"
DROP "LastLoginDateTime",
DROP "Email",
DROP "Password";
COMMENT ON TABLE pilgrim."master" IS '';


ALTER TABLE pilgrim."auth"
ALTER "Status" TYPE smallint,
ALTER "Status" SET DEFAULT '0',
ALTER "Status" DROP NOT NULL;
COMMENT ON COLUMN pilgrim."auth"."Status" IS '';
COMMENT ON TABLE pilgrim."auth" IS '';



CREATE SEQUENCE pilgrim."activities_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE pilgrim."activities_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE pilgrim.activities
(
    "UID" bigint NOT NULL DEFAULT nextval('pilgrim."activities_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "UserID" bigint,
    "PilgrimUID" bigint,
    "Activity" text COLLATE pg_catalog."default",
    "ActivityDescription" text COLLATE pg_catalog."default",
    "IPAddress" character varying COLLATE pg_catalog."default",
    CONSTRAINT activities_pkey PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE pilgrim.activities
    OWNER to umrahfuras;


ALTER TABLE voucher."Master"
DROP "Status",
ADD "VoucherCode" character varying NULL,
ADD "ArrivalDate" date NULL,
ADD "ExpiryDate" date NULL,
ADD "ArrivalType" character varying NULL,
ADD "Reference" text NULL,
ADD "Archive" smallint NULL DEFAULT '0';
COMMENT ON TABLE voucher."Master" IS '';


ALTER TABLE voucher."Pilgrim"
DROP "GroupUID";
COMMENT ON TABLE voucher."Pilgrim" IS '';

CREATE SEQUENCE main."Airlines_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE main."Airlines_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE main."Airlines"
(
    "UID" bigint NOT NULL DEFAULT nextval('main."Airlines_UID_seq"'::regclass),
    "Code" character varying(10) COLLATE pg_catalog."default",
    "FullName" character varying(500) COLLATE pg_catalog."default",
    "CountryISO2" character varying(10) COLLATE pg_catalog."default",
    "Status" character varying(5) COLLATE pg_catalog."default",
    "Archive" smallint DEFAULT 0,
    CONSTRAINT "Airlines_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE main."Airlines"
    OWNER to umrahfuras;


ALTER TABLE pilgrim."master"
    ADD "CityID" character varying(200) NULL,
ADD "ParentID" bigint NULL;
COMMENT ON TABLE pilgrim."master" IS '';


ALTER TABLE pilgrim."master"
ALTER "ParentID" TYPE bigint,
ALTER "ParentID" SET DEFAULT '0',
ALTER "ParentID" DROP NOT NULL;
COMMENT ON COLUMN pilgrim."master"."ParentID" IS '';
COMMENT ON TABLE pilgrim."master" IS '';
    OWNER to umrahfuras;


CREATE SEQUENCE websites."Search_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE websites."Search_UID_seq"
    OWNER TO umrahfuras;


CREATE TABLE websites."Search"
(
    "UID" bigint NOT NULL DEFAULT nextval('websites."Search_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "DomainID" bigint,
    "SearchType" character varying(50) COLLATE pg_catalog."default",
    "SearchRequest" json,
    "SearchResponse" json,
    CONSTRAINT "Search_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE websites."Search"
    OWNER to umrahfuras;


CREATE SCHEMA sale_agent
    AUTHORIZATION umrahfuras;


CREATE SEQUENCE sale_agent."Agents_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE sale_agent."Agents_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE sale_agent."Agents"
(
    "UID" bigint NOT NULL DEFAULT nextval('sale_agent."Agents_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "FullName" text COLLATE pg_catalog."default",
    "PhoneNumber" character varying COLLATE pg_catalog."default",
    "Email" character varying COLLATE pg_catalog."default",
    "Password" character varying COLLATE pg_catalog."default",
    "Country" character varying COLLATE pg_catalog."default",
    "City" character varying COLLATE pg_catalog."default",
    "Address" character varying COLLATE pg_catalog."default",
    "Archive" smallint NOT NULL DEFAULT '0'::smallint,
    CONSTRAINT "Agents_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE sale_agent."Agents"
    OWNER to umrahfuras;

CREATE SEQUENCE sale_agent."Meta_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE sale_agent."Meta_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE sale_agent."Meta"
(
    "UID" bigint NOT NULL DEFAULT nextval('sale_agent."Meta_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "SaleAgentID" bigint,
    "Option" character varying COLLATE pg_catalog."default",
    "Value" character varying COLLATE pg_catalog."default",
    CONSTRAINT "Meta_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE sale_agent."Meta"
    OWNER to umrahfuras;


CREATE SEQUENCE voucher."Flights_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE voucher."Flights_UID_seq"
    OWNER TO umrahfuras;


CREATE TABLE voucher."Flights"
(
    "UID" bigint NOT NULL DEFAULT nextval('voucher."Flights_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "VoucherID" bigint,
    "FlightType" character varying COLLATE pg_catalog."default",
    "AirportID" character varying COLLATE pg_catalog."default",
    "Sector" character varying COLLATE pg_catalog."default",
    "FlightNo" character varying COLLATE pg_catalog."default",
    "PNR" character varying COLLATE pg_catalog."default",
    "DepartureDate" date,
    "DepartureTime" time without time zone,
    "ArrivalDate" date,
    "ArrivalTime" time without time zone,
    CONSTRAINT "Flights_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE voucher."Flights"
    OWNER to umrahfuras;

CREATE SEQUENCE voucher."AccommodationDetails_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE voucher."AccommodationDetails_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE voucher."AccommodationDetails"
(
    "UID" bigint NOT NULL DEFAULT nextval('voucher."AccommodationDetails_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "VoucherID" bigint,
    "Country" character varying COLLATE pg_catalog."default",
    "City" character varying COLLATE pg_catalog."default",
    "Hotel" character varying COLLATE pg_catalog."default",
    "RoomType" character varying COLLATE pg_catalog."default",
    "CheckIn" date,
    "CheckOut" date,
    CONSTRAINT "AccommodationDetails_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE voucher."AccommodationDetails"
    OWNER to umrahfuras;



CREATE SEQUENCE voucher."TransportRate_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE voucher."TransportRate_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE voucher."TransportRate"
(
    "UID" bigint NOT NULL DEFAULT nextval('voucher."TransportRate_UID_seq"'::regclass),
    "VoucherUID" bigint,
    "TransportTypeUID" bigint,
    "Rate" double precision,
    "RowID" smallint,
    "Routes" bigint,
    CONSTRAINT "TransportRate_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE voucher."TransportRate"
    OWNER to umrahfuras;


CREATE SEQUENCE voucher."ZiyaratsRate_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE voucher."ZiyaratsRate_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE voucher."ZiyaratsRate"
(
    "UID" bigint NOT NULL DEFAULT nextval('voucher."ZiyaratsRate_UID_seq"'::regclass),
    "VoucherUID" bigint,
    "ZiyaratsUID" bigint,
    "Rate" double precision,
    "RowID" smallint,
    "TransportTypeUID" bigint,
    CONSTRAINT "ZiyaratsRate_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE voucher."ZiyaratsRate"
    OWNER to umrahfuras;


ALTER TABLE voucher."Master"
    ADD "Country" character varying NULL;
COMMENT ON TABLE voucher."Master" IS '';

ALTER TABLE voucher."Flights"
    ADD "Airline" character varying NULL;
COMMENT ON TABLE voucher."Flights" IS '';


ALTER TABLE voucher."Flights"
ALTER "AirportID" TYPE character varying,
ALTER "AirportID" DROP DEFAULT,
ALTER "AirportID" DROP NOT NULL,
ADD "AirportTo" character varying NULL;
ALTER TABLE voucher."Flights" RENAME "AirportID" TO "AirportFrom";
COMMENT ON COLUMN voucher."Flights"."AirportFrom" IS '';
COMMENT ON TABLE voucher."Flights" IS '';


ALTER TABLE voucher."Flights"
DROP "FlightNo",
ADD "Reference" character varying NULL;
COMMENT ON TABLE voucher."Flights" IS '';


ALTER TABLE voucher."Flights"
ALTER "AirportFrom" TYPE character varying,
ALTER "AirportFrom" DROP DEFAULT,
ALTER "AirportFrom" DROP NOT NULL,
ALTER "AirportTo" TYPE character varying,
ALTER "AirportTo" DROP DEFAULT,
ALTER "AirportTo" DROP NOT NULL;
ALTER TABLE voucher."Flights" RENAME "AirportFrom" TO "SectorFrom";
COMMENT ON COLUMN voucher."Flights"."SectorFrom" IS '';
ALTER TABLE voucher."Flights" RENAME "AirportTo" TO "SectorTo";
COMMENT ON COLUMN voucher."Flights"."SectorTo" IS '';
COMMENT ON TABLE voucher."Flights" IS '';


ALTER TABLE voucher."Flights"
DROP "Sector";
COMMENT ON TABLE voucher."Flights" IS '';


ALTER TABLE voucher."Master"
ALTER "ExpiryDate" TYPE date,
ALTER "ExpiryDate" DROP DEFAULT,
ALTER "ExpiryDate" DROP NOT NULL;
ALTER TABLE voucher."Master" RENAME "ExpiryDate" TO "ReturnDate";
COMMENT ON COLUMN voucher."Master"."ReturnDate" IS '';
COMMENT ON TABLE voucher."Master" IS '';

ALTER TABLE  voucher."Flights"
    ADD "TravelType" character varying NULL;
COMMENT ON TABLE  voucher."Flights" IS '';



ALTER TABLE packages."Transport"
ALTER "Type" TYPE character varying,
ALTER "Type" DROP DEFAULT,
ALTER "Type" DROP NOT NULL,
ALTER "LuggageCapacity" TYPE character varying,
ALTER "LuggageCapacity" DROP DEFAULT,
ALTER "LuggageCapacity" DROP NOT NULL,
ALTER "Description" TYPE text,
ALTER "Description" DROP DEFAULT,
ALTER "Description" DROP NOT NULL,
ALTER "PAXDetail" TYPE character varying,
ALTER "PAXDetail" DROP DEFAULT,
ALTER "PAXDetail" DROP NOT NULL,
ADD "CoverImage" text NULL;
COMMENT ON COLUMN packages."Transport"."Type" IS '';
COMMENT ON COLUMN packages."Transport"."LuggageCapacity" IS '';
COMMENT ON COLUMN packages."Transport"."Description" IS '';
COMMENT ON COLUMN packages."Transport"."PAXDetail" IS '';
COMMENT ON TABLE packages."Transport" IS '';


ALTER TABLE main."Agents"
    ADD "Logo" text NULL;
COMMENT ON TABLE main."Agents" IS '';



ALTER TABLE main."ExternalAgent"
    ADD "DomainID" bigint NULL;
COMMENT ON TABLE main."ExternalAgent" IS '';


ALTER TABLE main."ExternalAgent"
ALTER "DomainID" TYPE bigint,
ALTER "DomainID" SET DEFAULT '0',
ALTER "DomainID" DROP NOT NULL;
COMMENT ON COLUMN main."ExternalAgent"."DomainID" IS '';
COMMENT ON TABLE main."ExternalAgent" IS '';
COMMENT ON TABLE main."Agents" IS '';

CREATE SEQUENCE websites."Orders_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE websites."Orders_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE websites."Orders"
(
    "UID" bigint NOT NULL DEFAULT nextval('websites."Orders_UID_seq"'::regclass),
    "DomainID" bigint,
    "UserID" bigint,
    "Status" character varying COLLATE pg_catalog."default",
    "SystemDate" timestamp without time zone DEFAULT now(),
    "OrderDate" timestamp without time zone,
    CONSTRAINT "Orders_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE websites."Orders"
    OWNER to umrahfuras;

CREATE SEQUENCE websites."Orders_Flights_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE websites."Orders_Flights_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE websites."Orders_Flights"
(
    "UID" bigint NOT NULL DEFAULT nextval('websites."Orders_Flights_UID_seq"'::regclass),
    "OrderID" bigint,
    "DomainID" bigint,
    "FlightType" character varying COLLATE pg_catalog."default",
    "FlightClass" character varying COLLATE pg_catalog."default",
    "Adults" smallint,
    childs smallint DEFAULT 0,
    infants smallint DEFAULT 0,
    "Fare" character varying COLLATE pg_catalog."default",
    "SystemDate" timestamp without time zone DEFAULT now(),
    "Archive" smallint DEFAULT 0,
    CONSTRAINT "Orders_Flights_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE websites."Orders_Flights"
    OWNER to umrahfuras;

CREATE SEQUENCE websites."Flight_Sectors_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE websites."Flight_Sectors_UID_seq"
    OWNER TO postgres;

CREATE TABLE websites."Flight_Sectors"
(
    "UID" bigint NOT NULL DEFAULT nextval('websites."Flight_Sectors_UID_seq"'::regclass),
    "FlightID" bigint,
    "FlightType" character varying COLLATE pg_catalog."default",
    "DepartureAirport" character varying COLLATE pg_catalog."default",
    "DepartureAirportCode" character varying COLLATE pg_catalog."default",
    "DepartureDate" date,
    "DepartureTime" time without time zone,
    "ArrivalAirport" character varying COLLATE pg_catalog."default",
    "ArrivalAirportCode" character varying COLLATE pg_catalog."default",
    "ArrivalDate" date,
    "ArrivalTime" time without time zone,
    "AirlineCode" character varying COLLATE pg_catalog."default",
    "FlightDuration" character varying COLLATE pg_catalog."default",
    "SystemDate" timestamp without time zone DEFAULT now(),
    "Archive" smallint DEFAULT 0,
    CONSTRAINT "Flight_Sectors_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE websites."Flight_Sectors"
    OWNER to postgres;

CREATE SEQUENCE websites."Order_Payment_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE websites."Order_Payment_UID_seq"
    OWNER TO postgres;

CREATE TABLE websites."Order_Payment"
(
    "UID" bigint NOT NULL DEFAULT nextval('websites."Order_Payment_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "OrderID" character varying COLLATE pg_catalog."default",
    "PaymentMode" character varying COLLATE pg_catalog."default",
    "Amount" character varying COLLATE pg_catalog."default",
    "PaymentApiResponse" json,
    "Archive" smallint DEFAULT 0,
    CONSTRAINT "Order_Payment_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE websites."Order_Payment"
    OWNER to postgres;

ALTER TABLE voucher."TransportRate"
DROP "RowID";
COMMENT ON TABLE voucher."TransportRate" IS '';

ALTER TABLE voucher."TransportRate"
ALTER "Routes" TYPE bigint,
ALTER "Routes" DROP DEFAULT,
ALTER "Routes" DROP NOT NULL;
ALTER TABLE voucher."TransportRate" RENAME "Routes" TO "Sectors";
COMMENT ON COLUMN voucher."TransportRate"."Sectors" IS '';
COMMENT ON TABLE voucher."TransportRate" IS '';

ALTER TABLE packages."Packages"
DROP "VisaFee",
DROP "FoodCharges";
COMMENT ON TABLE packages."Packages" IS '';

ALTER TABLE voucher."TransportRate"
ALTER "Rate" TYPE character varying,
ALTER "Rate" DROP DEFAULT,
ALTER "Rate" DROP NOT NULL;
COMMENT ON COLUMN voucher."TransportRate"."Rate" IS '';
COMMENT ON TABLE voucher."TransportRate" IS '';

ALTER TABLE voucher."TransportRate"
ALTER "TransportTypeUID" TYPE character varying,
ALTER "TransportTypeUID" DROP DEFAULT,
ALTER "TransportTypeUID" DROP NOT NULL;
COMMENT ON COLUMN voucher."TransportRate"."TransportTypeUID" IS '';
COMMENT ON TABLE voucher."TransportRate" IS '';


ALTER TABLE voucher."ZiyaratsRate"
DROP "RowID",
ALTER "TransportTypeUID" TYPE character varying,
ALTER "TransportTypeUID" DROP DEFAULT,
ALTER "TransportTypeUID" DROP NOT NULL;
COMMENT ON COLUMN voucher."ZiyaratsRate"."TransportTypeUID" IS '';
COMMENT ON TABLE voucher."ZiyaratsRate" IS '';

ALTER TABLE voucher."ZiyaratsRate"
    ADD "ZiyaratCity" character varying NULL;
COMMENT ON TABLE voucher."ZiyaratsRate" IS '';

CREATE SEQUENCE voucher."Services_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE voucher."Services_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE voucher."Services"
(
    "UID" bigint NOT NULL DEFAULT nextval('voucher."Services_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "VoucherUID" bigint,
    "ServiceID" character varying COLLATE pg_catalog."default",
    CONSTRAINT "Services_pkey" PRIMARY KEY ("UID")
)
    WITH (
        OIDS = FALSE
        )
    TABLESPACE pg_default;

ALTER TABLE voucher."Services"
    OWNER to umrahfuras;

ALTER TABLE packages."Packages"
    ADD "ApprovalDate" date NULL;
COMMENT ON TABLE  packages."Packages" IS '';

ALTER TABLE main."Cities"
    ADD "Slug" character varying NULL;
COMMENT ON TABLE main."Cities" IS '';

ALTER TABLE voucher."AccommodationDetails"
DROP "Country";
COMMENT ON TABLE voucher."AccommodationDetails" IS '';

ALTER TABLE voucher."Master"
    ADD "UpdationCounter" bigint NOT NULL DEFAULT '0';
COMMENT ON TABLE voucher."Master" IS '';

ALTER TABLE main."Agents"
    ADD "IATALicense" character varying NULL,
ADD "UmrahAgreement" character varying NULL,
ADD "CompanyName" character varying NULL;
COMMENT ON TABLE main."Agents" IS '';

ALTER TABLE voucher."Flights"
DROP "Traveltype";
COMMENT ON TABLE voucher."Flights" IS '';

ALTER TABLE voucher."AccommodationDetails"
    ADD "NoOfBeds" character varying NULL;
COMMENT ON TABLE voucher."AccommodationDetails" IS '';

ALTER TABLE main."AdminSettings"
    ADD "DomainID" bigint NULL;
COMMENT ON TABLE main."AdminSettings" IS '';

ALTER TABLE main."Users"
    ADD "DomainID" bigint NULL;
COMMENT ON TABLE main."Users" IS '';

ALTER TABLE main."Users"
ALTER "DomainID" TYPE bigint,
ALTER "DomainID" SET DEFAULT '0',
ALTER "DomainID" DROP NOT NULL;
COMMENT ON COLUMN main."Users"."DomainID" IS '';
COMMENT ON TABLE main."Users" IS '';

ALTER TABLE websites."Settings"
ALTER "DomainID" TYPE bigint,
ALTER "DomainID" SET DEFAULT '0',
ALTER "DomainID" DROP NOT NULL;
COMMENT ON COLUMN websites."Settings"."DomainID" IS '';
COMMENT ON TABLE websites."Settings" IS '';

ALTER TABLE voucher."AccommodationDetails"
    ADD "AmountPayable" character varying NULL;
COMMENT ON TABLE voucher."AccommodationDetails" IS '';

ALTER TABLE main."AdminSettings"
ALTER "DomainID" TYPE bigint,
ALTER "DomainID" SET DEFAULT '0',
ALTER "DomainID" DROP NOT NULL;
COMMENT ON COLUMN main."AdminSettings"."DomainID" IS '';
COMMENT ON TABLE main."AdminSettings" IS '';

ALTER TABLE main."Agents"
    ADD "WebsiteDomain" bigint NULL DEFAULT '0';
COMMENT ON TABLE main."Agents" IS '';


ALTER TABLE main."AdminSettings" ADD CONSTRAINT "AdminSettings_Key_DomainID" UNIQUE ("Key", "DomainID"), DROP CONSTRAINT "Admin Setting Key";

CREATE SEQUENCE websites."Orders_Ziyarat_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE websites."Orders_Ziyarat_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE websites."Orders_Ziyarat"
(
    "UID" bigint NOT NULL DEFAULT nextval('websites."Orders_Ziyarat_UID_seq"'::regclass),
    "Order" bigint,
    "DomainID" bigint,
    "Ziyarat" character varying COLLATE pg_catalog."default",
    "Transport" character varying COLLATE pg_catalog."default",
    "Rate" character varying COLLATE pg_catalog."default",
    "SystemDate" timestamp without time zone,
    "Archive" smallint DEFAULT 0,
    CONSTRAINT "Orders_Ziyarat_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE websites."Orders_Ziyarat"
    OWNER to umrahfuras;

ALTER TABLE voucher."AccommodationDetails"
    ADD "AccommodationBRN" character varying NULL;
COMMENT ON TABLE voucher."AccommodationDetails" IS '';

ALTER TABLE voucher."TransportRate"
    ADD "TransportsBRN" character varying NULL;
COMMENT ON TABLE voucher."TransportRate" IS '';


ALTER TABLE pilgrim."master"
    ADD "WebsiteDomain" bigint NULL DEFAULT '0';
COMMENT ON TABLE pilgrim."master" IS '';

CREATE SEQUENCE websites."Orders_Hotel_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE websites."Orders_Hotel_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE websites."Orders_Hotel"
(
    "UID" bigint NOT NULL DEFAULT nextval('websites."Orders_Hotel_UID_seq"'::regclass),
    "OrderID" bigint,
    "DomainID" bigint,
    "City" character varying COLLATE pg_catalog."default",
    "Hotel" character varying COLLATE pg_catalog."default",
    "RoomType" character varying COLLATE pg_catalog."default",
    "TotalRooms" bigint,
    "Rate" bigint,
    "SystemDate" timestamp without time zone DEFAULT now(),
    "Archive" smallint DEFAULT 0,
    CONSTRAINT "Orders_Hotel_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE websites."Orders_Hotel"
    OWNER to umrahfuras;


ALTER TABLE voucher."TransportRate"
    ADD "NoOfPax" character varying NULL,
ADD "NoOfSeats" character varying NULL;
COMMENT ON TABLE voucher."TransportRate" IS '';

CREATE SEQUENCE websites."Orders_Transport_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE websites."Orders_Transport_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE websites."Orders_Transport"
(
    "UID" bigint NOT NULL DEFAULT nextval('websites."Orders_Transport_UID_seq"'::regclass),
    "OrderID" bigint,
    "DomainID" bigint,
    "TransportFor" character varying COLLATE pg_catalog."default",
    "TransportName" character varying COLLATE pg_catalog."default",
    "TransportType" character varying COLLATE pg_catalog."default",
    "LuggageCapacity" character varying COLLATE pg_catalog."default",
    "Sector" character varying COLLATE pg_catalog."default",
    "Rate" bigint,
    "SystemDate" timestamp without time zone DEFAULT now(),
    "Archive" smallint DEFAULT 0,
    CONSTRAINT "Orders_Transport_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE websites."Orders_Transport"
    OWNER to umrahfuras;

ALTER TABLE websites."Orders"
    ADD "Amount" double precision NOT NULL;
COMMENT ON TABLE websites."Orders" IS '';

ALTER TABLE main."Cities"
    ADD "CoverImage" bigint NOT NULL DEFAULT '0';
COMMENT ON TABLE main."Cities" IS '';


CREATE SEQUENCE websites."stats_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE websites."stats_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE websites.stats
(
    "UID" bigint NOT NULL DEFAULT nextval('websites."stats_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "DomainID" bigint,
    "StatsKey" character varying(255) COLLATE pg_catalog."default",
    "Value" character varying(240) COLLATE pg_catalog."default",
    CONSTRAINT stats_pkey PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE websites.stats
    OWNER to umrahfuras;


ALTER TABLE websites."stats"
ALTER "DomainID" TYPE bigint,
ALTER "DomainID" SET DEFAULT '0',
ALTER "DomainID" DROP NOT NULL;
COMMENT ON COLUMN websites."stats"."DomainID" IS '';
COMMENT ON TABLE websites."stats" IS '';



ALTER TABLE websites."Domains" ADD "ParentID" bigint NOT NULL DEFAULT '0';
COMMENT ON TABLE websites."Domains" IS '';

ALTER TABLE main."Groups"
    ADD "WebsiteDomain" bigint NULL;
COMMENT ON TABLE main."Groups" IS '';



ALTER TABLE packages."Hotels"
    ADD "WebsiteDomain" bigint NULL;
COMMENT ON TABLE packages."Hotels" IS '';


ALTER TABLE packages."Transport"
    ADD "WebsiteDomain" bigint NULL;
COMMENT ON TABLE packages."Transport" IS '';

ALTER TABLE voucher."Master"
    ADD "WebsiteDomain" bigint NULL;
COMMENT ON TABLE voucher."Master" IS '';

ALTER TABLE packages."Ziyarats"
    ADD "WebsiteDomain" bigint NULL;
COMMENT ON TABLE packages."Ziyarats" IS '';

ALTER TABLE packages."Packages"
    ADD "WebsiteDomain" bigint NULL;
COMMENT ON TABLE packages."Packages" IS '';

ALTER TABLE sale_agent."Agents"
    ADD "WebsiteDomain" bigint NULL;
COMMENT ON TABLE sale_agent."Agents" IS '';

ALTER TABLE main."Operators"
    ADD "WebsiteDomain" bigint NULL;
COMMENT ON TABLE main."Operators" IS '';

CREATE SEQUENCE packages."OtherHotels_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE packages."OtherHotels_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE packages."OtherHotels"
(
    "UID" bigint NOT NULL DEFAULT nextval('packages."OtherHotels_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "Name" character varying COLLATE pg_catalog."default",
    "Category" character varying COLLATE pg_catalog."default",
    "Distance" character varying COLLATE pg_catalog."default",
    "Address" character varying COLLATE pg_catalog."default",
    "TelephoneNumber" character varying COLLATE pg_catalog."default",
    "Latitude" character varying COLLATE pg_catalog."default",
    "Longitude" character varying COLLATE pg_catalog."default",
    "GoogleMAP" character varying COLLATE pg_catalog."default",
    "Archive" smallint DEFAULT (0)::smallint,
    "CountryID" character varying COLLATE pg_catalog."default",
    "CityID" bigint,
    "Description" character varying COLLATE pg_catalog."default",
    "Status" character varying COLLATE pg_catalog."default",
    "WebsiteDomain" bigint,
    CONSTRAINT "OtherHotels_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE packages."OtherHotels"
    OWNER to umrahfuras;


ALTER TABLE voucher."AccommodationDetails" ADD "Self" smallint NULL DEFAULT '0';
COMMENT ON TABLE voucher."AccommodationDetails" IS '';

ALTER TABLE voucher."Flights" ADD "TravelSelf" smallint NULL DEFAULT '0';
COMMENT ON TABLE "Flights" IS '';

ALTER TABLE voucher."TransportRate" ADD "SelfTransport" smallint NULL DEFAULT '0';
COMMENT ON TABLE "TransportRate" IS '';

CREATE SEQUENCE voucher."Remarks_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE voucher."Remarks_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE voucher."Remarks"
(
    "UID" bigint NOT NULL DEFAULT nextval('voucher."Remarks_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "VoucherID" bigint,
    "Remarks" text COLLATE pg_catalog."default",
    "CreatedBy" bigint,
    "CreatedDate" timestamp without time zone,
    CONSTRAINT "Remarks_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE voucher."Remarks"
    OWNER to umrahfuras;COMMENT ON TABLE "TransportRate" IS '';

ALTER TABLE main."Agents"
    ADD "LastName" text NULL;
COMMENT ON TABLE main."Agents" IS '';

ALTER TABLE voucher."Master"
    ADD "CurrentStatus" character varying(255) NOT NULL DEFAULT 'Pending';
COMMENT ON TABLE "Master" IS '';

ALTER TABLE pilgrim."master"
    ADD "Gender" character varying(15) NULL;
COMMENT ON TABLE "master" IS '';


CREATE SCHEMA "BRN";

CREATE SEQUENCE "BRN"."brn_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE "BRN"."brn_UID_seq"
    OWNER TO umrahfuras;


CREATE TABLE "BRN".brn
(
    "UID" bigint NOT NULL DEFAULT nextval('"BRN"."brn_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "BRNCode" text COLLATE pg_catalog."default",
    "Operator" text COLLATE pg_catalog."default",
    "Type" text COLLATE pg_catalog."default",
    "Company" text COLLATE pg_catalog."default",
    "HotelID" text COLLATE pg_catalog."default",
    "Seats" text COLLATE pg_catalog."default",
    "Quantity" text COLLATE pg_catalog."default",
    "Rooms" text COLLATE pg_catalog."default",
    "ArrivalDate" date,
    "CheckInDate" date,
    "CheckOutDate" date,
    "WebsiteDomain" bigint,
    "Archive" smallint DEFAULT '0'::smallint,
    CONSTRAINT brn_pkey PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE "BRN".brn
    OWNER to umrahfuras;

ALTER TABLE pilgrim."mofa"
    ADD "Embassy" character varying(255) NULL;
COMMENT ON TABLE "mofa" IS '';


ALTER TABLE "BRN"."brn"
ALTER "ArrivalDate" TYPE date,
ALTER "ArrivalDate" DROP DEFAULT,
ALTER "ArrivalDate" DROP NOT NULL;
ALTER TABLE "BRN"."brn" RENAME "ArrivalDate" TO "GenerateDate";
COMMENT ON COLUMN "BRN"."brn"."GenerateDate" IS '';
COMMENT ON TABLE "BRN"."brn" IS '';

ALTER TABLE "BRN"."brn"
ALTER "CheckInDate" TYPE date,
ALTER "CheckInDate" DROP DEFAULT,
ALTER "CheckInDate" DROP NOT NULL;
ALTER TABLE "BRN"."brn" RENAME "CheckInDate" TO "ActiveDate";
COMMENT ON COLUMN "BRN"."brn"."ActiveDate" IS '';
COMMENT ON TABLE "BRN"."brn" IS '';


ALTER TABLE "BRN"."brn"
ALTER "CheckOutDate" TYPE date,
ALTER "CheckOutDate" DROP DEFAULT,
ALTER "CheckOutDate" DROP NOT NULL;
ALTER TABLE "BRN"."brn" RENAME "CheckOutDate" TO "ExpireDate";
COMMENT ON COLUMN "BRN"."brn"."ExpireDate" IS '';
COMMENT ON TABLE "BRN"."brn" IS '';

ALTER TABLE  "BRN"."brn"
ALTER "Quantity" TYPE text,
ALTER "Quantity" DROP DEFAULT,
ALTER "Quantity" DROP NOT NULL;
ALTER TABLE  "BRN"."brn" RENAME "Quantity" TO "Beds";
COMMENT ON COLUMN  "BRN"."brn"."Beds" IS '';
COMMENT ON TABLE  "BRN"."brn" IS '';

ALTER TABLE voucher."Pilgrim"
    ADD "Leader" smallint NOT NULL DEFAULT '0';
COMMENT ON TABLE "Pilgrim" IS '';


ALTER TABLE "BRN"."brn"
DROP "Type";
COMMENT ON TABLE "BRN"."brn" IS '';


ALTER TABLE "BRN"."brn"
DROP "HotelID";
COMMENT ON TABLE "BRN"."brn" IS '';

ALTER TABLE "BRN"."brn"
    ADD "HotelsID" bigint NULL;
COMMENT ON TABLE "BRN"."brn" IS '';

ALTER TABLE "BRN"."brn"
    ADD "BRNType" character varying(10) NULL;
COMMENT ON TABLE "BRN"."brn" IS '';

ALTER TABLE "pilgrim"."meta"
    ADD "SystemDate" timestamp without time zone DEFAULT now();
COMMENT ON TABLE "pilgrim"."meta" IS '';


ALTER TABLE "BRN"."brn"
    ADD "CreatedBy" bigint NULL,
ADD "CreatedDate" date NULL;
COMMENT ON TABLE "BRN"."brn" IS '';


ALTER TABLE "BRN"."brn"
    ADD "ModifiedBy" bigint NULL,
ADD "ModifiedDate" date NULL;
COMMENT ON TABLE "BRN"."brn" IS '';


ALTER TABLE "pilgrim"."meta"
ALTER "SystemDate" TYPE timestamp,
ALTER "SystemDate" SET DEFAULT now(),
ALTER "SystemDate" DROP NOT NULL;
ALTER TABLE "meta" RENAME "SystemDate" TO "CreatedDate";
COMMENT ON COLUMN "meta"."CreatedDate" IS '';
COMMENT ON TABLE "pilgrim"."meta" IS '';


ALTER TABLE "pilgrim"."meta"
    ADD "CreatedBy" bigint NULL;
COMMENT ON TABLE "pilgrim"."meta" IS '';


ALTER TABLE "voucher"."Master"
    ADD "CreatedBy" bigint NULL,
ADD "CreatedDate" date NULL;
COMMENT ON TABLE "voucher"."Master" IS '';


ALTER TABLE "voucher"."Master"
    ADD "ModifiedBy" bigint NULL,
ADD "ModifiedDate" date NULL;
COMMENT ON TABLE "voucher"."Master" IS '';


ALTER TABLE "websites"."stats" ADD "AgentID" bigint NOT NULL DEFAULT '0';
COMMENT ON TABLE "websites"."stats" IS '';


ALTER TABLE main."Operators"
ALTER "FullName" TYPE text,
ALTER "FullName" DROP DEFAULT,
ALTER "FullName" DROP NOT NULL,
ADD "ContactPersonName" text NULL,
ADD "ContactNo" character varying NULL,
ADD "Email" character varying NULL,
ADD "OfficeCity" text NULL,
ADD "Category" text NULL,
ADD "Country" character varying NULL;
ALTER TABLE  main."Operators" RENAME "FullName" TO "CompanyName";
COMMENT ON COLUMN  main."Operators"."CompanyName" IS '';
COMMENT ON TABLE  main."Operators" IS '';


ALTER TABLE  main."Operators"
ALTER "ContactNo" TYPE character varying(150),
ALTER "ContactNo" DROP DEFAULT,
ALTER "ContactNo" DROP NOT NULL,
ALTER "Email" TYPE character varying(150),
ALTER "Email" DROP DEFAULT,
ALTER "Email" DROP NOT NULL,
ALTER "Country" TYPE character varying(150),
ALTER "Country" DROP DEFAULT,
ALTER "Country" DROP NOT NULL,
ADD "Type" character varying(150) NULL;
COMMENT ON COLUMN  main."Operators"."ContactNo" IS '';
COMMENT ON COLUMN  main."Operators"."Email" IS '';
COMMENT ON COLUMN  main."Operators"."Country" IS '';
COMMENT ON TABLE  main."Operators" IS '';


ALTER TABLE main."Operators"
    ADD "Logo" integer NULL;
COMMENT ON TABLE main."Operators" IS '';


ALTER TABLE "BRN"."brn"
    ADD "PurchaseID" character varying NULL;
COMMENT ON TABLE "BRN"."brn" IS '';

ALTER TABLE "BRN"."brn"
    ADD "PurchasedBy" integer NULL;
COMMENT ON TABLE "BRN"."brn" IS '';


ALTER TABLE "BRN"."brn"
    ADD "NoOfVehicles" integer NULL;
COMMENT ON TABLE "BRN"."brn" IS '';

ALTER TABLE "BRN"."brn"
    ADD "UseType" character varying NULL;
COMMENT ON TABLE "BRN"."brn" IS '';


ALTER TABLE  sale_agent."Agents"
    ADD "EmergencyContactNumber" character varying NULL,
ADD "EmergencyContactName" text NULL;
COMMENT ON TABLE  sale_agent."Agents" IS '';

ALTER TABLE main."Groups"
DROP "Embassy",
DROP "DepartureDate";
COMMENT ON TABLE main."Groups" IS '';


ALTER TABLE main."Groups"
    ADD "Country" character varying(150) NULL,
ADD "WTUCode" character varying(150) NULL,
ADD "NoOfPAX" bigint NULL,
ADD "TransportType" character varying(150) NULL,
ADD "ArrivalDate" date NULL,
ADD "DepartureDate" date NULL,
ADD "Remarks" text NULL;
COMMENT ON TABLE main."Groups" IS '';

CREATE SEQUENCE main."GroupHotel_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE main."GroupHotel_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE main."GroupHotel"
(
    "UID" bigint NOT NULL DEFAULT nextval('main."GroupHotel_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "GroupID" bigint,
    CONSTRAINT "GroupHotel_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE main."GroupHotel"
    OWNER to umrahfuras;


CREATE SEQUENCE main."GroupTransport_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE main."GroupTransport_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE main."GroupTransport"
(
    "UID" bigint NOT NULL DEFAULT nextval('main."GroupTransport_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "GroupID" bigint,
    CONSTRAINT "GroupTransport_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE main."GroupTransport"
    OWNER to umrahfuras;

CREATE SEQUENCE main."GroupZiyarat_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE main."GroupZiyarat_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE main."GroupZiyarat"
(
    "UID" bigint NOT NULL DEFAULT nextval('main."GroupZiyarat_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "GroupID" bigint,
    CONSTRAINT "GroupZiyarat_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE main."GroupZiyarat"
    OWNER to umrahfuras;


CREATE SEQUENCE main."GroupServices_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE main."GroupServices_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE main."GroupServices"
(
    "UID" bigint NOT NULL DEFAULT nextval('main."GroupServices_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "GroupID" bigint,
    CONSTRAINT "GroupServices_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE main."GroupServices"
    OWNER to umrahfuras;

ALTER TABLE main."GroupHotel"
    ADD "City" character varying NULL,
ADD "Hotel" bigint NULL,
ADD "RoomType" bigint NULL,
ADD "CheckIn" date NULL,
ADD "CheckOut" date NULL,
ADD "NoOfBeds" bigint NULL,
ADD "AmountPayable" bigint NULL;
COMMENT ON TABLE main."GroupHotel" IS '';


ALTER TABLE main."GroupTransport"
    ADD "TransportSectors" bigint NULL,
ADD "Transport" bigint NULL,
ADD "NoOfPax" bigint NULL,
ADD "NoOfSeats" bigint NULL,
ADD "TransportsRates" bigint NULL;
COMMENT ON TABLE main."GroupTransport" IS '';


ALTER TABLE main."GroupZiyarat"
    ADD "ZiyaratCity" bigint NULL,
ADD "Ziyarat" bigint NULL,
ADD "TransportRateZiyrat" bigint NULL,
ADD "ZiyaratTransportsRates" bigint NULL;
COMMENT ON TABLE main."GroupZiyarat" IS '';


ALTER TABLE main."GroupServices"
    ADD "ServiceID" bigint NULL;
COMMENT ON TABLE main."GroupServices" IS '';


ALTER TABLE main."GroupZiyarat"
DROP "ZiyaratTransportsRates";
COMMENT ON TABLE main."GroupZiyarat" IS '';

ALTER TABLE main."GroupZiyarat"
    ADD "ZiyaratTransport" bigint NULL;
COMMENT ON TABLE main."GroupZiyarat" IS '';

ALTER TABLE main."Groups"
    ADD "Status" character varying NULL;
COMMENT ON TABLE main."Groups" IS '';

ALTER TABLE voucher."RemarksMeta"
ALTER "Remarks" TYPE text,
ALTER "Remarks" DROP DEFAULT,
ALTER "Remarks" DROP NOT NULL;
COMMENT ON COLUMN voucher."RemarksMeta"."Remarks" IS '';
COMMENT ON TABLE voucher."RemarksMeta" IS '';

ALTER TABLE main."GroupServices"
    ADD "ServiceRate" bigint NULL;
COMMENT ON TABLE main."GroupServices" IS '';


ALTER TABLE voucher."ZiyaratsRate"
    ADD "RefundReason" text NULL;
COMMENT ON TABLE voucher."ZiyaratsRate" IS '';


ALTER TABLE voucher."TransportRate"
    ADD "RefundReason" text NULL;
COMMENT ON TABLE voucher."TransportRate" IS '';

ALTER TABLE voucher."Services"
    ADD "RefundReason" text NULL;
COMMENT ON TABLE voucher."Services" IS '';

ALTER TABLE voucher."AccommodationDetails"
    ADD "RefundReason" text NULL;
COMMENT ON TABLE voucher."AccommodationDetails" IS '';

ALTER TABLE  main."Groups"
ALTER "Status" TYPE character varying,
ALTER "Status" SET DEFAULT 'in-complete',
ALTER "Status" DROP NOT NULL;
COMMENT ON COLUMN  main."Groups"."Status" IS '';
COMMENT ON TABLE  main."Groups" IS '';


ALTER TABLE main."Groups"
    ADD "Visa" bigint NULL;
COMMENT ON TABLE main."Groups" IS '';


ALTER TABLE voucher."AccommodationDetails"
    ADD "Refund" smallint NOT NULL DEFAULT '0';
COMMENT ON TABLE voucher."AccommodationDetails" IS '';

ALTER TABLE voucher."Services"
    ADD "Refund" smallint NOT NULL DEFAULT '0';
COMMENT ON TABLE voucher."Services" IS '';

ALTER TABLE voucher."TransportRate"
    ADD "Refund" smallint NOT NULL DEFAULT '0';
COMMENT ON TABLE voucher."TransportRate" IS '';

ALTER TABLE voucher."ZiyaratsRate"
    ADD "Refund" smallint NOT NULL DEFAULT '0';
COMMENT ON TABLE voucher."ZiyaratsRate" IS '';

ALTER TABLE "BRN"."brn"
    ADD "BookingDate" date NULL;
COMMENT ON TABLE "BRN"."brn" IS '';


CREATE SEQUENCE "BRN"."UseBRN_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE "BRN"."UseBRN_UID_seq"
    OWNER TO umrahfuras;


CREATE TABLE "BRN"."UseBRN"
(
    "UID" bigint NOT NULL DEFAULT nextval('"BRN"."UseBRN_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    CONSTRAINT "UseBRN_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE "BRN"."UseBRN"
    OWNER to umrahfuras;


ALTER TABLE "BRN"."UseBRN"
    ADD "Type" text NULL,
ADD "BRNCode" character varying NULL,
ADD "Rooms" bigint NULL,
ADD "Beds" bigint NULL,
ADD "UseID" bigint NULL,
ADD "UsedDate" date NULL,
ADD "Seats" bigint NULL,
ADD "Archive" integer NULL DEFAULT '0';
COMMENT ON TABLE "BRN"."UseBRN" IS '';

ALTER TABLE "BRN"."UseBRN"
ALTER "Rooms" TYPE bigint,
ALTER "Rooms" SET DEFAULT '0',
ALTER "Rooms" DROP NOT NULL,
ALTER "Beds" TYPE bigint,
ALTER "Beds" SET DEFAULT '0',
ALTER "Beds" DROP NOT NULL;
COMMENT ON COLUMN "BRN"."UseBRN"."Rooms" IS '';
COMMENT ON COLUMN "BRN"."UseBRN"."Beds" IS '';
COMMENT ON TABLE "BRN"."UseBRN" IS '';


ALTER TABLE "BRN"."brn"
    ADD "TransportType" integer NULL;
COMMENT ON TABLE "BRN"."brn" IS '';

ALTER TABLE "BRN""UseBRN"
    ADD "ExpireDate" date NULL;
COMMENT ON TABLE "BRN""UseBRN" IS '';

ALTER TABLE pilgrim."meta"
    ADD "AllowReference" bigint NOT NULL DEFAULT '0';
COMMENT ON TABLE pilgrim."meta" IS '';


ALTER TABLE  voucher."TransportRate"
    ADD "TravelDate" date NULL;
COMMENT ON TABLE  voucher."TransportRate" IS '';

ALTER TABLE  voucher."ZiyaratsRate"
    ADD "ZiyaratNoOfPax" bigint NULL;
COMMENT ON TABLE  voucher."ZiyaratsRate" IS '';

ALTER TABLE main."GroupZiyarat"
    ADD "ZiyaratNoOfPax" bigint NULL;
COMMENT ON TABLE main."GroupZiyarat" IS '';

ALTER TABLE voucher."TransportRate"
    ADD "TravelCity" bigint NULL,
ADD "TravelType" character varying NULL;
COMMENT ON TABLE voucher."TransportRate" IS '';

ALTER TABLE main."Agents"
    ADD "Domain" text NULL;
COMMENT ON TABLE main."Agents" IS '';



CREATE SEQUENCE voucher."RemarksMeta_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE voucher."RemarksMeta_UID_seq"
    OWNER TO umrahfuras;



CREATE TABLE voucher."RemarksMeta"
(
    "UID" bigint NOT NULL DEFAULT nextval('voucher."RemarksMeta_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    CONSTRAINT "RemarksMeta_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE voucher."RemarksMeta"
    OWNER to umrahfuras;


ALTER TABLE  voucher."RemarksMeta"
    ADD "VoucherID" bigint NULL,
ADD "Option" character varying(250) NULL,
ADD "Value" text NULL;
COMMENT ON TABLE  voucher."RemarksMeta" IS '';


ALTER TABLE main."Groups" ADD "VisaRate" bigint NOT NULL DEFAULT '0';
COMMENT ON TABLE main."Groups" IS '';


ALTER TABLE main."Groups" ADD "PackageID" bigint NOT NULL DEFAULT '0';
COMMENT ON TABLE main."Groups" IS '';

ALTER TABLE voucher."RemarksMeta"
ALTER "VoucherID" TYPE bigint,
ALTER "VoucherID" DROP DEFAULT,
ALTER "VoucherID" DROP NOT NULL,
ALTER "Option" TYPE character varying(250),
ALTER "Option" DROP DEFAULT,
ALTER "Option" DROP NOT NULL,
DROP "Value";
ALTER TABLE voucher."RemarksMeta" RENAME "VoucherID" TO "ActivityID";
COMMENT ON COLUMN voucher."RemarksMeta"."ActivityID" IS '';
ALTER TABLE voucher."RemarksMeta" RENAME "Option" TO "Type";
COMMENT ON COLUMN voucher."RemarksMeta"."Type" IS '';
COMMENT ON TABLE voucher."RemarksMeta" IS '';


ALTER TABLE voucher."RemarksMeta"
    ADD "Quantity" character varying NULL,
ADD "Remarks" bigint NULL;
COMMENT ON TABLE voucher."RemarksMeta" IS '';

ALTER TABLE voucher."RemarksMeta"
DROP "VoucherID",
DROP "Option";
COMMENT ON TABLE voucher."RemarksMeta" IS '';

ALTER TABLE voucher."RemarksMeta"  RENAME TO voucher."RefundMeta";

ALTER TABLE voucher."RefundMeta"
    ADD "VoucherUID" bigint NULL;
COMMENT ON TABLE voucher."RefundMeta" IS '';


ALTER TABLE pilgrim."master"
    ADD "MiddleName" character varying(150) NULL,
ADD "PassportExpiryDate" date NULL,
ADD "CitizenShipNumber" character varying(150) NULL;
COMMENT ON TABLE pilgrim."master" IS '';

ALTER TABLE temp."mofa_file"
    ADD "Brn" bigint NULL;
COMMENT ON TABLE temp."mofa_file" IS '';


ALTER TABLE main."Groups"
    ADD "DeleteDate" date NULL;
COMMENT ON TABLE main."Groups" IS '';




CREATE SEQUENCE IF NOT EXISTS main."GroupHotelRooms_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE main."GroupHotelRooms_UID_seq"
    OWNER TO umrahfuras;


CREATE TABLE IF NOT EXISTS main."GroupHotelRooms"
(
    "UID" bigint NOT NULL DEFAULT nextval('main."GroupHotelRooms_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "GroupHotelID" bigint,
    "RoomType" bigint,
    "RoomQTY" bigint,
    "AmountPayable" double precision,
    CONSTRAINT "GroupHotelRooms_pkey" PRIMARY KEY ("UID")
    )
    TABLESPACE pg_default;

ALTER TABLE IF EXISTS main."GroupHotelRooms"
    OWNER to umrahfuras;


ALTER TABLE pilgrim."master"
    ADD "PilgrimType" text NOT NULL DEFAULT 'B2B';
COMMENT ON TABLE pilgrim."master" IS '';


ALTER TABLE "BRN"."brn"
    ADD "PromoCode" character varying NULL;
COMMENT ON TABLE "BRN"."brn" IS '';

ALTER TABLE voucher."Master"
    ADD "VoucherType" text NOT NULL DEFAULT 'B2B';
COMMENT ON TABLE voucher."Master" IS '';

CREATE SCHEMA inbox AUTHORIZATION umrahfuras;

CREATE SEQUENCE inbox."master_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE inbox."master_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE inbox."master"
(
    "UID" bigint NOT NULL DEFAULT nextval('inbox."master_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "FromUser" bigint,
    "Subject" character varying COLLATE pg_catalog."default",
    "Content" text NULL,
    CONSTRAINT "master_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE inbox."master"
    OWNER to umrahfuras;

CREATE SEQUENCE inbox."users_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE inbox."users_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE inbox."users"
(
    "UID" bigint NOT NULL DEFAULT nextval('inbox."users_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "MasterID" bigint,
    "ReplyID" bigint NOT NULL DEFAULT 0,
    "Type" character varying NOT NULL DEFAULT 'to',
    "ToUser" bigint,
    "Read" smallint NOT NULL DEFAULT 0,
    "Important" smallint NOT NULL DEFAULT 0,
    "Archive" smallint NOT NULL DEFAULT 0,
    CONSTRAINT "users_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE inbox."users"
    OWNER to umrahfuras;

CREATE SEQUENCE inbox."attachments_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE inbox."attachments_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE inbox."attachments"
(
    "UID" bigint NOT NULL DEFAULT nextval('inbox."attachments_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "MasterID" bigint,
    "ReplyID" bigint NOT NULL DEFAULT 0,
    "AttachmentID" bigint NOT NULL DEFAULT 0,
    "Archive" smallint NOT NULL DEFAULT 0,
    CONSTRAINT "attachments_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE inbox."attachments"
    OWNER to umrahfuras;

CREATE SEQUENCE inbox."replies_UID_seq"
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE inbox."replies_UID_seq"
    OWNER TO umrahfuras;

CREATE TABLE inbox."replies"
(
    "UID" bigint NOT NULL DEFAULT nextval('inbox."replies_UID_seq"'::regclass),
    "SystemDate" timestamp without time zone DEFAULT now(),
    "MasterID" bigint,
    "UserID" bigint NOT NULL DEFAULT 0,
    "Reply" text DEFAULT NULL,
    "Archive" smallint NOT NULL DEFAULT 0,
    CONSTRAINT "replies_pkey" PRIMARY KEY ("UID")
)

    TABLESPACE pg_default;

ALTER TABLE inbox."replies"
    OWNER to umrahfuras;