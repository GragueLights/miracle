//判断滚动条离顶部多远，当滚动条拉到底部，加载下一页数据
function scrollloadData() {
    totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
    if (h < pageCount && $(document).height() <= totalheight) {
        h = h + 1;
        loadData(h, province, city, school);
    }
}


//加载页数   page:页码数
	function loadData(page,province,city,school){	
		$.post("web/mairActivity!getList.do",paramJson,function(data){
			//隐藏加载按钮
			$('.load_img_box').hide();
			var list = data.rows;
			pageCount = data.pageCount;
			if(page<2){
				$('.schoolBox').html("");	
			}
			if(list== null || list.length == 0){
				layer.msg('暂无相关活动');
			}else{
				
				for(var i=0;i<list.length;i++){
					
					var str='';
						str+='<a class="schoolhref" href="activityInfo.html">';
						str+=' <div class="school">';
						str+=' <div class="leftimg">';
						if(!list[i].imgSrc){
							//活动没上传图片  加载默认图片
							str+='<img src="images/abt_students_hands.png">';
						}else{
							str+='<img src="http://haiguobao.cn:80/miracle/'+list[i].imgSrc+'">';
						}
						
						str+='</div>';
						str+='<div class="rightin">';
						if(list[i].state == 0){str+='<h1>';}else if(list[i].state == 1){str+='<h1 class="gray">';}
						if((list[i].title).length>8){
							str+=list[i].title.substring(0,7)+'..</h1>';
						}else{
							str+=list[i].title+'</h1>';
						}
						
						//推荐指数
						str+=' <ul>';
						if(list[i].state == 0){
							for(var j=0;j<list[i].grade;j++){
								str+='<li></li>';
							}
							for(var q=0;q<5-list[i].grade;q++){
								str+='<li class="gray"></li>';
							}
						}else{
							for(var q=0;q<5;q++){
								str+='<li class="gray"></li>';
							}
						}
				        str+='</ul>';
				        if(list[i].state == 0){
				        	str+='<div class="number">活动人数：'+list[i].peopleNumber+'人</div>';
							str+='<div class="address">活动地点：'+list[i].space+'</div> </div>';
				        }else{
				        	str+='<div class="number gray">活动人数：'+list[i].peopleNumber+'人</div>';
							str+='<div class="address gray">活动地点：'+list[i].space+'</div> </div>';
					        }
						//判断是否已经成交
						if(list[i].state == 0){
							str+='<div class="rightmoney">';
							str+='<p>所需经费</p>';
							str+='<p class="red">￥'+list[i].fees+'</p> </div></div></a>';
						}else if(list[i].state == 1){
							str+='<div class="rightmoney">';
							str+=' <img src="images/u114.png">';
							str+='<p class="gray">所需经费</p>';
							str+='<p class="gray">￥'+list[i].fees+'</p> </div></div></a>';
						}
						
					$('.schoolBox').append(str);
				}

			}
		});
	}