<template>
    <header>
        <div class="apple-logo">
            <img src="images/2000px-Apple_logo_black.svg.png" alt="Apple Logo">
        </div>
        <div class="finder-tools">
            <p class="menu" id="file">
                文件
            </p>
            <p class="menu" id="editor">
                编辑
            </p>
            <p class="menu" id="show">
                显示
            </p>
            <p class="menu" id="goto">
                前往
            </p>
            <p class="menu" id="window">
                窗口
            </p>
            <p class="menu" id="help">
                帮助
            </p>
        </div>
        <div class="dd-menu"  id="file-menu">
            <ul>
                <li @mousedown="folderRun('folder','root')"><img src="../../../../public/icon/folder.png" alt="">我的文件</li>
                <li @mousedown="folderRun('folder','desktop')"><img src="../../../../public/icon/folder.png" alt="">桌面</li>
                <li @mousedown="appRun('terminal')"><img src="../../../../public/icon/terminal.png" alt=""  >控制台</li>
            </ul>
        </div>
        <div class="dd-menu" id="editor-menu">
            <li ><img src="../../../../public/icon/safari-icon.png" alt="">暂无</li>
        </div>
        <div class="dd-menu" id="show-menu">
            <li ><img src="../../../../public/icon/safari-icon.png" alt="">暂无</li>
        </div>
        <div class="dd-menu" id="goto-menu">
            <li ><img src="../../../../public/icon/safari-icon.png" alt="">暂无</li>
        </div>
        <div class="dd-menu" id="window-menu">
            <li ><img src="../../../../public/icon/safari-icon.png" alt="">暂无</li>
        </div>
        <div class="dd-menu" id="help-menu">
            <li ><img src="../../../../public/icon/safari-icon.png" alt="">暂无</li>
        </div>
        <div class="right-part">
            <div class="time">
                <span>上午 6:17</span>
            </div>
        </div>
    </header>
</template>

<script>
    export default {
        name: "header-nav",
        mounted() {
            console.log("header-nav 挂载成功.");
            $(".menu").hover(function(){
                $(".dd-menu").css("display","none");
                let submenu = $(".dd-menu").eq($(this).index());
                submenu.css("display","block");
                submenu.css("margin-left",$(this).offset().left);
            });
            $(".dd-menu").mouseleave(function(){
                $(this).css("display","none");
            });
            $(" header").mouseleave(function(){
                $(".dd-menu").css("display","none");
            });
            $(".dd-menu li").mouseenter(function(){
               $(this).css("background-color","#c3c3c3");
            });
            $(".dd-menu li").mouseleave(function(){
                $(this).css("background-color","");
            });
        },
        methods:{
            appRun:function(name){
                this.$emit('appRunEvent',name+'Run_true');
                this.$emit('appRunEvent',name+'_app-'+name+'-component');
            },
            folderRun:function(name,type){
                this.$emit('appRunEvent',name+"_"+type);
            }
        }
    }
</script>

<style scoped>
    ul,li {
        padding: 0;
        margin: 0;
        list-style: none;
    }
    p {
        margin: 0;
        padding: 0;
    }
    header {
        position: absolute;
        top: 0;
        z-index: 101;
        height: 25px;
        width: 100%;
        overflow: hidden;
        background-color: #fbfcfb;
        cursor: url("../../../../public/icon/macNormSel.png"),auto;
    }
    header .apple-logo {
        margin-left: 10px;
        width: 30px;
        display:inline-block;
        float: left;
    }
    header .apple-logo img {
        width:15px;
        margin-left:7px;
        margin-top:5px;
        margin-right:20px;
    }
    header .finder-tools {
        font-size: 10px;
        display: inline-block;
        float: left;
    }
    .finder-tools p {
        color: #7a7a7a;
        font-size: 12px;
        display: inline-block;
        float: left;
        margin: 0;
        padding: 0 10px;
        height: 25px;
        line-height: 25px;
        cursor: url("../../../../public/icon/Hand.png"),auto;
    }
    .finder-tools p:hover {
        color: #ffffff;
        background-color: #0664df;
    }
    .finder {
        font-weight: 700;
    }
    header .right-part {
        display: block;
        position: absolute;
        right: 0;
    }
    header .right-part .fa {
        margin-left: 10px;
    }
    .dd-menu {
        display: none;
        position: fixed;
        top: 25px;
        width: 172px;
        border: 1px solid #8c9ead;
        border-top: 0;
        background-color: #f6f6f6;
        box-shadow: 0 0 5px #636b6f;
        border-radius: 8px;
    }
    .dd-menu ul {
        padding: 10px 0;
    }
    .dd-menu ul li {
        height: 22px;
        margin-bottom: 5px;
        list-style: none;
        font-size: 14px;
        padding: 5px 5px 0 15px;
        display: block;
        line-height: 22px;
        cursor: url('../../../../public/icon/Hand.png'),auto;
    }
    .dd-menu li img {
        vertical-align: top;
        margin-right: 5px;
        height: 18px;
        width: auto;
    }
    .time {
        font-size: 13px;
        font-weight: 500;
        height: 25px;
        line-height: 25px;
        margin-right: 10px;
    }
</style>