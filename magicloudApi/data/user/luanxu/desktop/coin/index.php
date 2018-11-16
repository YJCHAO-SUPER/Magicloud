<?php

?>
<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="favicon.ico" >
    <title>抢金币</title>
    <style>

        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }
        *[data-animation="ripple"] {
            position: relative; /*Position relative is required*/
            height: 100%;
            width: 100%;
            display: block;
            outline: none;
            padding: 20px;
            color: #fff;
            text-transform: uppercase;
            background: linear-gradient(135deg, #e570e7 0%,#79f1fc 100%);
            box-sizing: border-box;
            text-align: center;
            font-weight: 700;
            line-height: 14px;
            letter-spacing: 1px;
            text-decoration: none;
            box-shadow: 0 5px 3px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            /*border-radius: 50px;*/
            -webkit-tap-highlight-color: transparent;
        }

        *[data-animation="ripple"]:focus {
            outline: none;
        }

        *[data-animation="ripple"]::selection {
            background: transparent;
            pointer-events: none;
        }
        :root {
            /* if u want to change the color of
             * the ripple change this value
            */
            --color-ripple: rgba(255,255,255,0.8);
        }
        .coin {
            width: 200px;
            height: 200px;
        }
        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }
        .links > a {
            font-family: "Raleway", sans-serif;
            cursor: pointer;
            color: #636b6f;
            padding: 0 25px;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
    </style>
    <script src="./public/js/jquery-3.2.1.min.js"></script>
    <script src="./public/js/layer.js"></script>
</head>
<body>
    <div class="flex-center position-ref full-height  ">
        <div class="top-right links">
                <a id="rename">更换账号</a>
        </div>
            <div class="content">
                <div class="title">
                    <img src="coin.png" class="coin">
                </div>
                    <a data-animation="ripple" id="coin">获取金币</a>
                </div>
    </div>
</body>
</html>
<script>

    let username = getCookie("username");
    console.log(username);
    if(username==""){
        layer.prompt({
            title: "请输入你的姓名"
        },function(pass,index){
            rename(pass,index);
        })
    };
    function rename(pass,index){
        document.cookie="username="+pass+"; expires=Thu, 18 Dec 2028 12:00:00 GMT; path=/";
        $.ajax({
            type: "post",
            url: "coin.php",
            data: {"username":pass},
            success:function(data){
                layer.close(index);
                if(data!=null){
                    if(data!=""){
                        layer.alert(data,{title:"恭喜"});
                        username = pass;
                    }
                }
            }
        })
    }
    $("#rename").click(function(){
        layer.prompt({
            title: "请输入你的姓名"
        },function(pass,index){
            rename(pass,index);
            let username = getCookie("username");
        })
    });
    $("#coin").click(function(){
            $.ajax({
                type: "post",
                url: "coin.php",
                data: {"username":username,"click":"click"},
                success:function(data){

                    if(data!=null){
                        if(data!="false"&&data!="服务器还未开启"){
                        	layer.alert(data,{title:"恭喜"});
                        }else if(data=="服务器还未开启"){
                        	layer.alert("服务器还未开启",{title:"失败"});
                        }
                        else {
                        	layer.alert("九点才能开始抢",{title:"失败"});
                        }
                    }
                }
            })
        });
    $.ajax({
        type:"post",
        url: "coin.php?count",
        success: function(data){
            layer.tips("今天还剩下"+data+"个金币", '.coin');
        }
    })

    const isMobile = window.navigator.userAgent.match(/Mobile/) && window.navigator.userAgent.match(/Mobile/)[0] === "Mobile";
    const event = isMobile ? "touchstart" : "click";
    const button = document.querySelectorAll('*[data-animation="ripple"]'),
        container = document.querySelector(".content");
    for (let i = 0; i < button.length; i++) {
        const currentBtn = button[i];

        currentBtn.addEventListener(event, function(e) {

            e.preventDefault();
            const button = e.target,
                rect = button.getBoundingClientRect(),
                originalBtn = this,
                btnHeight = rect.height,
                btnWidth = rect.width;
            let posMouseX = 0,
                posMouseY = 0;

            if (isMobile) {
                posMouseX = e.changedTouches[0].pageX - rect.left;
                posMouseY = e.changedTouches[0].pageY - rect.top;
            } else {
                posMouseX = e.x - rect.left;
                posMouseY = e.y - rect.top;
            }

            const baseCSS =  `position: absolute;
											width: ${btnWidth * 2}px;
											height: ${btnWidth * 2}px;
											transition: all linear 700ms;
											transition-timing-function:cubic-bezier(0.250, 0.460, 0.450, 0.940);
											border-radius: 50%;
											background: var(--color-ripple);
											top:${posMouseY - btnWidth}px;
											left:${posMouseX - btnWidth}px;
											pointer-events: none;
											transform:scale(0)`;

            let rippleEffect = document.createElement("span");
            rippleEffect.style.cssText = baseCSS;

            //prepare the dom
            currentBtn.style.overflow = "hidden";
            this.appendChild(rippleEffect);

            //start animation
            setTimeout( function() {
                rippleEffect.style.cssText = baseCSS + `transform:scale(1); opacity: 0;`;
            });

            setTimeout( function() {
                rippleEffect.remove();
                //window.location.href = currentBtn.href;
            },7000);
        })
    }
    function getCookie(cookieName) {
        var strCookie = document.cookie;
        var arrCookie = strCookie.split("; ");
        for(var i = 0; i < arrCookie.length; i++){
            var arr = arrCookie[i].split("=");
            if(cookieName == arr[0]){
                return arr[1];
            }
        }
        return "";
    }
</script>