<?php
class TutoDB {
	/* Classe para intera�ao com banco de dados*/

   /* Declara�ao das vari�veis (propriedades) da classe*/
   private $host; // Host (Servidor) que executa o banco de dados
   private $user; // Usu�rio que se conecta ao servidor de banco de dados
   private $pass; // Senha do usu�rio para conexao ao banco de dados
   private $db; // Nome do banco de dados a ser utilizado
   private $sql; // String da consulta SQL a ser executada
   
   function conectar(){
      /*Fun�ao para conexao ao banco de dados*/
      $con = mysql_connect($this->host,$this->user,$this->pass) or die($this->erro(mysql_error()));
      return $con;
   }
   
   function selecionarDB(){
      /*Fun�ao para sele�ao do banco de dados a ser usado*/
      $sel = mysql_select_db($this->db) or die($this->erro(mysql_error()));
      if($sel){
         return true;
      }else{
         return false;
      }
   }
   
   function query(){
      /*Fun�ao para execu�ao da consulta ao banco de dados*/
      $qry = mysql_query($this->sql) or die ($this->erro(mysql_error()));
      return $qry;
   }
   
   function set($prop,$value){
      /*Fun�ao para atribuir valores as propriedades da classe*/
      $this->$prop = $value;
   }
   
   function getSQL(){
      /*Fun�ao para retornar a string SQL*/
      return $this->sql;
   }
   
   function erro($erro){
      /*Fun�ao para exibir os error*/
      echo $erro;
   }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>