$(function(){
	/*
	 *全选和全不选
	 */
	$(".selected-btu").click(function(){
       $("input[name='id[]']:checkbox").attr("checked",this.checked);       
    });

   /*
    *删除数据
    *
    *e.preventDefault();阻止默认行为
    */
	$('.delete-btu').click(function(e){
		e.preventDefault();
     	var url = $(this).attr("href");
		var count = 0;
     	var selected_id = $("input[name='id[]']");
      	$.each( selected_id, function(i,n){
      		if($(n).attr("checked")){
				count++; 
        	}
       	});
       	if(count <= 0 ){
       		art.dialog({ 
				title : '提示',
				content : '请选择想要删除的记录!',
				time : '1000',
				width : '20em',
				height : '8em'
			});
        	return ;
      	}
		var selected = $("input[name='id[]']:checked");
		var array = new Array();
		$.each(selected,function(k,v){
			array[k] = $(this).val();
		});
		$.post(url,{ id : array },function(data){
			if (!data) {
				art.dialog({
					title: '提示',
					content: '删除失败',
					time: '1000',
					width: '20em',
					height: '8em'
				});
			}
			else {
				art.dialog({
					title: '提示',
					content: '删除成功',
					time: '1000',
					width: '20em',
					height: '8em'
				});
				$('.selected-btu').attr('checked',false);
				self.location.reload();
			}
	});
  });

})