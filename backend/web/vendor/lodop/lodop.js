var CreatedOKLodop7766 = null, CLodopIsLocal;

//====判断是否需要 Web打印服务CLodop:===
//===(不支持插件的浏览器版本需要用它)===
function needCLodop() {
    try {
        var ua = navigator.userAgent;
        if (ua.match(/Windows\sPhone/i))
            return true;
        if (ua.match(/iPhone|iPod|iPad/i))
            return true;
        if (ua.match(/Android/i))
            return true;
        if (ua.match(/Edge\D?\d+/i))
            return true;

        var verTrident = ua.match(/Trident\D?\d+/i);
        var verIE = ua.match(/MSIE\D?\d+/i);
        var verOPR = ua.match(/OPR\D?\d+/i);
        var verFF = ua.match(/Firefox\D?\d+/i);
        var x64 = ua.match(/x64/i);
        if ((!verTrident) && (!verIE) && (x64))
            return true;
        else if (verFF) {
            verFF = verFF[0].match(/\d+/);
            if ((verFF[0] >= 41) || (x64))
                return true;
        } else if (verOPR) {
            verOPR = verOPR[0].match(/\d+/);
            if (verOPR[0] >= 32)
                return true;
        } else if ((!verTrident) && (!verIE)) {
            var verChrome = ua.match(/Chrome\D?\d+/i);
            if (verChrome) {
                verChrome = verChrome[0].match(/\d+/);
                if (verChrome[0] >= 41)
                    return true;
            }
        }
        return false;
    } catch (err) {
        return true;
    }
}

//====页面引用CLodop云打印必须的JS文件,用双端口(8000和18000）避免其中某个被占用：====
if (needCLodop()) {
    var src1 = "http://localhost:8000/CLodopfuncs.js?priority=1";
    var src2 = "http://localhost:18000/CLodopfuncs.js?priority=0";
    var head = document.head || document.getElementsByTagName("head")[0] || document.documentElement;
    var oscript = document.createElement("script");
    oscript.src = src1;
    head.insertBefore(oscript, head.firstChild);
    oscript = document.createElement("script");
    oscript.src = src2;
    head.insertBefore(oscript, head.firstChild);
    CLodopIsLocal = !!((src1 + src2).match(/\/\/localho|\/\/127.0.0./i));
}

