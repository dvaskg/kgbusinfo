<?php
      // parametri za lokalni sajt
      // $hostname_konekcija = "localhost";
      // $database_konekcija = "vzsbgd_vzdbgd";	// naziv baze podataka
      // $username_konekcija = "vzsbgd_vzsbgd"; 
      // $password_konekcija = "bgdvzs11";

      $hostname_konekcija = "";  // ovo je probni lockopije sajt
      $database_konekcija = "";
      $username_konekcija = ""; 
      $password_konekcija = "";

      $DatPrefix = "";	// 
      $mapKey = 'f_HOS45pJ2ClEZ6cMHbLWXqNBBfXrf-Fs1kI6S9PemA';

      $ftp_server = ""; 
      $ftp_username=""; 
      $ftp_userpass=""; 
      $trebaSortiranjeListe= false; // treba, ako FTP serever ne vraća sortiranu

      $FtpDirPodaci = array(
            '',
            ''
      );
      try {$dbh = new PDO("mysql:host=$hostname_konekcija; dbname=$database_konekcija", $username_konekcija, $password_konekcija, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));} catch(PDOException $e){echo $e->getMessage();}
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

