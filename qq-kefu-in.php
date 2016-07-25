<?php
define(QQ_KEFU_VERSION_PLUGIN, '1.6.0', true);
$plugin_url = WP_PLUGIN_URL . "/" . dirname(plugin_basename(__FILE__));

/**
 * 设置配置项
 * @param unknown_type $option_name
 * @param unknown_type $option_value
 */
function QQKefu_set_option($option_name, $option_value) {
	$QQKefu_options = get_option('QQKefu_options');
	$QQKefu_options [$option_name] = $option_value;
	update_option('QQKefu_options', $QQKefu_options);
}

/**
 * 获取配置项
 * @param unknown_type $option_name
 * @param unknown_type $option_value
 */
function QQKefu_get_option($option_name) {
	$QQKefu_options = get_option('QQKefu_options');
	if (!$QQKefu_options || !array_key_exists($option_name, $QQKefu_options)) {
		$QQKefu_default_options = array();
		$QQKefu_default_options ["pos"] = "right";
		$QQKefu_default_options ["telNo"] = "客服电话";
		$QQKefu_default_options ["enbleNavlog"] = true;
		$QQKefu_default_options ["qq"] = "";
		$QQKefu_default_options ["wangwang"] = "";
		$QQKefu_default_options ["skype"] = "";
		$QQKefu_default_options ["wangwangInter"] = "";
		$QQKefu_default_options ["wangwangInterTitles"] = "";
		$QQKefu_default_options ["enableIndex"] = true;
		$QQKefu_default_options ["enableSingle"] = true;
		$QQKefu_default_options ["enableBigIcoShow"] = false;
		$QQKefu_default_options ["icoSize"] = 1;
		$QQKefu_default_options ["icoSizeWang"] = 1;
		$QQKefu_default_options ["qqTitle"] = "";

		$QQKefu_default_options ["qqtop"] = "20";
		$QQKefu_default_options ['enable'] = true;
		add_option('QQKefu_options', $QQKefu_default_options, 'Settings for QQ Kefu plugin');
		$result = $QQKefu_options[$option_name];
	} else {
		$result = $QQKefu_options[$option_name];
	}
	return $result;
}

/**
 * 管理菜单
 */
function QQKefuAdmin() {
	if (function_exists('add_options_page')) {
		add_options_page('QQ Kefu Install', 'QQ客服设置', 8, basename(__FILE__), 'QQKefu_options');
	}
}

/**
 * 管理表单提交处理
 */
