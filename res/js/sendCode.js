var code="";
function sendCode(){
        	/*-------------------------------------------*/
	        var InterValObj; //timer变量，控制时间
			var count = 10; //间隔函数，1秒执行
			var curCount;//当前剩余秒数
			var codeLength = 6;//验证码长度
			
			var sendMessage = function() {
				
				 code="123456";
				 console.log(code);
				alert("function init");				 
	            curCount = count;
	            var dealType; //验证方式
				var uid=$("#Mobile").val();//用户uid
	            //设置button效果，开始计时
                $("#btnSendCode").attr("disabled", "true");
                $("#btnSendCode").val(curCount + "秒后重发").css('background-color','#ccc');
                InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
				//向后台发送处理数据
	            $.ajax({
                    type: "POST", //用POST方式传输
                    dataType: "text", //数据格式:JSON
                    url: 'Login.ashx', //目标地址
                    data: "dealType=" + dealType +"&uid=" + uid + "&code=" + code,
                    error: function (XMLHttpRequest, textStatus, errorThrown) { },
                    success: function (msg){ }
	            });
	        }

	        window.sendMessage = sendMessage;
	        //timer处理函数
			function SetRemainTime() {
	            if (curCount == 0) {                
	                window.clearInterval(InterValObj);//停止计时器
	                $("#btnSendCode").removeAttr("disabled");//启用按钮
	                $("#btnSendCode").val("重新发送");
	                code = ""; //清除验证码。如果不清除，过时间后，输入收到的验证码依然有效   
					 console.log(code); 
	            }
	            else {
	                curCount--;
	                $("#btnSendCode").val(curCount + "秒后重发").css('background-color', '#ccc');
					
	            }
	        }
    	}