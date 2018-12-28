<?php 

include  "../../../autoload.php";

use RainSunshineCloud\Sql;
use RainSunshineCloud\SqlException;
use RainSunshineCloud\Model;
use RainSunshineCloud\ModelException;

try {
	Model::setConfig([
		'uri'      	=> 'mysql',
		'db'  		=> '',
		'host' 		=> '',
		'port'		=> '',
		'user'		=> '',
		'password' 	=> '',
	]);
	Model::setDriver('RainSunshineCloud\Driver\PDODriver');
	$model = Model::prefix('syf_')->table('user')->where('id',3)->delete();
	var_dump(Model::getLastSql(true));
} catch (DriverException $e) {
	echo $e->getMessage();
} catch (SqlException $e) {
	echo $e->getMessage();
} catch (ModelException $e) {
	echo $e->getMessage();
}