function QQKefu_options() {
	$submit = trim($_POST ['Submit']);
	if ($submit) {

		if (isset ($_POST ['enable'])) {
			QQKefu_set_option('enable', true);
		} else {
			QQKefu_set_option('enable', false);
		}

		QQKefu_set_option('enbleNavlog', isset ($_POST ['enbleNavlog']) ? true : false);

		if (isset ($_POST ['enableIndex'])) {
			QQKefu_set_option('enableIndex', true);
		} else {
			QQKefu_set_option('enableIndex', false);
		}
		if (isset ($_POST ['enableBigIcoShow'])) {
			QQKefu_set_option('enableBigIcoShow', true);
		} else {
			QQKefu_set_option('enableBigIcoShow', false);
		}

		if (isset ($_POST ['enableSingle'])) {
			QQKefu_set_option('enableSingle', true);
		} else {
			QQKefu_set_option('enableSingle', false);
		}

		if (isset ($_POST ['telNo'])) {
			QQKefu_set_option('telNo', $_POST ['telNo']);
		}

		$qqs2 = $_POST [qq];
		if (isset ($_POST [qq])) {
			QQKefu_set_option('qq', $_POST [qq]);

		} else {
			QQKefu_set_option('qq', "");
		}

		QQKefu_set_option('skype', isset ($_POST [skype]) ? $_POST [skype] : "");

		if (isset ($_POST [wangwang])) {
			QQKefu_set_option('wangwang', $_POST [wangwang]);
		} else {
			QQKefu_set_option('wangwang', "");
		}

		if (isset ($_POST [wangwangInter])) {
			QQKefu_set_option('wangwangInter', $_POST [wangwangInter]);
		} else {
			QQKefu_set_option('wangwangInter', "");
		}


		if (isset ($_POST ['icoSize'])) {
			QQKefu_set_option('icoSize', $_POST ['icoSize']);
		}

		if (isset ($_POST ['icoSizeWang'])) {
			QQKefu_set_option('icoSizeWang', $_POST ['icoSizeWang']);
		}

		if (isset ($_POST ['pos'])) {
			QQKefu_set_option('pos', $_POST ['pos']);
		}

		if (isset ($_POST [qqTitle])) {
			QQKefu_set_option('qqTitle', $_POST [qqTitle]);
		}

		if (isset ($_POST ['qqTitle2'])) {
			QQKefu_set_option('qqTitle2', $_POST ['qqTitle2']);
		}

		if (isset ($_POST [wangwangInterTitles])) {
			QQKefu_set_option('wangwangInterTitles', $_POST [wangwangInterTitles]);
		}


		if (isset ($_POST ['qq3'])) {
			QQKefu_set_option('qq3', $_POST ['qq3']);
		}

		if (isset ($_POST ['qqtop'])) {
			QQKefu_set_option('qqtop', $_POST ['qqtop']);
		}
	} else {
		QQKefu_get_option('container');
	}
	QQKefu_admin_html(get_option('QQKefu_options'));
}

/**
 * 输出提示信息
 * @param {String} $msg 提示信息
 */
function QQKefu_Tip($msg) {
	return '<div class="updated"><p><strong>' . $msg . '</strong></p></div>';
}

function getSectionPre($title) {
	return '<div class="qqkefu_section">
<div class="rm_title"><h3><img src="' . plugins_url("qq-kefu/images/clear.png") . '" class="inactive" alt="">' . $title . '</h3><div class="clearfix"></div></div><div class="rm_options" style="display: none; ">';
}

function getSectionSuf() {
	return '</div></div>';
}

/**
 * 输出错误提示信息
 * @param {String} $msg 提示信息
 */
function QQKefu_error($msg) {
	return '<div class="error settings-error"><p><strong>' . $msg . '</strong></p></div>';
}

function showRss() {
	echo '<div id="updateInfoDiv" style="display:none">';
	wp_widget_rss_output('http://www.ij2ee.com/tag/qq%E6%97%BA%E6%97%BA%E5%AE%A2%E6%9C%8D%E6%8F%92%E4%BB%B6/feed', array('show_author' => 0, 'items' => 5, 'show_date' => 1, 'show_summary' => 0));
	echo "</div>";
}

/**
 * 输出设置页HTMl
 * @param {Array} $options 配置项信息
 */
