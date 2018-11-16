<template>
    <div class="mac window">
        <div class="mac--top" @dbclick.stop="maxWindow">
            <span class="close-button" @mousedown="close"></span>
            <span class="max-button" @mousedown="maxWindow"></span>

            <span class="back-button">
                <span class="glyphicon glyphicon-menu-left" aria-hidden="true">
                    <img src="../../../../public/icon/left.png">
                </span>
            </span>
            <span class="forward-button">
                <span class="glyphicon glyphicon-menu-right" aria-hidden="true">
                        <img src="../../../../public/icon/right.png">
                </span>
            </span>

            <span class="name">系统偏好设置</span>

            <input type="text" class="searchbar">
            <span class="searchbar-overlay" ref="searchbarOverlay">
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            <span class="searchbar-text"><img src="icon/search.png">搜索设置</span>
          </span>
        </div>

        <div class="content">
            <div class="qian">
                <div class="box active">
                    <img src="../../../../public/icon/system-preferences-icon.png">
                    <span>通用设置</span>
                </div>
                <!--<div class="box">-->
                    <!--<img src="../../../../public/icon/facetime-icon.png">-->
                    <!--<span>Phone</span>-->
                <!--</div>-->
            </div>
            <div class="shen">
                <div class="box">
                    <img src="../../../../public/icon/system-preferences-icon.png">
                    <span>暂无</span>
                </div>
            </div>
            <div class="qian">
                <div class="box">
                    <img src="../../../../public/icon/system-preferences-icon.png">
                    <span>暂无</span>
                </div>
            </div>
            <div class="shen">
                <div class="box">
                    <img src="../../../../public/icon/system-preferences-icon.png">
                    <span>暂无</span>
                </div>
            </div>
            <div class="qian">
                <div class="box">
                    <img src="../../../../public/icon/system-preferences-icon.png">
                    <span>暂无</span>
                </div>
            </div>
        </div>

        <!-- 双击box 通用页面 -->
        <div class="menu-content" style="display: none;">

            <div class="tongyong">

                <div class="one">
                    <div class="onebox1">
                        <span>外观:</span>
                        <select id="la" class="select">
                            <option value="Sarari">Sarari</option>
                            <option value="Google Chrome">Google Chrome</option>
                            <option value="Firefox">Firefox</option>
                            <option value="IE、Edge">IE、Edge</option>
                            <option value="Opear">Opear</option>
                            <option value="TheWorld">TheWorld</option>
                        </select>
                        <p>用于按钮、菜单和窗口</p>
                    </div>
                    <div class="onebox2">
                        <input type="checkbox" id="check11">
                        <label for="check11" class="anse1">使用暗色菜单栏和 Dock</label>
                    </div>
                    <div class="onebox3">
                        <input type="checkbox" name="" id="check12">
                        <label for="check12" class="anse2">自动隐藏和显示菜单栏</label>
                    </div>
                    <div class="onebox4">
                        <span>高亮显示颜色:</span>
                        <select id="la1" class="select">
                            <option value="Sarari">Sarari</option>
                            <option value="Google Chrome">Google Chrome</option>
                            <option value="Firefox">Firefox</option>
                            <option value="IE、Edge">IE、Edge</option>
                            <option value="Opear">Opear</option>
                            <option value="TheWorld">TheWorld</option>
                        </select>
                    </div>
                    <div class="onebox5">
                        <span>边栏图标大小:</span>
                        <select id="la2" class="select">
                            <option value="Sarari">Sarari</option>
                            <option value="Google Chrome">Google Chrome</option>
                            <option value="Firefox">Firefox</option>
                            <option value="IE、Edge">IE、Edge</option>
                            <option value="Opear">Opear</option>
                            <option value="TheWorld">TheWorld</option>
                        </select>
                    </div>
                </div>

                <div class="two">
                    <div class="twobox1">
                        <p class="hide">显示滚动条:</p>
                        <input checked type="radio" name="radio1" id="radio1"><p class="xuan1">根据鼠标或触控板自动显示</p> <br>
                        <input type="radio" name="radio2" id="radio2"><p class="xuan2">滚动时</p><br>
                        <input type="radio" name="radio3" id="radio3"><p class="xuan3">始终</p><br>
                    </div>
                    <div class="twobox2">
                        <p class="hide2">在滚动条点按:</p>
                        <input checked type="radio" name="radio4" id="radio4"><p class="xuan1">跳至下一页</p> <br>
                        <input type="radio" name="radio5" id="radio5"><p class="xuan2">跳至点按的位置</p><br>
                    </div>
                </div>

                <div class="three">
                    <div class="threebox">
                        <span>默认网页浏览器:</span>
                        <select id="la3" class="select">
                            <option value="Sarari">Sarari</option>
                            <option value="Google Chrome">Google Chrome</option>
                            <option value="Firefox">Firefox</option>
                            <option value="IE、Edge">IE、Edge</option>
                            <option value="Opear">Opear</option>
                            <option value="TheWorld">TheWorld</option>
                        </select>
                    </div>
                </div>

                <div class="four">
                    <div class="fourbox1">
                        <input type="checkbox" name="" id="check2">
                        <label for="check2" class="close">关闭文稿时要求保存更改</label>
                    </div>
                    <div class="fourbox2">
                        <input type="checkbox" name="" checked="checked" id="check3">
                        <label for="check3" class="close">退出应用时关闭窗口</label>
                        <p>如果选定，则当您再次打开应用时就不会恢复已打开的文稿和窗口</p>
                    </div>
                    <div class="fourbox3">
                        <span>最近使用的项目:</span>
                        <select id="la4" class="select">
                            <option value="10">10</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="1">1</option>
                        </select>
                        <p>个文稿、应用和服务器</p>
                    </div>
                </div>

                <div class="five">
                    <div class="last">
                        <input type="checkbox"  id="check4"  name="allow" checked="checked">
                        <label for="check4" class="shiyong">使用LCD平滑字体(可用时)</label>
                    </div>
                </div>

            </div>

        </div>

        <!--<div class="menu-content" style="display: none;">234</div>-->
        <!--<div class="menu-content" style="display: none;">345</div>-->
        <!--<div class="menu-content" style="display: none;">456</div>-->
    </div>
