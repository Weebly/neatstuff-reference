--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: neatstuff; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA neatstuff;


ALTER SCHEMA neatstuff OWNER TO postgres;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = neatstuff, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: themes; Type: TABLE; Schema: neatstuff; Owner: wwwdata; Tablespace: 
--

CREATE TABLE themes (
    theme_id integer NOT NULL,
    name character varying(255),
    price money,
    tags text
);


ALTER TABLE neatstuff.themes OWNER TO wwwdata;

--
-- Name: themes_theme_id_seq; Type: SEQUENCE; Schema: neatstuff; Owner: wwwdata
--

CREATE SEQUENCE themes_theme_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE neatstuff.themes_theme_id_seq OWNER TO wwwdata;

--
-- Name: themes_theme_id_seq; Type: SEQUENCE OWNED BY; Schema: neatstuff; Owner: wwwdata
--

ALTER SEQUENCE themes_theme_id_seq OWNED BY themes.theme_id;


--
-- Name: user; Type: TABLE; Schema: neatstuff; Owner: postgres; Tablespace: 
--

CREATE TABLE "user" (
    user_id integer NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    subdomain character varying(255) NOT NULL,
    weebly_user integer
);


ALTER TABLE neatstuff."user" OWNER TO postgres;

--
-- Name: user_user_id_seq; Type: SEQUENCE; Schema: neatstuff; Owner: postgres
--

CREATE SEQUENCE user_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE neatstuff.user_user_id_seq OWNER TO postgres;

--
-- Name: user_user_id_seq; Type: SEQUENCE OWNED BY; Schema: neatstuff; Owner: postgres
--

ALTER SEQUENCE user_user_id_seq OWNED BY "user".user_id;


--
-- Name: theme_id; Type: DEFAULT; Schema: neatstuff; Owner: wwwdata
--

ALTER TABLE ONLY themes ALTER COLUMN theme_id SET DEFAULT nextval('themes_theme_id_seq'::regclass);


--
-- Name: user_id; Type: DEFAULT; Schema: neatstuff; Owner: postgres
--

ALTER TABLE ONLY "user" ALTER COLUMN user_id SET DEFAULT nextval('user_user_id_seq'::regclass);


--
-- Name: themes_pkey; Type: CONSTRAINT; Schema: neatstuff; Owner: wwwdata; Tablespace: 
--

ALTER TABLE ONLY themes
    ADD CONSTRAINT themes_pkey PRIMARY KEY (theme_id);


--
-- Name: user_email_key; Type: CONSTRAINT; Schema: neatstuff; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_email_key UNIQUE (email);


--
-- Name: user_pkey; Type: CONSTRAINT; Schema: neatstuff; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (user_id);


--
-- Name: user_subdomain_key; Type: CONSTRAINT; Schema: neatstuff; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_subdomain_key UNIQUE (subdomain);


--
-- Name: neatstuff; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA neatstuff FROM PUBLIC;
REVOKE ALL ON SCHEMA neatstuff FROM postgres;
GRANT ALL ON SCHEMA neatstuff TO postgres;
GRANT ALL ON SCHEMA neatstuff TO wwwdata;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

