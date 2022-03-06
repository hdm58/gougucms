(function(){
    window.onload = function(){
        $focus($G("videoUrl"));
        initVideo();
    };

    function initVideo(){
        addUrlChangeListener($G("videoUrl"));
        addOkListener();
        //编辑视频时初始化相关信息
        (function(){
            var img = editor.selection.getRange().getClosedNode(),url;
            if(img && img.className){
                var hasFakedClass = (img.className == "edui-faked-video"),
                    hasUploadClass = img.className.indexOf("edui-upload-video")!=-1;
                if(hasFakedClass || hasUploadClass) {
                    $G("videoUrl").value = url = img.getAttribute("_url");
                }
            }
            createPreviewVideo(url);
        })();
    }

    /**
     * 监听确认和取消两个按钮事件，用户执行插入或者清空正在播放的视频实例操作
     */
    function addOkListener(){
        dialog.onok = function(){
            $G("preview").innerHTML = "";
            return insertSingle();
        };
        dialog.oncancel = function(){
            $G("preview").innerHTML = "";
        };
    }

    /**
     * 将单个视频信息插入编辑器中
     */
    function insertSingle(){
        var url=$G('videoUrl').value;
        if(!url) return false;
        editor.execCommand('insertHtml', getVideoId(url));
    }

    function getVideoId(url) {
		let vid = ""
		let paths = url.split("/")
		let lastPath = paths[paths.length - 1]
		let regx = /(.*)\.html/
		vid = lastPath.match(regx)[1];
        var videoStr = '<blockquote class="gougu-video" style="width:100%;max-width:640px; height:100%; max-height:420px; margin:5px;"><iframe width="100%" height="100%" frameborder="0" src="//v.qq.com/txp/iframe/player.html?vid='+vid+'"></iframe></blockquote>'
		return videoStr;
	}
    /**
     * 监听url改变事件
     * @param url
     */
    function addUrlChangeListener(url){
        if (browser.ie) {
            url.onpropertychange = function () {
                createPreviewVideo( this.value );
            }
        } else {
            url.addEventListener( "input", function () {
                createPreviewVideo( this.value );
            }, false );
        }
    }

    /**
     * 根据url生成视频预览
     * @param url
     */
    function createPreviewVideo(url){
        if ( !url )return;
        var conUrl = getVideoId(url);
        $G("preview").innerHTML = conUrl;
    }

})();