</template>

<script>
    export default {
        name: "app-setting",
        data:function(){
          return {
              "max":false
          }
        },
        methods:{
            close:function(){
                this.$emit('appRunEvent',"setting_empty");
            },
            maxWindow:function(){
                if(this.max===false){
                    this.$emit('appMaxEvent','settingMax_true');
                    this.max=true;
                }else {
                    this.$emit('appMaxEvent','settingMax_false');
                    this.max=false;
                }

            }
        },
        mounted:function(){
            $(".window").draggable();
            $(this).find(".searchbar-overlay").click(function() {
                $(".searchbar").focus();
            });

            $(this).find(".searchbar").focus(function() {
                $(".searchbar-overlay").addClass("selected");
            }).blur(function() {
                if($(".searchbar").val() === "") {
                    $(".searchbar-overlay").removeClass("selected");
                    $(".searchbar-text").show();
                }
            });

            $(".searchbar").keypress(function() {
                $(".searchbar-text").hide();

                if($(this).val() === "") {
                    $(".searchbar-text").show();
                }
            });

            // 显示
            $(".box").click(function(){
                // 选中样式
                $(".box").removeClass("active");
                $(this).addClass("active");

            });
            // 双击打开
            $(".box").dblclick(function(){
                // 获取第几个盒子
                let index = $(this).index(".box");
                // 隐藏content
                $(".content").hide();
                // 显示第几个盒子
                $(".menu-content").eq(index).show();
                $(".back-button").find(".glyphicon.glyphicon-menu-left").css("opacity",1);
            });
            $(".back-button").click(function(){
                $(".menu-content").hide();
                $(".content").show();
                $(".back-button").find(".glyphicon.glyphicon-menu-left").css("opacity",0.15);
            })
        }
    }
</script>