//====获取LODOP对象的主过程：====
function getLodop(oOBJECT, oEMBED) {

    var strHtmInstall = "<br><font color='#FF00FF'>打印控件未安装!点击这里<a href='http://www.lodop.net/download/Lodop6.226_Clodop3.083.zip' target='view_window'>执行安装,安装后请刷新页面或重新进入。";
    var strHtmUpdate = "<br><font color='#FF00FF'>打印控件需要升级!点击这里<a href='http://www.lodop.net/download/Lodop6.226_Clodop3.083.zip' target='view_window'>执行升级,升级后请重新进入。";
    var strHtm64_Install = "<br><font color='#FF00FF'>打印控件未安装!点击这里<a href='http://www.lodop.net/download/Lodop6.226_Clodop3.083.zip' target='view_window'>执行安装,安装后请刷新页面或重新进入。";
    var strHtm64_Update = "<br><font color='#FF00FF'>打印控件需要升级!点击这里<a href='http://www.lodop.net/download/Lodop6.226_Clodop3.083.zip' target='view_window'>执行升级,升级后请重新进入。";
    var strHtmFireFox = "<br><br><font color='#FF00FF'>（注意：如曾安装过Lodop旧版附件npActiveXPLugin,请在【工具】->【附加组件】->【扩展】中先卸它）";
    var strHtmChrome = "<br><br><font color='#FF00FF'>(如果此前正常，仅因浏览器升级或重安装而出问题，需重新执行以上安装）";
    var strCLodopInstall_1 = "<br><font color='#FF00FF'>Web打印服务CLodop未安装启动，点击这里<a href='http://www.lodop.net/download/Lodop6.226_Clodop3.083.zip' target='view_window'>下载执行安装";
    var strCLodopInstall_2 = "<br>（若此前已安装过，可<a href='CLodop.protocol:setup' target='_self'>点这里直接再次启动）";
    var strCLodopInstall_3 = "，成功后请刷新本页面。";
    var strCLodopUpdate = "<br><font color='#FF00FF'>Web打印服务CLodop需升级!点击这里<a href='http://www.lodop.net/download/Lodop6.226_Clodop3.083.zip' target='view_window'>执行升级,升级后请刷新页面。";
    var LODOP;
    try {
        var ua = navigator.userAgent;
        var isIE = !!(ua.match(/MSIE/i)) || !!(ua.match(/Trident/i));
        if (needCLodop()) {
            try {
                LODOP = getCLodop();
            } catch (err) {
            }
            if (!LODOP && document.readyState !== "complete") {
                alert("网页还没下载完毕，请稍等一下再操作.");
                return;
            }
            if (!LODOP) {
                // document.body.innerHTML = strCLodopInstall_1 + (CLodopIsLocal ? strCLodopInstall_2 : "") + strCLodopInstall_3 + document.body.innerHTML;
                alert(strCLodopInstall_1 + (CLodopIsLocal ? strCLodopInstall_2 : "") + strCLodopInstall_3, '', 'error');
                return;
            } else {
                if (CLODOP.CVERSION < "3.0.8.3") {
                    // document.body.innerHTML = strCLodopUpdate + document.body.innerHTML;
                    alert(strCLodopUpdate, '', 'error');
                }
                if (oEMBED && oEMBED.parentNode)
                    oEMBED.parentNode.removeChild(oEMBED);
                if (oOBJECT && oOBJECT.parentNode)
                    oOBJECT.parentNode.removeChild(oOBJECT);
            }
        } else {
            var is64IE = isIE && !!(ua.match(/x64/i));
            //=====如果页面有Lodop就直接使用，没有则新建:==========
            if (oOBJECT || oEMBED) {
                if (isIE)
                    LODOP = oOBJECT;
                else
                    LODOP = oEMBED;
            } else if (!CreatedOKLodop7766) {
                LODOP = document.createElement("object");
                LODOP.setAttribute("width", 0);
                LODOP.setAttribute("height", 0);
                LODOP.setAttribute("style", "position:absolute;left:0px;top:-100px;width:0px;height:0px;");
                if (isIE)
                    LODOP.setAttribute("classid", "clsid:2105C259-1E0C-4534-8141-A753534CB4CA");
                else
                    LODOP.setAttribute("type", "application/x-print-lodop");
                document.documentElement.appendChild(LODOP);
                CreatedOKLodop7766 = LODOP;
            } else
                LODOP = CreatedOKLodop7766;
            //=====Lodop插件未安装时提示下载地址:==========
            if ((!LODOP) || (!LODOP.VERSION)) {
                if (ua.indexOf('Chrome') >= 0)
                    alert(strHtmChrome, '', 'error');
                <!--                    document.body.innerHTML = strHtmChrome + document.body.innerHTML;-->
                if (ua.indexOf('Firefox') >= 0)
                    document.body.innerHTML = strHtmFireFox + document.body.innerHTML;
                <!--                document.body.innerHTML = (is64IE ? strHtm64_Install : strHtmInstall) + document.body.innerHTML;-->
                alert(is64IE ? strHtm64_Install : strHtmInstall, '', 'error');
                return LODOP;
            }
        }
        if (LODOP.VERSION < "6.2.2.6") {
            if (!needCLodop())
            <!--                document.body.innerHTML = (is64IE ? strHtm64_Update : strHtmUpdate) + document.body.innerHTML;-->
                alert(is64IE ? strHtm64_Update : strHtmUpdate, '', 'error');
        }
        //===如下空白位置适合调用统一功能(如注册语句、语言选择等):==

        //=======================================================
        return LODOP;
    } catch (err) {
        alert("getLodop出错:" + err);
    }

}

