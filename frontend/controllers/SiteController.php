<?php

namespace frontend\controllers;


use Yii;
use yii\filters\AccessControl;
use TCPDF;


class SiteController extends BaseController
{


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['offline'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                        'verbs' => ['get'],
                    ],
                    [
                        'actions' => ['error'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                        'verbs' => ['get'],
                    ],
                ],
            ]
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    /**
     * @return mixed
     */
    public function actionIndex()
    {

        // return $this->render('index');

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // 设置文档信息
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('TCPDF Example 002');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // 去掉页眉页脚
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);


        // 自动分页
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // 设置字体
        // set font
        $pdf->SetFont('stsongstdlight', '', 14);

        // 进行自动分页
        // add a page
        $pdf->AddPage();

        // get the current page break margin
        $bMargin = $pdf->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $pdf->getAutoPageBreak();
        // disable auto-page-break
        $pdf->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = 'http://qn.hbqingze.com/b4d4b20200725152204655.png';
        $pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $pdf->setPageMark();

        $html = <<<EOD

<table cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td width="33%" align="left" ><span style="font-size: 24px;" >前小兔</span>&nbsp;<span>网络管理</span></td>
        <td width="33%" align="center">
            <img src="http://qn.hbqingze.com/9b4e9202007171550068093.png" style="height: 100px;width: 100px;border 1px solid red;" >
        </td>
        <td width="34%" align="left" style="color: #ffffff;" >
            <span>女</span>&nbsp;&nbsp;<span>1994-01</span>
            <br>
            <span><i class="fa fa-weixin" style="font-size: 40px;color:#33C3B1;"></i> 本科</span>
            <br>
            <span>一年工作经验</span>
            <br>
            <span>13673182575</span>
        </td>
    </tr>
</table>
<div style="height: 10px;" ></div>
EOD;

        $pdf->writeHTML($html, true, false, false, false, '');


// Set some content to print
        $html = <<<EOD
<p><img src="https://dss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo/logo_white-d0c9fe2af5.png" style="width: 16px;" > <a style="color:#000000;" >求职意向</a></p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;网络管理&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;上海-浦东&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5K-6K&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;随时到岗</p>
<div style="height: 10px;" ></div>
<p><img src="https://dss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo/logo_white-d0c9fe2af5.png" style="width: 16px;" > <a style="color:#000000;" >教育背景</a></p>
EOD;

        $pdf->writeHTML($html, true, false, false, false, '');

        $html = <<<EOD
<div style="height: 10px;" ></div>
<table cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td width="30%" align="left" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2011.9-2014.6</td>
        <td width="30%" align="left" >千图大学</td>
        <td width="30%" align="left" >电子信息工程</td>
        <td width="10%" align="right" >大专</td>
    </tr>
    <tr>
        <td align="left" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2011.9-2014.6</td>
        <td align="left" >千图大学</td>
        <td align="left" >电子信息工程</td>
        <td align="right" >大专</td>
    </tr>
    <tr>
        <td align="left" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2011.9-2014.6</td>
        <td align="left" >千图大学</td>
        <td align="left" >电子信息工程</td>
        <td align="right" >大专</td>
    </tr>
</table>
<div style="height: 10px;" ></div>
EOD;

        $pdf->writeHTML($html, true, false, false, false, '');


        $html = <<<EOD
<p><img src="https://dss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo/logo_white-d0c9fe2af5.png" style="width: 16px;" > <a style="display: inline-block;margin-left: 10px;color:#000000;" >工作经验</a></p>
EOD;
        $pdf->writeHTML($html, true, false, false, false, '');

        $html = <<<EOD
<div style="height: 10px;" ></div>
<table cellspacing="0" cellpadding="0" border="0"  >
    <tr>
        <td align="left" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2011.9-2014.6</td>
        <td align="center" >河北石家庄微软</td>
        <td align="right" >阿萨德</td>
    </tr>
    <tr>
        <td colspan="3" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AA制这个词汇的起源尚未有确定查证，但可能是来自药剂学的人士，因为英语“aa”或“ana”用于药物处方的释义可以为各以等量。AA制起源于大航海时代的意大利,原本只针对这一生可能只一起吃一次饭的人。AA制已经成为当今社会的流行语，尤其在社交餐饮消费场合使用较为频繁，在不少年轻夫妇中。</td>
    </tr>
