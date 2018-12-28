<?php
include  "../../../autoload.php";

$sql = Sql::table('table')
			->where('id','=',1)
			->insert(['name'=>2,'id'=>1]);
			$model = Sql::table('t1');
$sql = $model->where('id','=',1)->insertAll([['name'=>2,'id'=>1],['id'=>2,'name'=>1]]);

echo $sql.PHP_EOL;
var_export($model->getPrepareData());