var LODOP; //声明为全局变量

function myPRINT(strFormHtml) {
    LODOP = getLodop();
    LODOP.SET_LICENSES("", "66A455444726B1BE257D9507DCE6A934", "C94CEE276DB2187AE6B65D56B3FC2848", "7B141F2E464B662C45D4E9965B5475F0");
    LODOP.SET_PRINT_STYLEA(0, 'Horient', 2);
    LODOP.SET_PRINTER_INDEX(-1);
    LODOP.ADD_PRINT_HTM('4mm', 3, '100%', '100%', strFormHtml);
    LODOP.PRINT('配送订单打印');
}

// function orderDetailPrint(orderDetail) {
//
//     let purchaserShopName = orderDetail.contact_name;
//     let purchaserShopPhone = orderDetail.contact_phone;
//     let purchaserAddress = orderDetail.district_name + ' ' + orderDetail.town_name + ' ' + orderDetail.village_name;
//     let purchaserDetailAddress = orderDetail.detail_address;
//     let supplierShopName = orderDetail.shop_name;
//     let supplierPhoneNo = orderDetail.shop_phone;
//     let orderDetailId = orderDetail.order_detail_id;
//     let createDatetime = orderDetail.create_datetime;
//     let money = orderDetail.money;
//
//     const MARGIN_LEFT = '3mm';
//     const MARGIN_RIGHT = 'RightMargin:2mm';
//     const MARGIN_BOTTOM = 'BottomMargin:2mm';
//     const LARGE_TEXT_HEIGHT = 4;
//     const LINE_SPACE = 2;
//
//     let Y_AXIS = 3;
//     LODOP.PRINT_INIT(orderDetailId);
//
//     LODOP.SET_PRINT_STYLE("FontSize", 16);
//
//     LODOP.ADD_PRINT_TEXT(Y_AXIS + 'mm', MARGIN_LEFT, MARGIN_RIGHT, LARGE_TEXT_HEIGHT + 'mm', purchaserShopName + ' ' + purchaserShopPhone);
//
//     LODOP.SET_PRINT_STYLE("FontSize", 12);
//
//     Y_AXIS += LARGE_TEXT_HEIGHT + LINE_SPACE;
//     LODOP.ADD_PRINT_TEXT(Y_AXIS + 'mm', MARGIN_LEFT, MARGIN_RIGHT, LARGE_TEXT_HEIGHT + 'mm', purchaserAddress);
//
//     Y_AXIS += LARGE_TEXT_HEIGHT + LINE_SPACE;
//     LODOP.ADD_PRINT_TEXT(Y_AXIS + 'mm', MARGIN_LEFT, MARGIN_RIGHT, LARGE_TEXT_HEIGHT + 'mm', purchaserDetailAddress);
//
//     Y_AXIS += LARGE_TEXT_HEIGHT + LINE_SPACE;
//     LODOP.ADD_PRINT_TEXT(Y_AXIS + 'mm', MARGIN_LEFT, MARGIN_RIGHT, LARGE_TEXT_HEIGHT + 'mm', orderDetail.goods_count + ' X ' + orderDetail.goods_unit + ':' + orderDetail.goods_name);
//
//     Y_AXIS += LARGE_TEXT_HEIGHT + LINE_SPACE + LARGE_TEXT_HEIGHT;
//     LODOP.ADD_PRINT_BARCODE(100, MARGIN_LEFT, 100, 40, "128B", orderDetailId);
//
//     Y_AXIS += LARGE_TEXT_HEIGHT + LINE_SPACE + 2;
//     LODOP.ADD_PRINT_TEXT(Y_AXIS + 'mm', MARGIN_LEFT, MARGIN_RIGHT, LARGE_TEXT_HEIGHT + 'mm', supplierShopName + ' ' + supplierPhoneNo);
//
//     Y_AXIS += LARGE_TEXT_HEIGHT + LINE_SPACE;
//     LODOP.ADD_PRINT_TEXT(Y_AXIS + 'mm', MARGIN_LEFT, MARGIN_RIGHT, LARGE_TEXT_HEIGHT + 'mm', createDatetime);
//     LODOP.PRINT();
//
// }

