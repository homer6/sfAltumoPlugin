<?xml version="1.0" encoding="UTF-8"?>
<database name="propel" package="lib.model" defaultIdMethod="native">

    <!-- Order of sections: Columns, Foreign Keys, Indexes, Uniques, Behaviors -->

    
    <table name="country">
        
        <!-- Fixture representing a Country --> 
        
        <column name="id" type="INTEGER" primaryKey="true" autoIncrement="true" />
        <column name="name" type="VARCHAR" size="64" required="true" />
        <column name="iso_code" type="VARCHAR" size="12" required="true" />
        <column name="iso_short_code" type="VARCHAR" size="2" required="true" />
        
        
        <index name="index_name">
            <index-column name="name" />
        </index>
        
        
        <unique name="unique_iso_short_code">
            <unique-column name="iso_short_code" />
        </unique>
        
        <unique name="unique_iso_code">
            <unique-column name="iso_code" />
        </unique>

    </table>
    
    
    <table name="currency">

        <!-- Fixture representing a monetary currency. -->

        <column name="id" type="INTEGER" required="true" primaryKey="true" autoIncrement="true" />
        <column name="name" type="VARCHAR" required="true" size="64" />
        <column name="iso_code" type="VARCHAR" required="true" size="3" />
        <column name="iso_number" type="VARCHAR" required="true" size="3" />

    </table>


    <table name="state">

        <!-- Fixture representing a State or Country political subdivision --> 
        
        <column name="id" type="INTEGER" primaryKey="true" autoIncrement="true" />
        <column name="name" type="VARCHAR" size="64" required="true" />
        <column name="iso_code" type="VARCHAR" size="12" required="true" />
        <column name="iso_short_code" type="VARCHAR" size="2" required="true" />
        <column name="country_id" type="INTEGER" required="true" />
        <column name="created_at" type="timestamp" />
        <column name="updated_at" type="timestamp" />

        
        <foreign-key foreignTable="country" onDelete="cascade">
            <reference local="country_id" foreign="id" />
        </foreign-key>


        <index name="index_name"> 
            <index-column name="name" />
        </index>
        
        
        <unique name="unique_iso_short_code">
            <unique-column name="iso_short_code" />
        </unique>
        
        <unique name="unique_iso_code">
            <unique-column name="iso_code" />
        </unique>

    </table>
    
    
    <table name="contact">
    
        <!-- Contact information for an entity. Can be associated to any object that is contactable -->
    
        <column name="id" type="integer" required="true" primaryKey="true" autoIncrement="true" />
        <column name="first_name" type="VARCHAR" size="64" required="false" />
        <column name="last_name" type="VARCHAR" size="64" required="false" />
        <column name="company_name" type="VARCHAR" size="128" required="false" />
        <column name="email_address" type="varchar" required="true" size="150" />
        <column name="phone_main_number" type="varchar" required="false" size="32" />
        <column name="phone_other_number" type="varchar" required="false" size="32" />
        <column name="mailing_address" type="varchar" size="255" />
        <column name="mailing_address_latitude" type="double" />
        <column name="mailing_address_longitude" type="double" />
        <column name="city" type="varchar" size="64" />
        <column name="state_id" type="integer" required="true" />
        <column name="zip_code" type="varchar" size="7" />
        <column name="created_at" type="timestamp" />
        <column name="updated_at" type="timestamp" />


        <foreign-key foreignTable="state" onDelete="restrict">
            <reference local="state_id" foreign="id" />
        </foreign-key>


        <index name="index_email_address">
            <index-column name="email_address" />
        </index>

        <index name="index_phone_main_number">
            <index-column name="phone_main_number" />
        </index>
        
        <index name="index_lat_long">
            <index-column name="mailing_address_latitude" />
            <index-column name="mailing_address_longitude" />
        </index>
        
    </table>
    


    <table name="user">

        <column name="id" type="integer" required="true" primaryKey="true" autoIncrement="true" />
        <column name="password_reset_key" type="varchar" required="false" size="16" />
        <column name="sf_guard_user_id" type="integer" required="true" />
        <column name="contact_id" type="INTEGER" required="false" />
        <column name="active" type="boolean" />
        <column name="created_at" type="timestamp" />
        <column name="updated_at" type="timestamp" />

        
        <foreign-key foreignTable="contact" onDelete="restrict">
            <reference local="contact_id" foreign="id" />
        </foreign-key>

        <foreign-key foreignTable="sf_guard_user" onDelete="cascade">
            <reference local="sf_guard_user_id" foreign="id" />
        </foreign-key>
        
        
        <index name="index_active">
            <index-column name="active" />
        </index>
        
        <unique name="unique_password_reset_key">
            <unique-column name="password_reset_key" />
        </unique>
        
        <unique name="unique_sf_guard_user_id">
            <unique-column name="sf_guard_user_id" />
        </unique>
        
    </table>
    
    
    <table name="session">

        <column name="id" type="integer" required="true" primaryKey="true" autoIncrement="true" />
        <column name="session_key" type="varchar" required="true" size="32" />
        <column name="data" type="blob" />
        <column name="client_ip_address" type="varchar" size="39" />
        <column name="session_type" type="varchar" size="32" />
        <column name="time" type="integer" required="true" />
        <column name="user_id" required="false" type="INTEGER" />
        

        <foreign-key foreignTable="user" onDelete="cascade">
            <reference local="user_id" foreign="id" />
        </foreign-key>
        
        
        <index name="index_client_ip_address">
            <index-column name="client_ip_address" />
        </index>
        
        <index name="index_time">
            <index-column name="time" />
        </index>
        
        
        <unique name="unique_session_key">
            <unique-column name="session_key" />
        </unique>

    </table>


    <table name="single_sign_on_key">

        <column name="id" type="integer" required="true" primaryKey="true" autoIncrement="true" />
        <column name="secret" type="varchar" required="true" size="32" />
        <column name="used" type="boolean" required="true" default="" />
        <column name="session_id" type="integer" required="false" />
        <column name="user_id" type="integer" required="true" />
        <column name="valid_for_minutes" type="integer" required="true" default="1440" />
        <column name="created_at" type="timestamp" />
        <column name="updated_at" type="timestamp" />
        
        
        <foreign-key foreignTable="session" onDelete="cascade">
            <reference local="session_id" foreign="id" />
        </foreign-key>
        
        <foreign-key foreignTable="user" onDelete="cascade">
            <reference local="user_id" foreign="id" />
        </foreign-key>
        
        
        <index name="index_secret_used">
            <index-column name="secret" />
            <index-column name="used" />
        </index>
        
        <index name="index_used">
            <index-column name="used" />
        </index>
        
        
        <unique name="unique_secret">
            <unique-column name="secret" />
        </unique>

    </table>


    <table name="system_event">

        <column name="id" type="integer" required="true" primaryKey="true" autoIncrement="true" />
        <column name="name" type="varchar" required="true" size="64" />
        <column name="unique_key" type="varchar" required="true" size="64" />
        <column name="slug" type="varchar" required="true" size="255" />
        <column name="enabled" type="boolean" required="true" default="1" />
        <column name="created_at" type="timestamp" />
        <column name="updated_at" type="timestamp" />
        
        
        <index name="index_name">
            <index-column name="name" />
        </index>
        
        <index name="index_enabled">
            <index-column name="enabled" />
        </index>
        
        
        <unique name="unique_unique_key">
            <unique-column name="unique_key" />
        </unique>
        
        <unique name="unique_slug">
            <unique-column name="slug" />
        </unique>

    </table>


    <table name="system_event_subscription">

        <column name="id" type="integer" required="true" primaryKey="true" autoIncrement="true" />
        <column name="system_event_id" type="integer" required="true" />
        <column name="user_id" type="integer" required="true" />
        <column name="remote_url" type="varchar" size="255" />
        <column name="authorization_token" type="varchar" size="255" />
        <column name="enabled" type="boolean" required="true" default="1" />
        <column name="created_at" type="timestamp" />
        <column name="updated_at" type="timestamp" />
        
        
        <foreign-key foreignTable="system_event" onDelete="cascade" onUpdate="cascade">
            <reference local="system_event_id" foreign="id" />
        </foreign-key>
        
        <foreign-key foreignTable="user" onDelete="cascade" onUpdate="cascade">
            <reference local="user_id" foreign="id" />
        </foreign-key>
        
        
        <index name="index_enabled">
            <index-column name="enabled" />
        </index>

    </table>


    <table name="system_event_instance">

        <column name="id" type="integer" required="true" primaryKey="true" autoIncrement="true" />
        <column name="system_event_id" type="integer" required="true" />
        <column name="user_id" type="integer" />
        <column name="message" type="longvarchar" />
        <column name="created_at" type="timestamp" />
        <column name="updated_at" type="timestamp" />
        
        
        <foreign-key foreignTable="system_event" onDelete="cascade" onUpdate="cascade">
            <reference local="system_event_id" foreign="id" />
        </foreign-key>
        
        <foreign-key foreignTable="user" onDelete="cascade" onUpdate="cascade">
            <reference local="user_id" foreign="id" />
        </foreign-key>

    </table>


    <table name="system_event_instance_message">

        <column name="id" type="integer" required="true" primaryKey="true" autoIncrement="true" />
        <column name="system_event_instance_id" type="integer" required="true" />
        <column name="system_event_subscription_id" type="integer" required="true" />
        <column name="received" type="boolean" required="true" default="" />
        <column name="received_at" type="timestamp" />
        <column name="status_message" type="varchar" size="255" />
        <column name="created_at" type="timestamp" />
        <column name="updated_at" type="timestamp" />
        
        
        <foreign-key foreignTable="system_event_instance" onDelete="cascade" onUpdate="cascade">
            <reference local="system_event_instance_id" foreign="id" />
        </foreign-key>
        
        <foreign-key foreignTable="system_event_subscription" onDelete="cascade" onUpdate="cascade">
            <reference local="system_event_subscription_id" foreign="id" />
        </foreign-key>
        

        <index name="index_received">
            <index-column name="received" />
        </index>

    </table>
        

</database>