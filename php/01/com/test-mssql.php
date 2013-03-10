<?php
mssql_connect("192.168.1.132", "sa", "root") or die("No fue posible conectar con el servidor");
mssql_select_db("COMPAC") or die("No fue posible selecionar la base de datos");
mssql_close();
print "Conexion OK";
?>