</table>
<div style="height: 10px;" ></div>
<table cellspacing="0" cellpadding="0" border="0"  >
    <tr>
        <td align="left" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2011.9-2014.6</td>
        <td align="center" >河北石家庄微软</td>
        <td align="right" >阿萨德</td>
    </tr>
    <tr>
        <td colspan="3" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AA制这个词汇的起源尚未有确定查证，但可能是来自药剂学的人士，因为英语“aa”或“ana”用于药物处方的释义可以为各以等量。AA制起源于大航海时代的意大利,原本只针对这一生可能只一起吃一次饭的人。AA制已经成为当今社会的流行语，尤其在社交餐饮消费场合使用较为频繁，在不少年轻夫妇中。</td>
    </tr>
</table>
<div style="height: 10px;" ></div>
<table cellspacing="0" cellpadding="0" border="0"  >
    <tr>
        <td align="left" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2011.9-2014.6</td>
        <td align="center" >河北石家庄微软</td>
        <td align="right" >阿萨德</td>
    </tr>
    <tr>
        <td colspan="3" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AA制这个词汇的起源尚未有确定查证，但可能是来自药剂学的人士，因为英语“aa”或“ana”用于药物处方的释义可以为各以等量。AA制起源于大航海时代的意大利,原本只针对这一生可能只一起吃一次饭的人。AA制已经成为当今社会的流行语，尤其在社交餐饮消费场合使用较为频繁，在不少年轻夫妇中。</td>
    </tr>
</table>
<div style="height: 10px;" ></div>
<table cellspacing="0" cellpadding="0" border="0"  >
    <tr>
        <td align="left" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2011.9-2014.6</td>
        <td align="center" >河北石家庄微软</td>
        <td align="right" >阿萨德</td>
    </tr>
    <tr>
        <td colspan="3" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AA制这个词汇的起源尚未有确定查证，但可能是来自药剂学的人士，因为英语“aa”或“ana”用于药物处方的释义可以为各以等量。AA制起源于大航海时代的意大利,原本只针对这一生可能只一起吃一次饭的人。AA制已经成为当今社会的流行语，尤其在社交餐饮消费场合使用较为频繁，在不少年轻夫妇中。</td>
    </tr>
</table>
<div style="height: 10px;" ></div>
EOD;

        $pdf->writeHTML($html, true, false, false, false, '');

        $html = <<<EOD
<p><img src="https://dss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo/logo_white-d0c9fe2af5.png" style="width: 16px;" > <a style="margin-left: 10px;color:#000000;" >自我评价</a></p>
EOD;
        $pdf->writeHTML($html, true, false, false, false, '');


        $html = <<<EOD
<div style="height: 10px;" ></div>
<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;本人性格开朗、稳重、有活力，待人热情、真诚。
有很强的专业的职业道德，专业基础知识扎实。
工作认真负责，主动承担责任，
积极与周围工作环境建立良好的工作关系，
并具有一定的资源协调能力。
与同事，其它部门各极配合，
有较强的组织能力、实际动手能力和团体协作精神。
能迅速的适应各种环境，并融合其中。</span>
<div style="height: 10px;" ></div>
EOD;
        $pdf->writeHTML($html, true, false, false, false, '');

        $html = <<<EOD
<table cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td width="100%" align="center">
            <span>-----------------------</span>
            <span style="font-size: 18px;" >慧智招聘</span>
            <span>-----------------------</span>
        </td>
    </tr>
</table>
EOD;

        $pdf->writeHTML($html, true, false, false, false, '');


        // $pdf->Output(time() . '.pdf', 'D');
        $pdf->Output(time() . '.pdf', 'I');

    }


    /**
     * 维护
     */
    public function actionOffline()
    {

        return $this->render('offline');

    }


}
