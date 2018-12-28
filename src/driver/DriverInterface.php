<?php
namespace RainSunshineCloud\Driver;

Interface DriverInterface
{
	public static function setConfig(array $config);

	/**
	 * 查询
	 * @param  string $sql    [sql]
	 * @param  array  $params [参数]
	 * @param  string $mode   [模式]
	 * @return array
	 */
	public  function query(string $sql,array $params);

	/**
	 * 更新/插入
	 * @param  string       $sql       [sql语句]
	 * @param  array        $bind      [数组]
	 * @param  bool|boolean $getLastId [最后的Id]
	 * @return bool | int
	 */
	public function execute(string $sql,array $bind,bool $getLastId = false,$exec = 'update');
	
	/**
	 * 事务回滚
	 * @return [type] [description]
	 */
	public function rollback();

	/**
	 * 事务提交
	 * @return [type] [description]
	 */
	public function commit();

	/**
	 * 开启事务
	 * @return [type] [description]
	 */
	public function beginTransaction();
}