function QQKefu_admin_html($options) {
	$enable = $options ['enable'] ? ' checked="true"' : '';
	$enbleNavlog = $options ['enbleNavlog'] ? ' checked="true"' : '';
	$enableIndex = $options ['enableIndex'] ? ' checked="true"' : '';
	$enableSingle = $options ['enableSingle'] ? ' checked="true"' : '';
	$enableBigIcoShowTxt = $options ['enableBigIcoShow'] ? ' checked="true"' : '';
	$adminHtml = '<link rel="stylesheet" href="' . plugins_url('qq-kefu/qqkefu.css') . '" type="text/css" media="screen" />';
	$adminHtml .= '<script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.7/jquery.min.js"></script>';
	$adminHtml .= '<div class=wrap id="qqAdmin" style="background-color:white;margin: 0 15px 0 0;">';

	$adminHtml .= '<div style="background:orange">';
	$adminHtml .= '<div id="updateInfo" style="cursor:pointer">查看此次版本跟新增加功能:</div>';
	showRss();
	$adminHtml .= '</div><div>';
	$adminHtml .= '<form method="post">';
	$adminHtml .= getSectionPre('基本设置');
	$adminHtml .= '<p>显示QQ客服: <input type="checkbox" value="true" id="Enable_QQ" name="enable"' . $enable . '></p>';

	$adminHtml .= '<p>是否缩进客服框: <input type="checkbox" value="true" id="enbleNavlog" name="enbleNavlog"' . $enbleNavlog . '><span class="dtl">(如果勾上,则页面只露一个客服头像,移上去后就会伸缩对话框)</span></p>';

	$bsize = $options['pos'];
	$options['pos'] == "1" ? $left = "checked" : $right = "checked";

	$adminHtml .= '<p>高度:&nbsp;&nbsp;<input class="large-text code" id="QQ_top" style="width:26px" name="qqtop" value="' . stripslashes($options ['qqtop']) . '">% <span class="dtl">(如果您觉得默认值 20 还是不对的话,请按百分比微调)</span></p>';
	$adminHtml .= ' <p>显示位置: 左<input type="radio" name="pos" value="1" ' . $left . ' />  右:<input type="radio" name="pos" value="2" ' . $right . '/></p>';
	$adminHtml .= '面板显示范围: 首页<input type="checkbox" name="enableIndex" ' . $enableIndex . '>  内页<input type="checkbox" name="enableSingle" ' . $enableSingle . '>';
	$adminHtml .= '<p>客服电话:&nbsp;&nbsp;<input class="large-text code" id="QQ_1" style="width:126px" name="telNo" value="' . stripslashes($options ['telNo']) . '"></p>';
	$adminHtml .= getSectionSuf();
	$adminHtml .= getSectionPre('QQ客服设置');
	$qs = QQKefu_get_option('qq');
	$count1 = 0;
	$bsize = $options['icoSize'];
	$options['icoSize'] == "1" ? $sizeCk1 = "checked" : $sizeCk2 = "checked";
	$adminHtml .= '<p>图标大小:&nbsp;&nbsp;大图标:<input type="radio" name="icoSize" value="1" ' . $sizeCk1 . ' />&nbsp;&nbsp;&nbsp;&nbsp;小图标:<input type="radio" name="icoSize" value="2" ' . $sizeCk2 . '/></P> <P><input type="checkbox"  id="enableBigIcoShow" name="enableBigIcoShow" ' . $enableBigIcoShowTxt . '>是否实时显示大图标离线   <span class="dtl">(,因为有的时候会有延时,可能显示有差异,不打勾就一直显示在线)</span></p>';
	$adminHtml .= '<ul id="qqLi">';
	if (isset($qs) && !empty($qs)) {
		foreach ($qs as $q) {
			$adminHtml .= '<li>客服QQ' . $count1 . ' 标题<input name="qqTitle[]" value="' . stripslashes($options ['qqTitle'][$count1]) . '"> QQ号码<input class="large-text code" id="QQ_1" style="width:126px" name="qq[]"  value="' . stripslashes($options ['qq'][$count1]) . '"> <input type="button" value="删除此客服" class="btnDelQQ"></li>';
			$count1++;
		}
	}
	$adminHtml .= '</ul><input id="btnAddQQ" type="button" value="增加QQ客服">';
	$adminHtml .= getSectionSuf();
	//旺旺

	$adminHtml .= getSectionPre('旺旺客服设置');
	$wangwangs = QQKefu_get_option('wangwang');
	$count1 = 0;
	$options['icoSizeWang'] == "1" ? $sizeCkw = "checked" : $sizeCkw2 = "checked";
	$adminHtml .= '<p>图标大小:&nbsp;&nbsp;大图标:<input type="radio" name="icoSizeWang" value="1" ' . $sizeCkw . ' />&nbsp;&nbsp;&nbsp;&nbsp;小图标:<input type="radio" name="icoSizeWang" value="2" ' . $sizeCkw2 . '/><span class="dtl">(建议使用QQ小图标,这样比较匹配。)</span></p>';
	$adminHtml .= '<ul id="wangwangLi">';
	if (isset($wangwangs) && !empty($wangwangs)) {
		foreach ($wangwangs as $w) {
			$adminHtml .= '<li>客服旺旺' . $count1 . ' <input name="wangwang[]" value="' . stripslashes($w) . '">  <input type="button" value="删除此客服" class="btnDelQQ"></li>';
			$count1++;
		}
	}
	$adminHtml .= '</ul><input id="btnAddWang" type="button" value="增加旺旺客服">';
	$adminHtml .= getSectionSuf();
	//旺旺 ed

	//旺旺国际 st wangwangInter
	$adminHtml .= getSectionPre('国际旺旺客服设置');
	$wangwangInter = QQKefu_get_option('wangwangInter');
	$count1 = 0;
	$adminHtml .= '<ul id="wangwangInterLi">';
	if (isset($wangwangInter) && !empty($wangwangInter)) {

		$wangwangInterTitles = QQKefu_get_option('wangwangInterTitles');
		$wwiCounts = 0;
		foreach ($wangwangInter as $w) {
			$adminHtml .= '<li>客服旺旺' . $count1 . ' <input name="wangwangInter[]" value="' . stripslashes($w) . '">  客服名称:<input name="wangwangInterTitles[]" value="' . stripslashes($wangwangInterTitles[$wwiCounts]) . '">  <input type="button" value="删除此客服" class="btnDelQQ"></li>';
			$wwiCounts++;
		}
	}
	$adminHtml .= '</ul><input id="btnAddwangwangInter" type="button" value="增加国际旺旺客服">';
	$adminHtml .= getSectionSuf();

	//旺旺国际 ed
	$adminHtml .= getSectionPre("注意事项");
	$adminHtml .= '<ol>';
	$adminHtml .= '<li>如果出现“QQ未激活”则参考 <a href="http://jingyan.baidu.com/article/da1091fbc970d7027849d691.html" target="_blank">QQ未激活的解决方案</a>来激活下即可</li>';
	$adminHtml .= '<li>客服QQ 权限不要设置成 需要验证信息 否则点击客服QQ时会提示需要加好友才能对话</li>';
	$adminHtml .= '<li>如果出现首页重复出现对话框 请在后台设置里吧首页那个选项点掉</li>';
	$adminHtml .= '<li>极少部分主题不出现对话框的 可以在主题的footer.php里面加入 < ?php QQKefuInit(); ? > (问号和大于小于括号中间的空格去掉)</li>';
	$adminHtml .= '</ol>';
	$adminHtml .= getSectionSuf();
	//skype st


	//skype ed
	$adminHtml .= '<p><span  class="submit"><input type="submit" value="保存设置" name="Submit"></span></p>';
	$adminHtml .= '</div></fieldset>';
	$adminHtml .= '</form>';
	$adminHtml .= '';
	$adminHtml .= '<script src="' . plugins_url('qq-kefu/qqkefu.js') . '"></script>';
	echo $adminHtml;
}

