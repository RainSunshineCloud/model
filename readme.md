### 一个Model驱动器封装类

## 用法


```

$sql = Sql::table('table')
            ->where('id','=',1)
            ->insert(['name'=>2,'id'=>1]);
            $model = Sql::table('t1');
$sql = $model->where('id','=',1)->insertAll([['name'=>2,'id'=>1],['id'=>2,'name'=>1]]);


use RainSunshineCloud\Sql;
use RainSunshineCloud\SqlException;
use RainSunshineCloud\Model;
use RainSunshineCloud\ModelException;

try {
    Model::setConfig([
        'uri'       => 'mysql',
        'db'        => '',
        'host'      => '',
        'port'      => '',
        'user'      => '',
        'password'  => '',
    ]);
    $model = Model::prefix('syf_')->table('user')->where('id',3)->delete();
} catch (DriverException $e) {
    echo $e->getMessage();
} catch (SqlException $e) {
    echo $e->getMessage();
} catch (ModelException $e) {
    echo $e->getMessage();
}


```

## 注意

### Sql 封装的相关方法，请自行查看rain_sunshine_cloud/sql 包的相关介绍，也可以自行封装一个Sql的相关方法，通过属性Model::$SqlModel进行修改

### Driver 驱动器采用的方法，请自行查看相关文档，现默认使用PDO作为驱动器,可以自行更改需继承DriverIngerface接口，通过方法setDriver()进行更改

### 该模型克隆时，会克隆Sql模型

### ModelAbstract 调度器，用户调度 Sql类和Driver类，以及自身的相关功能

#### 需实现的方法有

```
    //查询
    protected abstract function select($mode);
    //查找一条
    protected abstract function find();
    //插入多条
    protected abstract function insertAll(array $data);
    //插入单条
    protected abstract function insert($data);
    //更新
    protected abstract function update(array $data);
    //删除
    protected abstract function delete();
    //替换
    protected abstract function replace(array $data);
    //insert on duplicate key update
    protected abstract function duplicate(array $insert_data,array $update_data);


```
##### 已经实现的有

```
//获取最后执行的Sql语句
Model::getLastSql()
Model::getLastSql(true)

//获取Sql模型
$model->getSqlModel() 

//设置driver 驱动参数
Model::setConfig

//设置驱动
Model::setDriver

//清空对象
$model ->close
```
