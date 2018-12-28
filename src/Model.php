<?php
namespace RainSunshineCloud;

class Model extends ModelAbstract
{
	protected  $prefix = null;
	protected  $table = null;

	/**
	 *查找
	 *模式有如下几种,默认正常返回二维数组
	 *OBJ 返回预处理后的Driver对象
	 *GROUP 返回第一个字段做群组,剩余字段为value的三维数组
	 *GCOLUMN 返回第一个字段做群组,第二个字段为value的二维数组
	 *ACOLUMN 返回第一个字段为值的一维数组
	 *
	 * @param  string    $mode 模式
	 * @return array
	 */
	protected function select($mode = '')
	{	
		$res = $this->getSqlModel()->get();
		self::$lastSql = $res;
		$res = self::$driver->query($res['sql'],$res['data'],$mode);
		return $res;
	}

	/**
	 * 查找一条数据
	 */
	protected function find()
	{
		$res = $this->getSqlModel()->limit(1)->get();
		self::$lastSql = $res;
		$res = self::$driver->query($res['sql'],$res['data']);
		if (empty($res) && empty($res[0])){
			return [];
		}else {
			return $res[0];
		}
	}

	/**
	 * 插入
	 * @param  array   $data  插入数据(二维数据)
	 * @param  Closure $func  回调函数，传入每个插入值
	 * @param  array   $field 更新字段(对应索引数组)
	 * @return bool
	 */
	protected function insertAll(array $data,$func = '',$field = [])
	{
		$res = $this->getSqlModel()->insertAll($data,$field,$func);
		self::$lastSql = $res;
		return self::$driver->execute($res['sql'],$res['data']);
	}

	/**
	 * 插入
	 * @param  array | $obj $data  插入数据
	 * @param  bool|boolean $getId 更新字段
	 * @param  Closure | array | string  
	 * @return bool|int;
	 */
	protected function insert($data,bool $getId = false,$func = '')
	{
		$res = $this->getSqlModel()->insert($data,$func);
		self::$lastSql = $res;
		return self::$driver->execute($res['sql'],$res['data'],$getId);
	}

	/**
	 * 更新
	 * @param  array   $data 更新数据
	 * @param  Closure $func 回调函数，传入每个更新值
	 * @return bool
	 */
	protected function update(array $data,$func = '')
	{
		$res = $this->getSqlModel()->update($data,$func);
		self::$lastSql = $res;
		return self::$driver->execute($res['sql'],$res['data']);
	}

	/**
	 * 删除
	 */
	protected function delete()
	{
		$res = $this->getSqlModel()->delete();
		self::$lastSql = $res;
		return self::$driver->execute($res['sql'],$res['data']);
	}

	/**
	 * replace
	 */
	protected function replace(array $data,$func ='')
	{
		$res = $this->getSqlModel()->replace($data,$func);
		self::$lastSql = $res;
		return self::$driver->execute($res['sql'],$res['data']);
	}

	/**
	 * on duplicate key
	 */
	protected function duplicate(array $insert_data,array $update_data)
	{
		$res = $this->getSqlModel()->duplicate($insert_data,$update_data);
		self::$lastSql = $res;
		return self::$driver->execute($res['sql'],$res['data']);
	}
	
}