function getQQHtml($q1, $qqTitle1, $index, $enableBigIcoShowFlag) {
	if (!empty($q1)) {
		if (empty($qqTitle1)) {
			$qqTitle1 = $q1;
		}
		$html = '<tr><td><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=' . $q1 . '&site=qq&menu=yes"><div class="kefu4" id="qqIco' . $index . '">';
		if ($enableBigIcoShowFlag) {
			$html .= ' <script>if(online[' . $index . ']==0){jQuery("#qqIco' . $index . '").addClass("kefu4gray")}</script>';

		}
		$html .= '</div></a></td></tr><tr><td><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=' . $q1 . '&site=qq&menu=yes"><div class="qqnum">' . $qqTitle1 . '</div></a></td></tr>';
		return $html;
	}
}

function getQQHtmlSmall($q1, $qqTitle1) {
	if (!empty($q1)) {
		if (empty($qqTitle1)) {
			$qqTitle1 = $q1;
		}
		return '<tr><td><div class="qqSmall"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=' . $q1 . '&site=qq&menu=yes"><img src="http://wpa.qq.com/pa?p=2:' . $q1 . ':45"  style="vertical-align:middle" > ' . $qqTitle1 . '</a></div></td></tr>';
	}
}

//$size  1大 2小
function getWangHtml($wang1, $size) {
	if (!empty($wang1)) {
		$wang = urlencode($wang1);
		if ($size == "1") {
			$wang1 = "";
		}
		return '<tr><td><div class="qqSmall"><a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=' . $wang . '&site=cntaobao&s=' . $size . '&charset=utf-8" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=' . $wang . '&site=cntaobao&s=' . $size . '&charset=utf-8" alt="点击这里给我发消息" style="vertical-align:middle" />' . $wang1 . '</a></div></td></tr>';
	}
}