<style scoped>
    h2 {
        -webkit-font-smoothing: antialiased;
        font-weight: 300;
    }
    .maxSize {
        top:25px !important;
        left:0 !important;
        width:100% !important;
        margin-left:0 !important;
        margin-right:0 !important;
        margin-top:0 !important;
    }
    .window {
        position: absolute;
        left: 50%;
        margin-left: -30%;
        top: 50%;
        margin-top: -242px;
        width: 60%;
        background-color: white;
        height: 30em;
        box-shadow: 0 5px 40px rgba(0, 0, 0, 0.4);
        border-radius: 7px;
    }

    .mac {
        background-color: #F5F2F0;
        border: 1px solid rgba(167, 167, 167, 0.7);
        border-top-color: rgba(167, 167, 167, 0.5);
    }
    .mac .mac--top {
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        background-image: linear-gradient(#E6E2E6, #CDCBCD);
        height: 2.3em;
        border-top: 1px solid #F3F1F3;
        border-bottom: 1px solid rgba(167, 167, 167, 0.7);
    }
    .mac .mac--top .close-button:before {
        content: '';
        background-color: #FF4443;
        height: 12px;
        width: 12px;
        border-radius: 50%;
        display: inline-block;
        border: 1px solid #F21111;
        position: relative;
        top: 8px;
        left: 12px;
        cursor: url("../../../../public/icon/Hand.png"),auto;
    }
    .mac .mac--top .min-button:before {
        content: '';
        background-color: #FFBE00;
        height: 12px;
        width: 12px;
        border-radius: 50%;
        display: inline-block;
        border: 1px solid #E9A113;
        position: relative;
        top: 8px;
        left: 16px;
        cursor: url("../../../../public/icon/Hand.png"),auto;
    }
    .mac .mac--top .max-button:before {
        content: '';
        background-color: #00DA47;
        height: 12px;
        width: 12px;
        border-radius: 50%;
        display: inline-block;
        border: 1px solid #12B52E;
        position: relative;
        top: 8px;
        left: 20px;
        cursor: url("../../../../public/icon/Hand.png"),auto;
    }
    .mac .mac--top .back-button {
        height: 21px;
        width: 25px;
        background-color: #FBFBFB;
        display: inline-block;
        left: 30px;
        top: 7px;
        position: relative;
        border-radius: 3px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        cursor: url("../../../../public/icon/Hand.png"),auto;
    }
    .mac .mac--top .back-button .glyphicon {
        position: relative;
        left: 6px;
        opacity: 0.15;
        top: 2px;
        -webkit-font-smoothing: antialiased;
    }
    .mac .mac--top .back-button .glyphicon img {
        width: 15px;
    }
    .mac .mac--top .forward-button {
        height: 21px;
        width: 25px;
        background-color: #FBFBFB;
        display: inline-block;
        left: 27px;
        top: 7px;
        position: relative;
        border-radius: 3px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        cursor: url("../../../../public/icon/Hand.png"),auto;
    }
    .mac .mac--top .forward-button .glyphicon {
        position: relative;
        left: 6px;
        opacity: 0.15;
        top: 2px;
        -webkit-font-smoothing: antialiased;
    }
    .mac .mac--top .forward-button .glyphicon img {
        width: 15px;
    }
    .mac .mac--top .name{
        font-size: 13px;
        position: absolute;
        top:12px;
        left: 350px;
    }
    .mac .mac--top .searchbar {
        padding-left: 25px;
        position: relative;
        top: 7px;
        height: 21px;
        border-radius: 4px;
        border: none;
        left: 39.5em;
        width: 17.8em;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
    }
    .mac .mac--top .searchbar:focus {
        outline-offset: -2px;
        outline: #84B9EF auto 5px;
    }
    .mac .mac--top .searchbar-overlay {
        position: relative;
        top: 7px;
        right: -23em;
        color: #ADACAD;
        font-family: "Helvetica Neue", "Helvetica", "Arial", sans-serif;
        font-size: 12px;
        transition: all 0.25s;
    }
    .mac .mac--top .searchbar-overlay .glyphicon {
        margin-right: 5px;
    }
    .mac .mac--top .searchbar-overlay.selected {
        right: 9.5em;
    }
    .mac .mac--top .searchbar-overlay .searchbar-text img{
        position: relative;
        top: 3px;
        width: 15px;
    }
    .mac .content {
        width: 100%;
        height: 440px;
    }
    .mac .content .qian {
        width: 100%;
        height: 88px;
        background-color: #e9e9e9;
        border-bottom: 1px solid #dbdbdb;
    }
    .mac .content .active{
        background-color: #c3c3c3;
        border: 1px solid #dbdbdb;
        border-radius: 7px;
    }
    .mac .content .box{
        width: 80px;
        margin-left:20px;
        margin-top: 2px;
        float: left;
        border: 1px solid transparent;
    }
    .mac .content .qian img{
        width: 50px;
        margin-top: 7px;
        margin-left: 15px;
    }
    .mac .content .qian span{
        font-size: 13px;
        margin-left:10px;
    }
    .mac .content .shen {
        width: 100%;
        height: 88px;
        background-color: #e1e1e1;
        border-bottom: 1px solid #dbdbdb;
    }
    .mac .content .shen img{
        width: 50px;
        margin-top: 7px;
        margin-left: 15px;
    }
    .mac .content .shen span{
        font-size: 13px;
        margin-left:10px;
    }
    .mac .tongyong {
        width: 100%;
        height: 440px;
        background-color: #ececec;
    }
    .mac .tongyong .one {
        width: 100%;
        height: 120px;
        border-bottom: 1px solid #d5d5d5;
    }
    .mac .tongyong .one .onebox1 {
        text-align: center;
        position: relative;
        top:10px;
        left: -13px;
    }
    .mac .tongyong .one .onebox1 span{
        font-size: 13px;
        display: inline-block;
        position: absolute;
        top:0;
        left: 325px;
    }
    .mac .tongyong .one .onebox1 .select{
        position: absolute;
        top: 0;
        right: 415px;
    }
    .mac .tongyong .one .onebox1 p {
        font-size: 13px;
        display: inline-block;
        position: absolute;
        top: -13px;
        right: 268px;
    }
    .mac .tongyong .one .onebox2 {
        text-align: center;
        position: relative;
        top:10px;
    }
    .mac .tongyong .one .onebox2 input {
        width: 17px;
        height: 17px;
        padding-left: 0;
        float: none;
        display:inline-block;
        vertical-align:middle;
        position: absolute;
        top: 22px;
        left: 362px;
    }
    .mac .tongyong .one .onebox3 input {
        width: 17px;
        height: 17px;
        padding-left: 0;
        float: none;
        display:inline-block;
        vertical-align:middle;
        position: absolute;
        top: 93px;
        left: 362px;
    }
    .mac .tongyong .one .onebox2 .anse1 {
        font-size: 13px;
        vertical-align:middle;
        float: none;
        position: absolute;
        top: 25px;
        left: 390px;
    }
    .mac .tongyong .one .onebox3 .anse2 {
        font-size: 13px;
        vertical-align:middle;
        float: none;
        position: absolute;
        top: 94px;
        left: 390px;
    }
    .mac .tongyong .one .onebox4 {
        text-align: center;
        position: relative;
        top:10px;
        left: -13px;
    }
    .mac .tongyong .one .onebox4 span{
        font-size: 13px;
        display: inline-block;
        position: absolute;
        top:68px;
        left: 279px;
    }
    .mac .tongyong .one .onebox4 .select{
        position: absolute;
        top: 68px;
        right: 415px;
    }

    .mac .tongyong .one .onebox5 {
        text-align: center;
        position: relative;
        top:10px;
        left: -13px;
    }
    .mac .tongyong .one .onebox5 span{
        font-size: 13px;
        display: inline-block;
        position: absolute;
        top:89px;
        left: 280px;
    }
    .mac .tongyong .one .onebox5 .select{
        position: absolute;
        top: 89px;
        right: 415px;
    }

    .mac .tongyong .two {
        width: 100%;
        height: 96px;
        border-bottom: 1px solid #d5d5d5;
    }
    .mac .tongyong .two .twobox1 {
        text-align: center;
        position: relative;
        top:17px;
    }
    .mac .tongyong .two .twobox1 .hide {
        font-size: 13px;
        display: inline-block;
        position: absolute;
        top:-30px;
        left: 280px;
    }
    .mac .tongyong .two .twobox1 input {
        position: absolute;
        left:365px;
        margin-top: -15px;
    }
    .mac .tongyong .two .twobox1 .xuan1 {
        font-size: 13px;
        display: inline-block;
        position: absolute;
        top: -30px;
        right: 360px;
    }
    .mac .tongyong .two .twobox1 .xuan2 {
        font-size: 13px;
        display: inline-block;
        position: absolute;
        top: -10px;
        right: 477px;
    }
    .mac .tongyong .two .twobox1 .xuan3 {
        font-size: 13px;
        display: inline-block;
        position: absolute;
        top: 10px;
        right: 490px;
    }
    .mac .tongyong .two .twobox2 {
        text-align: center;
        position: relative;
        top:17px;
    }
    .mac .tongyong .two .twobox2 .hide2 {
        font-size: 13px;
        display: inline-block;
        position: absolute;
        top:-35px;
        left: 269px;
    }
    .mac .tongyong .two .twobox2 input {
        position: absolute;
        left:365px;
        margin-top: -18px;
    }
    .mac .tongyong .two .twobox2 .xuan1 {
        font-size: 13px;
        display: inline-block;
        position: absolute;
        top: -34px;
        right: 450px;
    }
    .mac .tongyong .two .twobox2 .xuan2 {
        font-size: 13px;
        display: inline-block;
        position: absolute;
        top: -14px;
        right: 423px;
    }

    .mac .tongyong .three {
        width: 100%;
        height: 56px;
        border-bottom: 1px solid #d5d5d5;
    }
    .mac .tongyong .three .threebox {
        text-align: center;
        position: relative;
        top:17px;
    }
    .mac .tongyong .three .threebox span {
        font-size: 13px;
        display: inline-block;
        position: absolute;
        top:3px;
        left: 259px;
    }
    .mac .tongyong .three .threebox .select {
        position: absolute;
        top: 3px;
        right: 425px;
    }

    .mac .tongyong .four {
        width: 100%;
        height: 120px;
        border-bottom: 1px solid #d5d5d5;
    }
    .mac .tongyong .four .fourbox1 {
        text-align: center;
        position: relative;
        top:10px;
    }
    .mac .tongyong .four .fourbox1 input {
        width: 17px;
        height: 17px;
        padding-left: 0;
        float: none;
        display:inline-block;
        vertical-align:middle;
    }
    .mac .tongyong .four .fourbox1 .close {
        font-size: 13px;
        vertical-align:middle;
        float: none;
    }
    .mac .tongyong .four .fourbox2 {
        text-align: center;
        position: relative;
        top:10px;
        left: -13px;
    }
    .mac .tongyong .four .fourbox2 input {
        width: 17px;
        height: 17px;
        padding-left: 0;
        float: none;
        display:inline-block;
        vertical-align:middle;
    }
    .mac .tongyong .four .fourbox2 .close {
        font-size: 13px;
        vertical-align:middle;
        float: none;
    }
    .mac .tongyong .four .fourbox2 p {
        font-size: 10px;
        position: absolute;
        top: 20px;
        right: 210px;
    }
    .mac .tongyong .four .fourbox3 {
        text-align: center;
        position: relative;
        top:10px;
        left: -13px;
    }
    .mac .tongyong .four .fourbox3 span {
        font-size: 13px;
        display: inline-block;
        position: absolute;
        top:30px;
        left: 275px;
    }
    .mac .tongyong .four .fourbox3 .select {
        position: absolute;
        top: 30px;
        right: 490px;
    }
    .mac .tongyong .four .fourbox3 p {
        font-size: 13px;
        display: inline-block;
        position: absolute;
        top: 17px;
        right: 340px;
    }

    .mac .tongyong .five {
        text-align: center;
        position: relative;
        top:10px;
    }
    .mac .tongyong .five .last input{
        width: 17px;
        height: 17px;
        padding-left: 0;
        float: none;
        display:inline-block;
        vertical-align:middle;
        position: absolute;
        left: 373px;
    }
    .mac .tongyong .five .shiyong {
        font-size: 13px;
        vertical-align:middle;
        float: none;
        position: absolute;
        right:359px;
    }

</style>