<template>
    <div id="desktop-app" @mousedown.stop="clearActive(desktop_apps)" ref="desktopBox">
        <div v-for="(desktop_app,index) in desktop_apps" class="app-box"  v-bind:title="desktop_app.content"  :class="{ 'box-active' : desktop_app.isActive }"  @dblclick.stop="appDoubleClick(desktop_app,index)" @mousedown.stop="switchActive(desktop_app)"  ref="appbox">
            <div class="icon">
                <img :src=desktop_app.icon alt="">
            </div>
            <span class="app-name">
                <span class="name-box" :class="{ 'name-active' : desktop_app.isActive}">
                    {{desktop_app.name}}
                </span>
            </span>
        </div>
        <app-terminal-component  v-bind:is="appRuns.terminal" v-on:appRunEvent="appRun"   v-on:appMinEvent="minCom" v-on:appMaxEvent="maxCom" @mousedown.native="fixZIndex($event)" :class="{'maxSize': terminalMax,'minSize': appRuns.terminalMin}"></app-terminal-component>
        <app-chrome-component v-bind:is="appRuns.chrome" v-on:appRunEvent="appRun" :class="{'maxSize': chromeMax,'minSize': appRuns.chromeMin}" v-on:appMaxEvent="maxCom"  v-on:appMinEvent="minCom" @mousedown.native="fixZIndex($event)"></app-chrome-component>
        <app-folder-component  v-for="(appFolder,index) in appFolders" :key="appFolder.id" :nowpath="nowpath" :homepath="homepath" :pastid="index"  v-on:editorOpenEvent="openEditor"  v-on:appEvent="closeCom"  v-on:appMaxEvent="maxCom" @mousedown.native="fixZIndex($event)" :class="{'maxSize': appFolder.max}"></app-folder-component>
        <app-calc-component v-bind:is="appRuns.calc"  v-on:appRunEvent="appRun" v-on:appMinEvent="minCom" @mousedown.native="fixZIndex($event)" :class="{'minSize': appRuns.calcMin}"></app-calc-component>
        <app-aplayer-component v-bind:is="appRuns.aplayer"></app-aplayer-component>
        <div class="editorBox" :class="{'display':aceEditorActive,'maxSize':aceEditorMax}" @mousedown="fixZIndex($event)" >
            <div class="editor-header">
                <div class="header-buttons">
                    <button class="button close" @click="closeEditor" >
                    </button>
                    <button class="button maximize" @click="editorMax">
                    </button>
                </div>
                <span class="header-title">这是标题</span>
            </div>
            <div class="editor-tools">
                <span @mousedown="saveEditor" id="saveContent">保存</span>
                <span style="color: #c3c3c3">刷新</span>
                <span style="color: #c3c3c3">搜索</span>
            </div>
            <div class="editor-tab"></div>
            <div  class="msg success" style="display:none;left: 45%; opacity: 1; top: 25%;">
                <i class="tips-icon">√</i>
                <div class="tips-msg">
                    <p>保存成功</p>
                </div>
                <a class="tips-close">×</a>
                <div style="clear:both"></div>
            </div>
            <app-aceEditor-component :filepath="filepath" :saveContent="saveContent" v-bind:is="aceEditor"  ></app-aceEditor-component>
        </div>
        <app-setting-component v-bind:is="this.appRuns.setting" v-on:appRunEvent="appRun" @mousedown="fixZIndex($event)"  :class="{'maxSize':settingMax}" v-on:appMaxEvent="maxCom"></app-setting-component>

    </div>

</template>

