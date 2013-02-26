<?php
// Array definitions
  $tNG_login_config = array();
  $tNG_login_config_session = array();
  $tNG_login_config_redirect_success  = array();
  $tNG_login_config_redirect_failed  = array();

// Start Variable definitions
  $tNG_debug_mode = "PRODUCTION";
  $tNG_debug_log_type = "email";
  $tNG_debug_email_to = "webmaster@blinfo.com.br";
  $tNG_debug_email_subject = "[BUG] The site sindicatos";
  $tNG_debug_email_from = "webmaster@blinfo.com.br";
  $tNG_email_host = "smtp.sistemafindes.org.br";
  $tNG_email_user = "ideies@sistemafindes.org.br";
  $tNG_email_port = "25";
  $tNG_email_password = "ideies";
  $tNG_email_defaultFrom = "ideies@sistemafindes.org.br";
  $tNG_login_config["connection"] = "sindicato";
  $tNG_login_config["table"] = "bl_usuario";
  $tNG_login_config["pk_field"] = "usuario_id";
  $tNG_login_config["pk_type"] = "NUMERIC_TYPE";
  $tNG_login_config["email_field"] = "usuario_email";
  $tNG_login_config["user_field"] = "usuario_login";
  $tNG_login_config["password_field"] = "usuario_senha";
  $tNG_login_config["level_field"] = "";
  $tNG_login_config["level_type"] = "STRING_TYPE";
  $tNG_login_config["randomkey_field"] = "";
  $tNG_login_config["activation_field"] = "";
  $tNG_login_config["password_encrypt"] = "false";
  $tNG_login_config["autologin_expires"] = "30";
  $tNG_login_config["redirect_failed"] = "administrador/login.php";
  $tNG_login_config["redirect_success"] = "administrador/index.php";
  $tNG_login_config["login_page"] = "administrador/login.php";
  $tNG_login_config["max_tries"] = "";
  $tNG_login_config["max_tries_field"] = "";
  $tNG_login_config["max_tries_disableinterval"] = "";
  $tNG_login_config["max_tries_disabledate_field"] = "";
  $tNG_login_config["registration_date_field"] = "";
  $tNG_login_config["expiration_interval_field"] = "";
  $tNG_login_config["expiration_interval_default"] = "";
  $tNG_login_config["logger_pk"] = "";
  $tNG_login_config["logger_table"] = "";
  $tNG_login_config["logger_user_id"] = "";
  $tNG_login_config["logger_ip"] = "";
  $tNG_login_config["logger_datein"] = "";
  $tNG_login_config["logger_datelastactivity"] = "";
  $tNG_login_config["logger_session"] = "";
  $tNG_login_config_session["kt_login_id"] = "usuario_id";
  $tNG_login_config_session["kt_login_user"] = "usuario_login";
// End Variable definitions
?>