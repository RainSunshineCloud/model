<?php

include  "../../../autoload.php";

$model = Sql::table($model1,'gg');

$sql = $model->setPrepare(false)->where('id','exit',$model1)->where('id','=',$model1)->where(function ($sql) {
	$sql->where('id','>','1');
})->where('id','=',3)->get();


$sql = Sql::table('table','t3')->date('a.mt','%Y-%m-%d','mt')
			->field('a.mt,b.mt')
			->where(['id'=>1])
			->where('id','=',2)
			->join('t2','t2.id=table.id')
			->WhereOr(['id'=>1,'ids'=>3])
			->where('id=:id',[':id'=>1])
			->group('id');
$model = Sql::table('t1');
$sql = $model->where('id','exist',$sql)->where('id','=',$sql)->where(function ($sql) {
	$sql->where('id','>','1');
})->where('id','=',3)->get();

var_export($model1->get());

var_export($sql);
var_export($model1->get());