function orderDetailPrint(orderDetail) {

    let purchaserShopName = orderDetail.contact_name;
    let purchaserShopPhone = orderDetail.contact_phone;
    let purchaserAddress = orderDetail.district_name + ' ' + orderDetail.town_name + ' ' + orderDetail.village_name;
    let purchaserDetailAddress = orderDetail.detail_address;
    let supplierShopName = orderDetail.shop_name;
    let supplierPhoneNo = orderDetail.shop_phone;
    let orderDetailId = orderDetail.order_detail_id;
    let createDatetime = orderDetail.create_datetime;
    let money = orderDetail.money;

    const MARGIN_LEFT = '3mm';
    const MARGIN_RIGHT = 'RightMargin:2mm';
    const MARGIN_BOTTOM = 'BottomMargin:2mm';
    const LARGE_TEXT_HEIGHT = 4;
    const LINE_SPACE = 2;

    let Y_AXIS = 3;
    LODOP.PRINT_INIT(orderDetailId);

    LODOP.SET_PRINT_STYLE("FontSize", 18);

    LODOP.ADD_PRINT_TEXT(Y_AXIS + 'mm', MARGIN_LEFT, MARGIN_RIGHT, LARGE_TEXT_HEIGHT + 'mm', purchaserShopName + ' ' + purchaserShopPhone);

    LODOP.SET_PRINT_STYLE("FontSize", 12);

    Y_AXIS += LARGE_TEXT_HEIGHT + LINE_SPACE + 1;
    LODOP.ADD_PRINT_TEXT(Y_AXIS + 'mm', MARGIN_LEFT, MARGIN_RIGHT, LARGE_TEXT_HEIGHT + 'mm', purchaserAddress);

    Y_AXIS += LARGE_TEXT_HEIGHT + LINE_SPACE;
    LODOP.ADD_PRINT_TEXT(Y_AXIS + 'mm', MARGIN_LEFT, MARGIN_RIGHT, LARGE_TEXT_HEIGHT + 'mm', purchaserDetailAddress);

    LODOP.SET_PRINT_STYLE("FontSize", 18);

    Y_AXIS += LARGE_TEXT_HEIGHT + LINE_SPACE;
    LODOP.ADD_PRINT_TEXT(Y_AXIS + 'mm', MARGIN_LEFT, MARGIN_RIGHT, LARGE_TEXT_HEIGHT + 'mm', orderDetail.goods_count + ' X ' + orderDetail.goods_unit + ':' + orderDetail.goods_name);

    Y_AXIS += LARGE_TEXT_HEIGHT + LINE_SPACE  + 1;

    LODOP.ADD_PRINT_TEXT(Y_AXIS + 'mm', MARGIN_LEFT, MARGIN_RIGHT, LARGE_TEXT_HEIGHT + 'mm', '订单总金额：' + money);

    LODOP.SET_PRINT_STYLE("FontSize", 12);

    Y_AXIS += LARGE_TEXT_HEIGHT + LINE_SPACE  + 1;
    LODOP.ADD_PRINT_TEXT(Y_AXIS + 'mm', MARGIN_LEFT, MARGIN_RIGHT, LARGE_TEXT_HEIGHT + 'mm', supplierShopName + ' ' + supplierPhoneNo);

    Y_AXIS += LARGE_TEXT_HEIGHT + LINE_SPACE;
    LODOP.ADD_PRINT_TEXT(Y_AXIS + 'mm', MARGIN_LEFT, MARGIN_RIGHT, LARGE_TEXT_HEIGHT + 'mm', createDatetime);
    LODOP.PRINT();

}