<script>
    Vue.component('app-terminal-component',require('./app-terminal'));
    Vue.component('app-chrome-component',require('./app-chrome'));
    Vue.component('app-folder-component',require('./app-folder'));
    Vue.component('app-calc-component',require('./app-calc'));
    Vue.component('app-aplayer-component',require('./aplayer'));
    Vue.component('app-aceEditor-component',require('./app-aceEditor'));
    Vue.component('app-setting-component',require('./app-setting'));

    export default {
        name: "desktop-app",
        props:["appRuns","refresh","newfolder"],
        data:function(){
            return {
                token:"",
                desktop_apps: [],
                need_update:true,
                active_id:[],
                desktopHeight:0,
                appboxEl:[],
                terminalMax:false,
                chromeMax:false,
                aceEditorMax:false,
                settingMax:false,
                appFolders:[],
                aceEditor:"",
                aceEditorActive: false,
                nowpath:"",
                homepath:"",
                desktoppath:"",
                folder_count:1,
                zindex:100,
                filepath:"",
                saveContent:0
            }
        },
        //ready阶段
        mounted() {
            this.token = getCookie('magicloud_token');
            let homepath = getCookie('magicloud_homepath');
            let desktoppath = getCookie('magicloud_desktoppath');
            if(homepath!=undefined){
                this.nowpath = homepath;
                this.homepath = homepath;
                this.desktoppath = desktoppath;
            }
            function getCookie(cookieName) {
                let strCookie = document.cookie;
                let arrCookie = strCookie.split("; ");
                for(let i = 0; i < arrCookie.length; i++){
                    let arr = arrCookie[i].split("=");
                    if(cookieName === arr[0]){
                        return arr[1];
                    }
                }
                return "";
            }
            //editorBox拖动编辑器
            $(".editorBox").draggable();
            console.log("桌面图标挂载成功！");
            this.requestData();
            //保存指针
            const that = this;
            //检测desktopBox高度变化
            window.onresize = () => {
                return (() => {
                    that.desktopHeight = that.$refs.desktopBox.offsetHeight;
                })()
            };
        },
        //监听数据
        watch: {
            desktopHeight(val){
                let appBoxEl = this.appboxEl;
                this.soutDesktopBox(appBoxEl);
            },
            refresh(val){
                //刷新
                this.requestData();
                this.need_update = true;
            },
            newfolder(val){
                let type = val[0];
                switch (type){
                    case "root":{
                        this.nowpath = this.homepath;
                        this.appFolders.push({"id":this.folder_count,"max":false});
                        this.folder_count++;
                        break;
                    }
                    case "desktop":{
                        this.nowpath = this.desktoppath;
                        this.appFolders.push({"id":this.folder_count,"max":false});
                        this.folder_count++;
                        break;
                    }
                    default:{

                    }
                }

            }

        },
        //更新阶段
        updated(){
            this.appboxEl = this.$refs.appbox;
            $(this.$refs.appbox).draggable();
            if(this.need_update===true){
                this.soutDesktopBox(this.$refs.appbox);
                this.need_update=false;
            }
        },
        methods:{
            //请求图标数据
            "requestData":function(){
                let that = this;
                function getCookie(cookieName) {
                    let strCookie = document.cookie;
                    let arrCookie = strCookie.split("; ");
                    for(let i = 0; i < arrCookie.length; i++){
                        let arr = arrCookie[i].split("=");
                        if(cookieName === arr[0]){
                            return arr[1];
                        }
                    }
                    return "";
                }
                $("#saveContent").click(function(){
                    $(".success").show(1000);
                    setTimeout(function(){$(".success").hide(1000)},3000);
                });
                let token = getCookie('magicloud_token');
                $.ajax({
                    url:"http://api.magicloud.top/api/desktop",
                    type:"get",
                    data:{"token":token},
                    dataType:"json",
                    success:function(data){
                        that.desktop_apps=data;
                        // $(".app-box").draggable();
                    }
                });
            },
            //切换图标选中样式
            "switchActive":function(desktop_app,index){
                    this.clearActive(this.desktop_apps,index);
                    desktop_app.isActive=true;

            },
            //双击打开应用
            "appDoubleClick":function(desktop_app){
                //判断文件类型
                //文件夹
                if(desktop_app.type==="folder"){
                    this.nowpath = desktop_app.path;
                    this.appFolders.push({"id":this.folder_count,"max":false});
                    this.folder_count++;
                }
                // app应用
                if(desktop_app.type==="chrome"){
                    // this.chrome = "app-chrome-component";
                    this.$emit('appMinEvent','chromeMin_false');
                    this.$emit('appRunEvent','chrome_app-chrome-component');
                }
                //控制台
                if(desktop_app.type==="cmd") {
                    this.$emit('appMinEvent','terminalMin_false');
                    // this.terminal = "app-terminal-component";
                    this.$emit('appRunEvent','terminal_app-terminal-component');
                }
                if(desktop_app.type==="file"){
                    this.aceEditor = "app-aceEditor-component";
                    this.filepath = desktop_app.path;
                    this.aceEditorActive = true;
                    $(".editorBox").css("z-index",this.zindex+1);
                    $(".header-title").html(this.filepath);

                }
            },
            //清理所有选中框
            "clearActive":function(desktop_apps,index){
                for (let i =0; i<desktop_apps.length;i++){
                    if(index!=null&&i!==index){
                        desktop_apps[i].isActive=false;
                    }else {
                        desktop_apps[i].isActive=false;
                    }
                }
                //强制更新
                this.$forceUpdate();
            },
            "appRun":function(el){
                this.$emit("appRunEvent",el);
                let arr = el.split("_");
                if(arr[0]==="folder"){
                    this.appFolders.push({"id":this.folder_count,"max":false});
                    this.folder_count++;
                }
            },
            //子组件通信
            "closeCom":function(el){
                let arr = el.split("_");
                if(arr[0]==="folder"){
                    this.appFolders.splice(arr[2]);
                }else {
                    eval("this." + arr[0] + "=" + arr[1]);
                }
            },
            "maxCom":function(el){
                let arr = el.split("_");
                if(arr[0]==="folder"){
                    eval("this.appFolders"+"["+arr[2]+"].max="+arr[1]);
                }else {
                    eval("this." + arr[0] + "=" + arr[1]);
                }
            },
            "minCom":function(el){
                //将消息传给父组件
                this.$emit('appMinEvent',el);
                let arr = el.split("_");
                if(arr[0]==="folder"){
                    eval("this.appFolders"+"["+arr[2]+"].max="+arr[1]);
                }else {
                    eval("this." + arr[0] + "=" + arr[1]);
                }
            },
            "closeEditor":function(){
                this.aceEditor = "empty";
                this.aceEditorActive = false;
            },
            //桌面图标排序算法
            "soutDesktopBox":function(appBoxEl){
                if(appBoxEl==null){
                    return;
                }
                // 应用盒子高度
                let appBoxHeight= appBoxEl[0].offsetHeight+45;
                //应用盒子宽度
                let appBoxWidth = appBoxEl[0].offsetWidth;
                //可视内容高度
                let desktopHeight = this.$refs.desktopBox.offsetHeight-25;
                //列数
                let column = Math.floor(appBoxHeight*appBoxEl.length/desktopHeight);
                //行数
                let row = Math.floor(desktopHeight/appBoxHeight)-1;
                //当前列
                let currentColumn = 0;
                //当前行
                let currentRow = 0;
                for (let i =0 ; i<appBoxEl.length; i++){
                    if(currentRow<row){
                        $(appBoxEl[i]).css("left", currentColumn * appBoxWidth);
                        $(appBoxEl[i]).css("top", currentRow * appBoxHeight+35);
                        currentRow++;
                    }else {
                        $(appBoxEl[i]).css("left", currentColumn * appBoxWidth);
                        $(appBoxEl[i]).css("top", currentRow * appBoxHeight+35);
                        currentColumn++;
                        currentRow=0;
                    }
                }
            },
            "fixZIndex":function(event){
                $(event.currentTarget).css("z-index",this.zindex+1).css("position","absolute");
                this.zindex=this.zindex+1;
            },
            "saveEditor":function(){
                this.saveContent++;
            },
            "openEditor":function(el){
                this.aceEditor = "app-aceEditor-component";
                this.filepath = el;
                this.aceEditorActive = true;
                $(".header-title").html(this.filepath);
                $(".editorBox").css("z-index",this.zindex+1);
            },
            "editorMax":function(){
                if(this.aceEditorMax===false){
                    this.aceEditorMax=true;
                }else{
                    this.aceEditorMax=false;
                }
            }
        }
    }
