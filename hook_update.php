<?php
function MYMODULE_update_7001() {
  // Manual database changes to the field config table. Sometimes there is serialized data to take into account.
  db_query("UPDATE {field_config} SET type = 'number_integer', module = 'number' WHERE field_name = 'field_name'");
  // Text fields have an aditional column for format which number doest have. We drop those.
  db_query("ALTER TABLE field_data_name DROP field_name_format");
  db_query("ALTER TABLE field_revision_name DROP field_name_format");
  // Change all empty values to 0 otherwise we get an error.
  db_query("UPDATE field_data_name SET field_name_value = '0' WHERE field_name_value =''");
  db_query("UPDATE field_revision_name SET field_name_value = '0' WHERE field_name_value =''");
//change the default values
  db_change_field('field_data_name', 'field_name_value', 'field_name_value', array(
    'type' => 'int',
    'length' => 11,
    'not null' => FALSE,
    'default' => NULL
  ));

  //revision field
  db_change_field('field_revision_name', 'field_name_value', 'field_name_value', array(
    'type' => 'int',
    'length' => 11,
    'not null' => FALSE,
    'default' => NULL
  ));

  field_cache_clear(TRUE);
}
