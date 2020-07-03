<?php

namespace backend\controllers;

use Yii;
use yii\web\Response;

use OSS\OssClient;
use OSS\Core\OssException;


class UploadController extends BaseController
{


    public $enableCsrfValidation = false;


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $behaviors = parent::behaviors();
        return $behaviors;

    }


    /**
     * 上传图片文件
     *
     * @return array
     */
    public function actionImageFile()
    {

        // 阿里云主账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM账号进行API访问或日常运维，请登录 https://ram.console.aliyun.com 创建RAM账号。
        $accessKeyId = Yii::$app->params['aliAccessKeyId'];
        $accessKeySecret = Yii::$app->params['aliAccesskeySecret'];
        // Endpoint以杭州为例，其它Region请按实际情况填写。
        $endpoint = Yii::$app->params['aliEndpoint'];
        // 存储空间名称
        $bucket = Yii::$app->params['aliOss'];
        // 检测文件类型
        if (!in_array(pathinfo($_FILES['file']['name'])['extension'], ['jpeg', 'jpg', 'gif', 'bmp', 'png'])) {
            return ['error' => 1, 'message' => '图片上传类型错误'];
        }

        $scenario = Yii::$app->request->get('scenario');

        if ($scenario === 'shop-goods-category') {
            // 文件名称
            $object = 'shop-goods-category/' . Yii::$app->util->createUuid() . '.' . pathinfo($_FILES['file']['name'])['extension'];
        } else {
            // 文件名称
            $object = date('Y/m/d/') . Yii::$app->util->createUuid() . '.' . pathinfo($_FILES['file']['name'])['extension'];
        }

        // 文件内容
        $content = file_get_contents($_FILES['file']['tmp_name']);
        try {
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            return ['error' => 0, 'message' => '上传成功', 'data' => ['url' => $ossClient->putObject($bucket, $object, $content)['oss-request-url']]];
        } catch (OssException $e) {
            return ['error' => 1, 'message' => '上传失败'];
        }

    }


    /**
     * 上传图片文件
     *
     * @return array
     */
    public function actionWebuploaderImageFile()
    {

        // 阿里云主账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM账号进行API访问或日常运维，请登录 https://ram.console.aliyun.com 创建RAM账号。
        $accessKeyId = Yii::$app->params['aliAccessKeyId'];
        $accessKeySecret = Yii::$app->params['aliAccesskeySecret'];
        // Endpoint以杭州为例，其它Region请按实际情况填写。
        $endpoint = Yii::$app->params['aliEndpoint'];
        // 存储空间名称
        $bucket = Yii::$app->params['aliOss'];
        // 检测文件类型
        if (!in_array(pathinfo($_FILES['file']['name'])['extension'], ['jpeg', 'jpg', 'gif', 'bmp', 'png'])) {
            return ['code' => 1, 'msg' => '图片上传类型错误'];
        }

        // 文件名称
        $object = date('Y/m/d/') . Yii::$app->util->createUuid() . '.' . pathinfo($_FILES['file']['name'])['extension'];

        // 文件内容
        $content = file_get_contents($_FILES['file']['tmp_name']);
        try {

            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);

            return [
                'code' => 0,
                'msg' => '上传成功',
                'url' => $ossClient->putObject($bucket, $object, $content)['oss-request-url'],
                'attachment' => $ossClient->putObject($bucket, $object, $content)['oss-request-url']
            ];

        } catch (OssException $e) {
            return ['code' => 1, 'msg' => '上传失败'];
        }

    }


    /**
     * 上传图片base64
     *
     * @return array
     */
    public function actionImageBase64()
    {

        // base64
        $base64Image = Yii::$app->request->post('file');
        if (!$base64Image) {
            return ['error' => 1, 'message' => '图片上传类型错误'];
        }
        if (!preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64Image, $result)) {
            return ['error' => 1, 'message' => '图片上传类型错误'];
        }

        // 检测文件类型
        $type = $result[2];
        if (!in_array($type, ['jpeg', 'jpg', 'gif', 'bmp', 'png'])) {
            return ['error' => 1, 'message' => '图片上传类型错误'];
        }

        // 阿里云主账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM账号进行API访问或日常运维，请登录 https://ram.console.aliyun.com 创建RAM账号。
        $accessKeyId = Yii::$app->params['aliAccessKeyId'];
        $accessKeySecret = Yii::$app->params['aliAccesskeySecret'];

        // Endpoint以杭州为例，其它Region请按实际情况填写。
        $endpoint = Yii::$app->params['aliEndpoint'];

        // 存储空间名称
        $bucket = Yii::$app->params['aliOss'];

        // 文件名称
        $object = date('Y/m/d/') . Yii::$app->util->createUuid() . '.' . $type;

        // 文件内容
        $content = base64_decode(str_replace($result[1], '', $base64Image));

        try {
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            return ['error' => 0, 'message' => '上传成功', 'data' => ['url' => $ossClient->putObject($bucket, $object, $content)['oss-request-url']]];
        } catch (OssException $e) {
            return ['error' => 1, 'message' => '上传失败'];
        }

    }


    /**
     * 上传文件
     *
     * @return array
     */
    public function actionFile()
    {

        // 阿里云主账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM账号进行API访问或日常运维，请登录 https://ram.console.aliyun.com 创建RAM账号。
        $accessKeyId = Yii::$app->params['aliAccessKeyId'];
        $accessKeySecret = Yii::$app->params['aliAccesskeySecret'];

        // Endpoint以杭州为例，其它Region请按实际情况填写。
        $endpoint = Yii::$app->params['aliEndpoint'];

        // 存储空间名称
        $bucket = Yii::$app->params['aliOss'];

        // 文件名称
        $object = date('Y/m/d/') . Yii::$app->util->createUuid() . '.' . pathinfo($_FILES['file']['name'])['extension'];

        // 文件内容
        $content = file_get_contents($_FILES['file']['tmp_name']);

        try {
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            return ['error' => 0, 'message' => '上传成功', 'data' => ['url' => $ossClient->putObject($bucket, $object, $content)['oss-request-url']]];
        } catch (OssException $e) {
            return ['error' => 1, 'message' => '上传失败'];
        }

    }


    /**
     * 上传文件base64
     *
     * @return array
     */
    public function actionBase64()
    {

        // base64
        $base64 = Yii::$app->request->post('file');
        if (!$base64) {
            return ['error' => 1, 'message' => '上传失败'];
        }
        preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64, $result);

        // 文件类型
        $type = $result[2];

        // 阿里云主账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM账号进行API访问或日常运维，请登录 https://ram.console.aliyun.com 创建RAM账号。
        $accessKeyId = Yii::$app->params['aliAccessKeyId'];
        $accessKeySecret = Yii::$app->params['aliAccesskeySecret'];

        // Endpoint以杭州为例，其它Region请按实际情况填写。
        $endpoint = Yii::$app->params['aliEndpoint'];

        // 存储空间名称
        $bucket = Yii::$app->params['aliOss'];

        // 文件名称
        $object = date('Y/m/d/') . Yii::$app->util->createUuid() . '.' . $type;

        // 文件内容
        $content = base64_decode(str_replace($result[1], '', $base64));

        try {
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            return ['error' => 0, 'message' => '上传成功', 'data' => ['url' => $ossClient->putObject($bucket, $object, $content)['oss-request-url']]];
        } catch (OssException $e) {
            return ['error' => 1, 'message' => '上传失败'];
        }

    }


}