</script>

<style scoped>
    .display {
        display: block !important;
    }
    .editorBox {
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -13%;
        margin-left: -34%;
        height: 70%;
        width: 70%;
    }
    .editorBox .editor-header{
        height: 22px;
        background: linear-gradient(0deg, #d8d8d8, #ececec);
        border-top: 1px solid white;
        border-bottom: 1px solid #b3b3b3;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        color: rgba(0, 0, 0, 0.7);
        font-family: Helvetica, sans-serif;
        font-size: 13px;
        line-height: 22px;
        text-align: center;
    }
    button {
        outline: none;
        cursor: url("../../../../public/icon/Hand.png"),auto;
    }
    .msg {
         height: 40px;
        margin-top: 15px;
        max-width: 600px;
        min-width: 160px;
        overflow: hidden;
        position: fixed;
        font-size: 14px;
        text-align: left;
        z-index: 9999;
        pointer-events: none;
        background: #fff;
        transition: width .6s ease;
        border: 0px solid transparent;
        box-shadow: 0 2px 4px rgba(0,0,0,.15), 0 0 6px rgba(0,0,0,.08);
        border-radius: 3px;
        padding: 0;
    }
    .tips-icon {
        background: #13ce66;
        width: 40px;
        height: 100%;
        position: absolute;
        font-size: 25px;
        padding: 0;
        line-height: 40px;
        font-weight: 700;
        color: #fff;
        text-align: center;
        display: inline-block;
    }
    .tips-msg {
        color: #8492a6;
        margin-top: -3px;
        padding: 0 40px 0 50px;
    }
    .tips-close {
        font-size: 22px;
        cursor: pointer;
        width: 40px;
        height: 40px;
        line-height: 35px;
        text-align: center;
        position: absolute;
        right: 0;
        top: 0;
        color: #ddd;
        pointer-events: all;
    }
    .editor-header .header-buttons {
        position: absolute;
        width: 100px;
        text-align: left;
        margin-left: 15px;
    }
    .header-buttons .button {
        width: 12px;
        height: 12px;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border-radius: 50%;
        padding: 0;
        margin: 0;
        margin-right: 4px;
        background-color: gainsboro;
        border: 1px solid rgba(0, 0, 0, 0.2);
        color: rgba(0, 0, 0, 0.5);
    }
    .header-buttons .close {
        background-color: #ff6159;
    }
    .header-buttons .minimize {
        background-color: #ffbf2f;
    }
    .header-buttons .maximize {
        background-color: #25cc3e;
    }
    .header-title {
        display: block;
        margin: 0 auto;
    }
    .editorBox .editor-tools {
        color: #ffffff;
        width: 100%;
        height: 25px;
        overflow: hidden;
        box-shadow: 1px 2px 15px #3d3d3d;
        border-bottom: 1px solid #474747;
        background: #3d3d3d;
    }
    .editor-tools span {
        margin-left: 5px;
        cursor: url('../../../../public/icon/Hand.png'),auto;
    }
    .maxSize {
        top:25px !important;
        left:0 !important;
        width:100% !important;
        margin-left:0 !important;
        margin-right:0 !important;
        margin-top:0 !important;
        height: 100% !important;
    }
    .minSize {
        display: none !important;
    }
    #app-terminal-component {
        position: fixed;
        top: 50%;
        margin-top: -120px;
        left: 50%;
        margin-left: -320px;
    }
    span {
        margin: 0;
        padding: 0;
    }
    #desktop-app {
        width: 100%;
        height: 100vh;
        margin-left: 20px;
    }
    .app-box {
        position: absolute;
        width: 60px;
        height: 52px;
        margin-bottom: 35px;
        text-align: center;
        border-radius: 5px;
        border: 2px solid transparent;
        display: block;
        float: left;
        margin-right: 20px;
        padding: 3px;
        cursor: url('../../../../public/icon/Hand.png'),auto;
    }
    .box-active {
        border: 2px solid #a8b4be;
        background-color: #8c98a4;
    }
    .app-box .name-box.name-active {
        background-color: #0863d9;
    }
    .app-box .icon {
        width: 55px;
        height: 55px;
        text-align: center;
        margin: 0 auto;
    }
    .app-box .icon img {
        width: 100%;
        height: 100%;
    }
    .app-box .app-name {
        width: 100%;
        left: 0;
        text-align: center;
        position: absolute;
        font-size: 12px;
        color: #f1f6fc;
        margin-top: 5px;
    }
    .app-box .name-box {
        text-shadow: 0 0 5px #000000;
        background-color: transparent;
        border-radius: 3px;
        padding: 1px 2px;
    }

</style>
