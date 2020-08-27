<?php

namespace common\components;

use Yii;
use yii\base\Component;
use TCPDF;
use common\data\ResumePdf;


class Pdf extends Component
{


    public function resumeGenerate()
    {

        $application_name = '应用名称';

        // 实例化
        $tcpdf = new ResumePdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // 设置文档信息
        // set document information
        $tcpdf->SetCreator($application_name);
        $tcpdf->SetAuthor($application_name);
        $tcpdf->SetTitle($application_name);
        $tcpdf->SetSubject($application_name);
        $tcpdf->SetKeywords($application_name);

        // 去掉页眉页脚
        // remove default header/footer
        // $tcpdf->setPrintHeader(false);
        // $tcpdf->setPrintFooter(false);

        // 自动分页
        // set auto page breaks
        $tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // 设置字体
        // set font
        $tcpdf->SetFont('stsongstdlight', '', 14);

        // 进行自动分页
        // add a page
        $tcpdf->AddPage();


//        基本信息
        $html = <<<EOD
<table border="0" style="padding: 5px 5px 5px 0px;">
    <tr>
        <td style="text-align: left;" rowspan="3" colspan="3" >
            <img src="https://qn.hbqingze.com/b830d20200820183036398.png" width="280" height="280" >
        </td>
        <td style="border-bottom: 2px solid grey;text-align: left;line-height: 20px;" colspan="3" > 
            <span style="font-size: 30px;" >安安</span>
        </td>
        <td style="border-bottom: 2px solid grey;text-align: left;line-height: 40px;" colspan="6" >
            <span style="font-size: 18px;" >求职意向：UI动画设计师助理</span>
        </td>
    </tr>
    <tr>
        <td colspan="4" style="height: 30px;line-height: 30px;" >
            <span style="margin-left: 20px;" >出生年月：199X年X月</span>
        </td>
        <td colspan="5" style="height: 30px;line-height: 30px;" >
            <span style="margin-left: 20px;" >学历：本科</span>
        </td>
    </tr>
    <tr>
        <td colspan="4" >
            <span style="margin-left: 20px;" >现居地：浙江杭州</span>
        </td>
        <td colspan="5" >
            <span style="margin-left: 20px;" >专业：艺术设计</span>
        </td>
    </tr>
</table>
EOD;

        $tcpdf->writeHTML($html, true, false, false, false, '');


//        教育背景
        $html = <<<EOD
<table border="0" style="padding: 2px 10px 2px 10px;" >
    <tr>
        <td colspan="4" ><img src="https://qn.hbqingze.com/7d4f2202008241432091522.png" width="750" style="" /></td>
    </tr>
    <tr>
        <td align="left" ><span>1995-09-1999-07</span></td>
        <td align="center" ><span>河北师范大学N2</span></td>
        <td align="center" ><span>数学</span></td>
        <td align="right" ><span>本科</span></td>
    </tr>
    <tr>
        <td colspan="4" ></td>
    </tr>
    <tr>
        <td align="left" ><span>2000-09-2003-06</span></td>
        <td align="center" ><span>河北师范大学N2</span></td>
        <td align="center" ><span>计算机</span></td>
        <td align="right" ><span>研究生</span></td>
    </tr>
</table>
EOD;

        $tcpdf->writeHTML($html, true, false, false, false, '');


//        工作经验
        $html = <<<EOD
<table border="0" style="padding: 2px 10px 2px 10px;" >
    <tr>
        <td colspan="4" ><img src="https://qn.hbqingze.com/666a4202008241434114102.png" width="750" style="" /></td>
    </tr>
    <tr>
        <td align="left" ><span>2007-01-2011-06</span></td>
        <td align="center" ><span>oracle公司</span></td>
        <td align="center" ><span>微服务</span></td>
        <td align="right" ><span>6000-8000</span></td>
    </tr>
    <tr>
        <td colspan="4" >本人性格开朗、稳重、有活力，待人热情、真诚。有很强的专业的职业道德，专业基础知识扎实。工作认真负责，主动承担责任，积极与周围工作环境建立良好的工作关系，并具有一定的资源协调能力。与同事，其它部门各极配合，有较强的组织能力、实际动手能力和团体协作精神。</td>
    </tr>
    <tr>
        <td colspan="4" ></td>
    </tr>
    <tr>
        <td align="left" ><span>2011-07-2020-01</span></td>
        <td align="center" ><span>甲骨文公司</span></td>
        <td align="center" ><span>JAVA架构师</span></td>
        <td align="right" ><span>8000-10000</span></td>
    </tr>
    <tr>
        <td colspan="4" >本人性格开朗、稳重、有活力，待人热情、真诚。有很强的专业的职业道德，专业基础知识扎实。工作认真负责，主动承担责任，积极与周围工作环境建立良好的工作关系，并具有一定的资源协调能力。与同事，其它部门各极配合，有较强的组织能力、实际动手能力和团体协作精神。</td>
    </tr>
</table>
EOD;

        $tcpdf->writeHTML($html, true, false, false, false, '');


//        语言能力
        $html = <<<EOD
<table border="0" style="padding: 2px 10px 2px 10px;" >
    <tr>
        <td colspan="3" ><img src="https://qn.hbqingze.com/7690d202008251712385273.png" width="750" style="" /></td>
    </tr>
    <tr>
        <td align="left" ><span>法语</span></td>
        <td align="center" ><span>听说能力：精通</span></td>
        <td align="right" ><span>读写能力：精通</span></td>
    </tr>
    <tr>
        <td colspan="3" ></td>
    </tr>
    <tr>
        <td align="left" ><span>中文</span></td>
        <td align="center" ><span>听说能力：一般</span></td>
        <td align="right" ><span>读写能力：一般</span></td>
    </tr>
</table>
EOD;

        $tcpdf->writeHTML($html, true, false, false, false, '');


//        掌握技能
        $html = <<<EOD
<table border="0" style="padding: 2px 10px 2px 10px;" >
    <tr>
        <td><img src="https://qn.hbqingze.com/7d0b320200825171112757.png" width="750" style="" /></td>
    </tr>
    <tr>
        <td>本人性格开朗、稳重、有活力，待人热情、真诚。有很强的专业的职业道德，专业基础知识扎实。工作认真负责，主动承担责任，积极与周围工作环境建立良好的工作关系，并具有一定的资源协调能力。与同事，其它部门各极配合，有较强的组织能力、实际动手能力和团体协作精神。</td>
    </tr>
</table>
EOD;

        $tcpdf->writeHTML($html, true, false, false, false, '');


//        资格证书
        $html = <<<EOD
<table border="0" style="padding: 2px 10px 2px 10px;" >
    <tr>
        <td><img src="https://qn.hbqingze.com/7a77520200825172715937.png" width="750" style="" /></td>
    </tr>
    <tr>
        <td>本人性格开朗、稳重、有活力，待人热情、真诚。有很强的专业的职业道德，专业基础知识扎实。工作认真负责，主动承担责任，积极与周围工作环境建立良好的工作关系，并具有一定的资源协调能力。与同事，其它部门各极配合，有较强的组织能力、实际动手能力和团体协作精神。</td>
    </tr>
</table>
EOD;

        $tcpdf->writeHTML($html, true, false, false, false, '');


//        兴趣爱好
        $html = <<<EOD
<table border="0" style="padding: 2px 10px 2px 10px;" >
    <tr>
        <td><img src="https://qn.hbqingze.com/cab41202008251733231017.png" width="750" style="" /></td>
    </tr>
    <tr>
        <td>本人性格开朗、稳重、有活力，待人热情、真诚。有很强的专业的职业道德，专业基础知识扎实。工作认真负责，主动承担责任，积极与周围工作环境建立良好的工作关系，并具有一定的资源协调能力。与同事，其它部门各极配合，有较强的组织能力、实际动手能力和团体协作精神。</td>
    </tr>
</table>
EOD;

        $tcpdf->writeHTML($html, true, false, false, false, '');


//        项目经验
        $html = <<<EOD
<table border="0" style="padding: 2px 10px 2px 10px;" >
    <tr>
        <td><img src="https://qn.hbqingze.com/00c9a202008251742471980.png" width="750" style="" /></td>
    </tr>
    <tr>
        <td>本人性格开朗、稳重、有活力，待人热情、真诚。有很强的专业的职业道德，专业基础知识扎实。工作认真负责，主动承担责任，积极与周围工作环境建立良好的工作关系，并具有一定的资源协调能力。与同事，其它部门各极配合，有较强的组织能力、实际动手能力和团体协作精神。</td>
    </tr>
</table>
EOD;

        $tcpdf->writeHTML($html, true, false, false, false, '');


//        自我评价
        $html = <<<EOD
<table border="0" style="padding: 2px 10px 2px 10px;" >
    <tr>
        <td><img src="https://qn.hbqingze.com/7fc62202008251747512631.png" width="750" style="" /></td>
    </tr>
    <tr>
        <td>本人性格开朗、稳重、有活力，待人热情、真诚。有很强的专业的职业道德，专业基础知识扎实。工作认真负责，主动承担责任，积极与周围工作环境建立良好的工作关系，并具有一定的资源协调能力。与同事，其它部门各极配合，有较强的组织能力、实际动手能力和团体协作精神。</td>
    </tr>
</table>
EOD;

        $tcpdf->writeHTML($html, true, false, false, false, '');


        //        自我评价
        $html = <<<EOD
<table border="0" style="padding: 2px 10px 2px 10px;" >
    <tr>
        <td><img src="https://qn.hbqingze.com/7fc62202008251747512631.png" width="750" style="" /></td>
    </tr>
    <tr>
        <td>本人性格开朗、稳重、有活力，待人热情、真诚。有很强的专业的职业道德，专业基础知识扎实。工作认真负责，主动承担责任，积极与周围工作环境建立良好的工作关系，并具有一定的资源协调能力。与同事，其它部门各极配合，有较强的组织能力、实际动手能力和团体协作精神。</td>
    </tr>
</table>
EOD;

        $tcpdf->writeHTML($html, true, false, false, false, '');

        //        自我评价
        $html = <<<EOD
<table border="0" style="padding: 2px 10px 2px 10px;" >
    <tr>
        <td><img src="https://qn.hbqingze.com/7fc62202008251747512631.png" width="750" style="" /></td>
    </tr>
    <tr>
        <td>本人性格开朗、稳重、有活力，待人热情、真诚。有很强的专业的职业道德，专业基础知识扎实。工作认真负责，主动承担责任，积极与周围工作环境建立良好的工作关系，并具有一定的资源协调能力。与同事，其它部门各极配合，有较强的组织能力、实际动手能力和团体协作精神。</td>
    </tr>
</table>
EOD;

        $tcpdf->writeHTML($html, true, false, false, false, '');


        //        自我评价
        $html = <<<EOD
<table border="0" style="padding: 2px 10px 2px 10px;" >
    <tr>
        <td><img src="https://qn.hbqingze.com/7fc62202008251747512631.png" width="750" style="" /></td>
    </tr>
    <tr>
        <td>本人性格开朗、稳重、有活力，待人热情、真诚。有很强的专业的职业道德，专业基础知识扎实。工作认真负责，主动承担责任，积极与周围工作环境建立良好的工作关系，并具有一定的资源协调能力。与同事，其它部门各极配合，有较强的组织能力、实际动手能力和团体协作精神。</td>
    </tr>
</table>
EOD;

        $tcpdf->writeHTML($html, true, false, false, false, '');


        //        自我评价
        $html = <<<EOD
<table border="0" style="padding: 2px 10px 2px 10px;" >
    <tr>
        <td><img src="https://qn.hbqingze.com/7fc62202008251747512631.png" width="750" style="" /></td>
    </tr>
    <tr>
        <td>本人性格开朗、稳重、有活力，待人热情、真诚。有很强的专业的职业道德，专业基础知识扎实。工作认真负责，主动承担责任，积极与周围工作环境建立良好的工作关系，并具有一定的资源协调能力。与同事，其它部门各极配合，有较强的组织能力、实际动手能力和团体协作精神。</td>
    </tr>
</table>
EOD;

        $tcpdf->writeHTML($html, true, false, false, false, '');

//        自我评价
        $html = <<<EOD
<table border="0" style="padding: 2px 10px 2px 10px;" >
    <tr>
        <td><img src="https://qn.hbqingze.com/7fc62202008251747512631.png" width="750" style="" /></td>
    </tr>
    <tr>
        <td>本人性格开朗、稳重、有活力，待人热情、真诚。有很强的专业的职业道德，专业基础知识扎实。工作认真负责，主动承担责任，积极与周围工作环境建立良好的工作关系，并具有一定的资源协调能力。与同事，其它部门各极配合，有较强的组织能力、实际动手能力和团体协作精神。</td>
    </tr>
</table>
EOD;

        $tcpdf->writeHTML($html, true, false, false, false, '');

        //        自我评价
        $html = <<<EOD
<table border="0" style="padding: 2px 10px 2px 10px;" >
    <tr>
        <td><img src="https://qn.hbqingze.com/7fc62202008251747512631.png" width="750" style="" /></td>
    </tr>
    <tr>
        <td>本人性格开朗、稳重、有活力，待人热情、真诚。有很强的专业的职业道德，专业基础知识扎实。工作认真负责，主动承担责任，积极与周围工作环境建立良好的工作关系，并具有一定的资源协调能力。与同事，其它部门各极配合，有较强的组织能力、实际动手能力和团体协作精神。</td>
    </tr>
</table>
EOD;

        $tcpdf->writeHTML($html, true, false, false, false, '');

        //        自我评价
        $html = <<<EOD
<table border="0" style="padding: 2px 10px 2px 10px;" >
    <tr>
        <td><img src="https://qn.hbqingze.com/7fc62202008251747512631.png" width="750" style="" /></td>
    </tr>
    <tr>
        <td>本人性格开朗、稳重、有活力，待人热情、真诚。有很强的专业的职业道德，专业基础知识扎实。工作认真负责，主动承担责任，积极与周围工作环境建立良好的工作关系，并具有一定的资源协调能力。与同事，其它部门各极配合，有较强的组织能力、实际动手能力和团体协作精神。</td>
    </tr>
</table>
EOD;

        $tcpdf->writeHTML($html, true, false, false, false, '');


        //        自我评价
        $html = <<<EOD
<table border="0" style="padding: 2px 10px 2px 10px;" >
    <tr>
        <td><img src="https://qn.hbqingze.com/7fc62202008251747512631.png" width="750" style="" /></td>
    </tr>
    <tr>
        <td>本人性格开朗、稳重、有活力，待人热情、真诚。有很强的专业的职业道德，专业基础知识扎实。工作认真负责，主动承担责任，积极与周围工作环境建立良好的工作关系，并具有一定的资源协调能力。与同事，其它部门各极配合，有较强的组织能力、实际动手能力和团体协作精神。</td>
    </tr>
</table>
EOD;

        $tcpdf->writeHTML($html, true, false, false, false, '');


        //        自我评价
        $html = <<<EOD
<table border="0" style="padding: 2px 10px 2px 10px;" >
    <tr>
        <td><img src="https://qn.hbqingze.com/7fc62202008251747512631.png" width="750" style="" /></td>
    </tr>
    <tr>
        <td>本人性格开朗、稳重、有活力，待人热情、真诚。有很强的专业的职业道德，专业基础知识扎实。工作认真负责，主动承担责任，积极与周围工作环境建立良好的工作关系，并具有一定的资源协调能力。与同事，其它部门各极配合，有较强的组织能力、实际动手能力和团体协作精神。</td>
    </tr>
</table>
EOD;

        $tcpdf->writeHTML($html, true, false, false, false, '');

//        自我评价
        $html = <<<EOD
<table border="0" style="padding: 2px 10px 2px 10px;" >
    <tr>
        <td><img src="https://qn.hbqingze.com/7fc62202008251747512631.png" width="750" style="" /></td>
    </tr>
    <tr>
        <td>本人性格开朗、稳重、有活力，待人热情、真诚。有很强的专业的职业道德，专业基础知识扎实。工作认真负责，主动承担责任，积极与周围工作环境建立良好的工作关系，并具有一定的资源协调能力。与同事，其它部门各极配合，有较强的组织能力、实际动手能力和团体协作精神。</td>
    </tr>
</table>
EOD;

        $tcpdf->writeHTML($html, true, false, false, false, '');


        $tcpdf_name = $application_name . '.pdf';
        $tcpdf->Output($tcpdf_name, 'I');
        exit();

    }


}
