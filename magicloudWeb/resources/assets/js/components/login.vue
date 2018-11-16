<template>
    <div class="window">
        <div class="time">
            <span>上午6:17</span>
        </div>
        <div class="content">
            <img src="../../../../public/images/3.jpg">
            <br>
            <input type="text" name="name" id="name" placeholder="用户名">
            <br>
            <input type="password" name="password" id="password" placeholder="输入密码">
            <div class="go">
                <img src="../../../../public/images/go.png">
            </div>
            <div class="error">
                <span></span>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "login",
        mounted:function(){
            const that = this;
            $(".go").click(function(){
                let name = $("#name").val();
                let password = $("#password").val();
                let token = "";
                $.ajax({
                    type:"post",
                    url:"http://api.magicloud.top/api/login",
                    data:{"name":name,"password":password},
                    dataType:"json",
                    success:function(data){
                        if(data.code===200){
                            //登陆cookie
                            document.cookie="magicloud_token="+data.token;
                            document.cookie="magicloud_homepath="+data.home_path;
                            document.cookie="magicloud_desktoppath="+data.desktop_path;
                            that.$emit("loginEvent",data.token);
                            $(".window").hide();
                        }else if(data.code===411){
                            $(".error").html(data.msg);
                        }else{
                            $(".error").html(data.msg);
                        }
                    }
                });
            });
        }
    }
</script>

<style scoped>
    .window {
        font-size:14px;
        color:#dedede;
        background-color: #4c4c4c;
        position: absolute;
        height: 100vh;
        width: 100%;
        z-index: 399;
        cursor: url('../../../../public/icon/macNormSel.png'),auto;
    }
    .time{
        position: absolute;
        right: 0;
        margin-right: 10px;
        margin-top: 0;
        top: 0;
    }
    .content img{
        width: 74px;
        height: 74px;
        border-radius: 50px;
        /* margin-left: 65px; */
    }
    .content{
        position: absolute;
        top:50%;
        text-align: center;
        margin-top: -92px;
        left: 50%;
        margin-left: -77px;
    }
    .content #name{
        width: 150px;
        height: 30px;
        background-color: #707070;
        border-radius: 5px;
        border: none;
        margin-top: 23px;
        margin-bottom: 20px;
    }
    input::-webkit-input-placeholder{
        color:#dedede;
        padding: 10px;
    }
    .content #password{
        width: 150px;
        height: 30px;
        background-color: #707070;
        border-radius: 5px;
        border: none;
    }
    .error span{
        position: relative;
        top: 10px;
    }
    .go{
        position: relative;
        top: -28px;
        left: 160px;
        width: 25px;
        height: 25px;
        border-radius: 50px;
        background-color: #a6a6a6;

    }
    .go img{
        width: 15px;
        height: 15px;
        margin-top: 5px;
    }
</style>