//wangwangInter
function getWangwangInterHtml($wang1, $wangName) {
	if (!empty($wang1)) {
		return '<tr><td><div class="qqSmall" style="overflow:hidden"><a href=" http://amos.us.alitalk.alibaba.com/msg.aw?v=1&uid=' . $wang1 . '&site=' . $wang1 . '&s=2" ><img border="0" style="width:18px;height:18px" src="http://amos.us.alitalk.alibaba.com/online.aw?v=1&uid=' . $wang1 . '&site=' . $wang1 . '&s=2" style="vertical-align:middle;"/>' . $wangName . '</a></div></td></tr>';
	}
}

/**
 * 初始化QQ客服
 */
function QQKefuInit1() {
	$pos1 = QQKefu_get_option('pos') == "1" ? "left" : "right";
	$icoSize2 = QQKefu_get_option('icoSize');
	$qs = QQKefu_get_option('qq');
	$kefuHtml = "";

	if ($icoSize2 == "1") {
		$qqOnlineStr = "";
		if (!empty($qs)) {
			foreach ($qs as $q) {
				$qqOnlineStr .= $q;
				$qqOnlineStr .= ":";
			}
		}

		if (QQKefu_get_option('enableBigIcoShow')) {
			$kefuHtml .= '<script>var online= new Array();</script>';
			// Disable QQ online check as it returns 404 now
			// $kefuHtml .= '<script src="http://webpresence.qq.com/getonline?Type=1&' . $qqOnlineStr . '"></script>';
		}

	}
	$kefuHtml .= '<!-- QQ客服代码开始--><link rel="stylesheet" href="' . plugins_url('qq-kefu/qqkefu.css') . '" type="text/css" media="screen" />';
	$kefuHtml .= '<script>
	if (typeof jQuery == "undefined") {
		var script = document.createElement("script");
		script.setAttribute("src",
				"http://lib.sinaapp.com/js/jquery/1.7.2/jquery.min.js");
		document.getElementsByTagName("BODY")[0].appendChild(script);
	}
	</script>';

	$kefuHtml .= '<div id="divStayTopright" style="position:fixed;z-index:999999;top:' . QQKefu_get_option('qqtop') . '%;' . $pos1 . ':0px;height:16px;">';
	$panelRight = QQKefu_get_option('enbleNavlog') == "1" ? "-87" : "0";
	$isIn = QQKefu_get_option('enbleNavlog') == "1" ? "true" : "false";
	$kefuHtml .= '<div id="qqkefuDv" style="' . $pos1 . ':' . $panelRight . 'px;position:fixed;"><script>var isIn = ' . $isIn . ';var isLeft="' . $pos1 . '";</script>';
	if (QQKefu_get_option('enbleNavlog') == "1") {
		$kefuHtml .= '<table><tr>';
		if (QQKefu_get_option('pos') == "2") {
			$kefuHtml .= '<td id="navLog"><img src="' . plugins_url('qq-kefu/images/navLogo.gif') . '" id="imgNav"></td><td>';
		} else {
			$kefuHtml .= '<td>';
		}
	}

	$kefuHtml .= '<table id="__01" width="83" style="min-width:83px" border="0" cellpadding="0" cellspacing="0">';
	$telNo = QQKefu_get_option('telNo');
	$kefuHtml .= '<tr><td><div class="kefu1"></div></td></tr>';
	if (!empty($telNo)) {
		$kefuHtml .= '<tr><td><div class="telNo" id="txtTelNo">' . $telNo . '</div></td></tr>';
	}
	$kefuHtml .= '<tr><td><div class="kefu3"></div></td></tr>';
	$qTitle = QQKefu_get_option('qqTitle');
	$enableBigIcoShowFlag = QQKefu_get_option('enableBigIcoShow');

	//输出QQ
	if (!empty($qs)) {
		for ($i = 0; $i < count($qs); $i++) {
			$kefuHtml .= $icoSize2 == "1" ? getQQHtml($qs[$i], $qTitle[$i], $i, $enableBigIcoShowFlag) : getQQHtmlSmall($qs[$i], $qTitle[$i]);
		}
		$kefuHtml .= '<tr><td><div class="line"></div></td></tr>';
	}

	//输出旺旺
	$wangwangs = QQKefu_get_option('wangwang');
	$icoSizeWang = QQKefu_get_option('icoSizeWang');
	if (!empty($wangwangs)) {
		for ($i = 0; $i < count($wangwangs); $i++) {
			$kefuHtml .= getWangHtml($wangwangs[$i], $icoSizeWang);
		}
	}

	//输出国际旺旺
	$wangwangInter = QQKefu_get_option('wangwangInter');
	$wangwangInterNames = QQKefu_get_option('wangwangInterTitles');
	if (!empty($wangwangs)) {
		for ($i = 0; $i < count($wangwangInter); $i++) {
			$kefuHtml .= getWangwangInterHtml($wangwangInter[$i], $wangwangInterNames[$i]);
		}
		$kefuHtml .= '<tr><td><div class="line"></div></td></tr>';
	}
	$kefuHtml .= '<tr><td><a href="http://www.jqdemo.com/qqkefu" target="_blank"><div class="kefu10"></div></a></td></tr></table>';
	if (QQKefu_get_option('enbleNavlog') == "1") {
		if (QQKefu_get_option('pos') == "2") {
			$kefuHtml .= '</td></tr></table>';

		} else {
			$kefuHtml .= '</td><td id="navLog"  id="imgNav"><img src="' . plugins_url('qq-kefu/images/navLogo.gif') . '" id="imgNav"></td></tr></table>';
		}
	}

	$kefuHtml .= '</div></div><script>window.document.getElementById("txtTelNo").onclick=function(){window.prompt("客服电话","' . $telNo . '")}</script><script src="' . plugins_url('qq-kefu/qqkefuFront.js') . '"></script>';
	$kefuHtml .= '<!-- QQ客服代码结束-->';
	return $kefuHtml;
}

function QQKefuInit() {
	if (QQKefu_get_option('enableIndex')) {
		if (is_home()) {
			echo QQKefuInit1();
		}
	}
	if (QQKefu_get_option('enableSingle')) {
		if (!is_home()) {
			echo QQKefuInit1();
		}
	}

}

add_action('admin_menu', 'QQKefuAdmin');
function qqshortcode() {
	//QQKefuInit();
	return QQKefuInit1();
}

add_shortcode('qqkefu', 'qqshortcode');
/**
 * 事件初始化
 */
function QQKefuHeadInit() {
	echo '<link rel="stylesheet" href="' . plugins_url('qq-kefu/qqkefu.css') . '" type="text/css" media="screen" />';
}

if (QQKefu_get_option('enable')) {
	//add_action ( 'load-plugins', 'QQKefuHeadInit' );
	//add_action ( 'widgets_init', 'QQKefuInit' );
	add_action('get_footer', 'QQKefuInit');

}
