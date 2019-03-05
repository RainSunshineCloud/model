<?php
namespace RainSunshineCloud;

Abstract class ModelAbstract 
{
	//驱动模型来源
	private static $drive = 'RainSunshineCloud\Driver\PDODriver';
	//sql模型来源
	protected static $SqlModel = 'RainSunshineCloud\Sql';
	//驱动
	protected static $driver = null;
	//最后一条sql
	protected static $lastSql = [];
	//前缀
	protected  $prefix = null;
	//表名
	protected  $table = null;
	//初始化标记
	private    $boot = false;
	//sql模型
	private  $Sql = null;

	/**
	 * 静态调用生成驱动和对象
	 */
	public static function __callStatic($methods,$args)
	{
		$model = get_called_class();
		$obj = new $model();
		
		if (!self::$driver) {//驱动设置在静态属性
			self::$driver = new self::$drive();
		}
		$method_up = strtoupper($methods); 
		if ($method_up == 'QUERY') {
			return call_user_func_array([$this,'query'], $args);
		} else if (in_array($method_up ,['BEGINTRANSACTION','ROLLBACK','COMMIT'])) {//事务处理
			return call_user_func_array([self::$driver,$methods], $args);
		} 
		
		$obj->Sql = call_user_func_array([self::$SqlModel,$methods], $args);
		if ($obj->boot == false) {
			$obj->init($method_up,$methods);
		}
		return $obj;
	}

	/**
	 * 初始化
	 * @return [type] [description]
	 */
	protected function init($method_up,$methods)
	{
		//初始化表
		if ($method_up != 'TABLE') {
			if ($this->table) {
				$this->Sql = call_user_func_array([$this->Sql,'table'], [$this->table]);
			} else if (($table = get_called_class()) && strtoupper($table) != 'MODEL') {
				$table = substr($table,0,-5);
				if ($table) {
					$this->Sql = call_user_func_array([$this->Sql,'table'], [strtolower($table)]);
				}
			}
		} 

		//初始化表前缀
		if ($method_up != 'PREFIX') {
			if ($this->prefix) {
				$this->Sql = call_user_func_array([$this->Sql,'prefix'], [$this->prefix]);
			}
		} 

		$this->boot = true;
	}

	/**
	 * 静态调用(注意，没有值时默认传入空数组)
	 */
	public function __call($methods,$args)
	{
		if (!self::$driver) {//驱动设置在静态属性
			self::$driver = new self::$drive();
		}
		if (in_array($methods,['get'])) {
			return $this->select($args);
		} else if (method_exists($this, $methods)) {
			return call_user_func_array([$this,$methods], $args);
		} else if (method_exists(self::$driver,$methods)){ //调用DRIVER
		    return call_user_func_array([self::$driver,$methods], $args);
		} else if (!$this->Sql) {
			$this->Sql = call_user_func_array([self::$SqlModel,$methods], $args);
		} else {
			$this->Sql = call_user_func_array([$this->Sql,$methods], $args);
		} 
		if ($this->boot == false) {
			$this->init(strtoupper($methods),$methods);
		}
		return $this;
	}


	/**
	 * 获取最后的Sql语句
	 * @return 获取最后参数
	 */
	public static function getLastSql($is_string = [])
	{
		if ($is_string && self::$lastSql) {
			return str_replace(array_keys(self::$lastSql['data']),self::$lastSql['data'],self::$lastSql['sql']);
		}

		return self::$lastSql;
	}
	
	/**
	 * 克隆时克隆Sql模型
	 */
	public function __clone()
	{
		$this->Sql = clone $this->Sql;
	}

	/**
	 * 清空对象，并关闭模型
	 * @return [type] [description]
	 */
	protected function close ()
	{
		self::$driver = null;
		$this->Sql = null;
	}
	
	/**
	 * 设置配置参数
	 * @param [type] $array [description]
	 */
	public static function setConfig(array $array)
	{
		call_user_func_array([self::$drive,'setConfig'],[$array]);
	}

	/**
	 * 获取sql模型
	 * @return [type] [description]
	 */
	protected function getSqlModel()
	{
		return $this->Sql;
	}

	/**
	 * 设置driver驱动
	 * @param string $driver [description]
	 */
	public static function setDriver(string $driver) 
	{
		self::$driver = new $driver();
		if (self::$driver instanceof Driver\DriverInterface) {
			self::$drive = $driver;
		} else {
			self::$dirver = null;
			throw new ModelException('必须实现RainSunshineCloud\Driver\DriverInterface 接口');
		}
	}

	protected abstract function select($mode);
	protected abstract function find();
	protected abstract function insertAll(array $data);
	protected abstract function insert($data);
	protected abstract function update(array $data);
	protected abstract function delete();
	protected abstract function replace(array $data);
	protected abstract function duplicate(array $insert_data,array $update_data);
}


class ModelException extends \Exception {}
