$(function(){

	/*
	 * input获得焦点改变背景色
	 */
	$("input").focus(function(){
  		//$(this).css("background","#EEF8FB");
	});
	
	$("input").blur(function(){
		$(this).css("background","");
	})

	/*
	 * 修改文章下拉列表选中
	 */
	$('#updateSort_id').each(function(){
		var value = $('#selectValue').val();
		$(this).find('option').eq(value-1).attr('selected','selected');
	})

		/*
	 *编辑器自定义添加代码按钮
	 */	
	var coderPlugin = { 
		highlight: { 
			c: 'btnCode', //插件在编辑器内的按钮样式
			t: '插入代码',  //鼠标放在按钮上显示的提示文字
			s: null, //设置快捷方式
			h: 1, 
			e: function (){ //插件点击后执行的代码
				var _this=this;
        var htmlCode='<div><select id=\"xheCodeType\"><option value=\"html\">HTML/XML</option><option value=\"js\">Javascript</option><option value=\"css\">CSS</option><option value=\"php\">PHP</option><option value=\"vb\">ASP</option><option value=\"csharp\">C#</option><option value=\"java\">java</option><option value=\"sql\">SQL</option></select></div><div><textarea id=\"xheCodeValue\" wrap=\"soft\" spellcheck=\"false\" style=\"width:300px;height:100px;\" /></div><div style=\"text-align:right;\"><input type=\"button\" id=\"xheSave\" value=\"确定\" /></div>';            
        var jCode=$(htmlCode),
        jType=$('#xheCodeType',jCode),
        jValue=$('#xheCodeValue',jCode),
        jSave=$('#xheSave',jCode);
        jSave.click(function(){
        	_this.loadBookmark();
          _this.pasteHTML('<pre title=\"code\" class=\"brush:'+jType.val()+';\">'+_this.domEncode(jValue.val())+'</pre>');
          _this.hidePanel();
          return false;    
        });
       	_this.saveBookmark();
        _this.showDialog(jCode);
			} 
		} 
	}; 

	/*
	 * 编辑器调用
	 */
	 var rootSrc = "/Uploads/upload.php?immediate=1";
	 var root1 = "http://cq.cdchina.cc";
	$('textarea').xheditor({plugins:coderPlugin,tools:'full',width:600,height:250,upImgUrl:rootSrc,upImgExt:"jpg,jpeg,gif,png",urlType:'root',urlBase:'http://cq.cdchina.cc/Uploads',emotPath:root1+'/Public/js/Admin/main/xheditor-1.1.14/xheditor_emot/',html5Upload:false,emots:{default:{name:'默认',width:24,height:24,line:7,list:{'smile':'微笑','tongue':'吐舌头','titter':'偷笑','laugh':'大笑','sad':'难过','wronged':'委屈','fastcry':'快哭了','cry':'哭','wail':'大哭','mad':'生气','knock':'敲打','curse':'骂人','crazy':'抓狂','angry':'发火','ohmy':'惊讶','awkward':'尴尬','panic':'惊恐','shy':'害羞','cute':'可怜','envy':'羡慕','proud':'得意','struggle':'奋斗','quiet':'安静','shutup':'闭嘴','doubt':'疑问','despise':'鄙视','sleep':'睡觉','bye':'再见'}}}});	
})


