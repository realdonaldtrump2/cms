<?php

namespace common\target;

use Yii;
use yii\log\Target;


class SqlTarget extends Target
{

    public function export()
    {

        // tail -f sql.log 结合tail for windows 使用

        array_pop($this->messages); //去掉最后一个消息，因为这个与SQL无关，只是底层自动额外追加的一些请求和运行时相关信息

        $sqlList = [];
        foreach ($this->messages as $message) {
            $sqlList[] = $message[0];
        }

        $listContent = implode(PHP_EOL . PHP_EOL, $sqlList);
        $sqlNums = count($sqlList);
        $datetime = date('Y-m-d H:i:s');

        $logContent = <<<EOL

------------------------------------------------start-------------------------------------------------------------------

执行的SQL时间：$datetime

执行的SQL次数：$sqlNums

执行的SQL语句：

$listContent

-------------------------------------------------end--------------------------------------------------------------------

EOL;

        $moduleName = Yii::$app->controller->module->id;
        $logFile = Yii::getAlias("@{$moduleName}/sqls/sql_" . date('Ymd') . '.log');
        file_put_contents($logFile, $logContent . PHP_EOL, FILE_APPEND);

    }

}

