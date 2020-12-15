var formatDuring = function (mss) {
    var days = parseInt(mss / (1000 * 60 * 60 * 24));
    var hours = parseInt((mss % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = parseInt((mss % (1000 * 60 * 60)) / (1000 * 60));
    return days + " 天 " + hours + " 小时 " + minutes + " 分钟 ";
};

var getFileExt = function (file) {
    var index1 = file.lastIndexOf(".");
    var index2 = file.length;
    return file.substring(index1 + 1, index2);
};

var getFile = function (filepath) {
    var index1 = filepath.lastIndexOf("/");
    var index2 = filepath.length;
    return filepath.substring(index1 + 1, index2);
};

var inArray = function (search, array) {
    for (var i in array) {
        if (array[i] == search) {
            return true;
        }
    }
    return false;
};

var arrayRemove = function (twoDimensionArray, key, value) {
    var newTwoDimensionArray = [];
    twoDimensionArray.forEach(function (single, index) {
        if (single[key] == value) {
        } else {
            newTwoDimensionArray.push(single);
        }
    });
    return newTwoDimensionArray;
};

var checkIsMatch = function (file, type) {
    var index1 = file.lastIndexOf(".");
    var index2 = file.length;
    var suffix = file.substring(index1 + 1, index2);
    var all = [];
    if (type == 'image') {
        all = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
    } else if (type == 'video') {
        all = ['avi', 'rmvb', 'mp4'];
    }
    return inArray(suffix, all);
};

var isMobile = {
    Android: function () {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function () {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function () {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function () {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function () {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function () {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

var addUrlParam = function (url, key, value) {
    var returnUrl = ''
    if (url.indexOf('?') == -1) {
        returnUrl += url + '?' + key + '=' + value
    } else {
        if (url.indexOf('?' + key + '=') == -1 && url.indexOf('&' + key + '=') == -1) {
            returnUrl += url + '&' + key + '=' + value
        } else {
            var isDone = false
            var startIndex = 0
            var endIndex = url.length - 1
            var parm = '?' + key + '='
            for (var i = 0; i < url.length; i++) {
                if (url.substr(i, parm.length) == parm) {
                    startIndex = i + parm.length
                    for (var j = startIndex; j < url.length; j++) {
                        if (url[j] == '&') {
                            endIndex = j
                            break
                        } else if (j == url.length - 1) {
                            endIndex = url.length
                        }
                    }
                    isDone = true
                    break
                }
            }
            if (!isDone) {
                parm = '&' + key + '='
                for (var i = 0; i < url.length; i++) {
                    if (url.substr(i, parm.length) == parm) {
                        startIndex = i + parm.length
                        for (var j = startIndex; j < url.length; j++) {
                            if (url[j] == '&') {
                                endIndex = j
                                break
                            } else if (j == url.length - 1) {
                                endIndex = url.length
                            }
                        }
                        break
                    }
                }
            }
            var parmKeyValue = parm + url.substring(startIndex, endIndex)
            returnUrl = url.replace(parmKeyValue, parm + value)
        }
    }
    return returnUrl
};

NProgress.start();
setTimeout(function () {
    NProgress.done();
}, Math.ceil(Math.random() * 1000));

$("img").on("error", function () {
    $(this).attr("src", "/images/404.jpg");
});

var ajaxLoading = '';

$(document).ajaxStart(function () {
    ajaxLoading = layer.load(0);
});

$(document).ajaxSuccess(function (event, xhr, options) {
    layer.close(ajaxLoading);
});

$(document).ajaxError(function (event, xhr, options, exc) {
    layer.close(ajaxLoading);
    if (options.url.indexOf("/treemanager/node/manage") === -1) {
        bootbox.alert({size: 'middle', title: '提示', message: '操作失败'});
    }
});

$(document).ready(function () {

    yii.confirm = function (message, ok, cancel) {
        bootbox.confirm({
            title: '提示',
            size: 'middle',
            message: message,
            buttons: {
                confirm: {label: '确定', className: 'btn-primary'},
                cancel: {label: '取消', className: 'btn-default'}
            },
            callback: function (confirmed) {
                if (confirmed) {
                    !ok || ok();
                } else {
                    !cancel || cancel();
                }
            }
        });
        return false;
    };

    $('#logoutFormButton').on('click', function () {
        bootbox.confirm({
            title: '提示',
            size: 'middle',
            message: '确认退出登录吗？',
            buttons: {
                confirm: {label: '确定', className: 'btn-primary'},
                cancel: {label: '取消', className: 'btn-default'}
            },
            callback: function (result) {
                if (result) {
                    $('#logoutForm').submit();
                }
            }
        });
    });

    $('.detailModalButton').on('click', function (e) {
        e.preventDefault();
        var that = this;
        var index = layer.open({
            type: 2,
            title: $(that).attr('title') ? $(that).attr('title') : $(that).text(),
            shadeClose: false,
            maxmin: true,
            shade: 0.8,
            area: ['90%', '90%'],
            content: $(that).attr('href'),
            end: function () {
            }
        });
    });

    $('.searchFormSwitch').on('click', function () {
        $('.searchForm').toggle();
    });

    $('table thead input[type="checkbox"]').click(function (e) {
        var that = this;
        if ($(that).is(':checked')) {
            $(that).parent().parent().addClass('info');
            $(that).parent().parent().parent().parent().find('tbody').find('tr').each(function () {
                $(this).addClass('info');
            });
        } else {
            $(that).parent().parent().removeClass('info');
            $(that).parent().parent().parent().parent().find('tbody').find('tr').each(function () {
                $(this).removeClass('info');
            });
        }
    });

    $('table tbody input[type="checkbox"]').click(function (e) {
        if ($(this).is(':checked')) {
            $(this).parent().parent().addClass('info');
        } else {
            $(this).parent().parent().removeClass('info');
        }
    });

    if(!isMobile.any()) {

        var tableColumnListHtml = '';
        $('div.table-responsive table thead tr th').each(function (index) {
            if (index > 0 && index < $('table thead tr th').length - 1) {
                tableColumnListHtml += '<li style="padding: 7px 10px;"><input type="checkbox" checked="checked" class="tableColumnCheckbox" name="tableColumn[]" value="' + index + '" > ';
                tableColumnListHtml += $.trim($(this).text());
                tableColumnListHtml += '</li>';
            }
        });

        $('.searchFormSwitch').after('<div class="btn-group" style="margin-bottom: 5px;"><a class="btn btn-primary dropdown-toggle" data-toggle="dropdown">显示隐藏字段 <span class="caret"></span></a><ul class="dropdown-menu">' + tableColumnListHtml + '</ul></div>');

        $('.tableColumnCheckbox').click(function (e) {
            var that = this;
            if ($(that).is(':checked')) {
                $('div.table-responsive table tr').find('th:eq(' + $(that).val() + ')').show();
                $('div.table-responsive tbody tr').find('td:eq(' + $(that).val() + ')').show();
            } else {
                $('div.table-responsive table tr').find('th:eq(' + $(that).val() + ')').hide();
                $('div.table-responsive tbody tr').find('td:eq(' + $(that).val() + ')').hide();
            }
        });
    }

});
