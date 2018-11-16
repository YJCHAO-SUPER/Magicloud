<template>
    <div class="mac window">
        <div class="mac--top" @dblclick.stop="maxWindow">
            <span class="close-button" @mousedown="close"></span>
            <!--<span class="min-button"></span>-->
            <span class="max-button" @mousedown="maxWindow"></span>

            <span class="back-button" @mousedown="back">
                <span class="glyphicon glyphicon-menu-left" aria-hidden="true">
                    <img src="icon/left.png">
                </span>
            </span>
            <span class="forward-button" @mousedown="forward">
                <span class="glyphicon glyphicon-menu-right" aria-hidden="true">
                        <img src="icon/right.png">
                </span>
            </span>

            <input type="text" class="searchbar" @keyup="searchFile">
            <span class="searchbar-overlay" ref="searchbarOverlay">
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            <span class="searchbar-text"><img src="icon/search.png">搜索文件</span>
          </span>
        </div>

        <div class="content">

            <div class="left">
                <span class="little">我的文件</span>
                <div class="yes parent" type="folder" path="" @click="activeBox()">
                    <img src="icon/house.png">
                    <span class="font" style="font-size:13px;" >我的文档</span>
                </div>
                <div class="yes" :class="{ 'ractive' : box.active}" v-for="(box,index) in leftboxs" v-bind:type="box.type" v-bind:path="box.path" @click="activeBox(box)">
                    <img :src=box.icon>
                    <span class="font" style="font-size:13px;">{{box.name}}</span>
                </div>
            </div>
            <div class="right">
                <div class="box" :class="{ 'ractive' : box.active}" v-for="(box,index) in rightboxs" v-bind:type="box.type" v-bind:path="box.path" @dblclick="getNewFile(box)" @mousedown="activeBoxR(box)" v-bind:title="'路径:'+box.path">
                    <img :src=box.icon>
                    <br>
                    <span>{{box.name}}</span>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "app-folder",
        props:['pastid','nowpath','homepath'],
        data:function(){
          return {
              "fixpath":"",
              "path":"",
              "oldpath":[],
              "newpath":[],
              "max":false,
              "leftboxs":[],
              "rightboxs":[],
              "token":""
          }
        },
        watch:{
          max(val){
              if(val===true){
                  this.$emit('appMaxEvent','folder_true_'+this.pastid);
              }else {
                  this.$emit('appMaxEvent','folder_false_'+this.pastid);
              }
          }
        },
        methods:{

          "close":function(){
              this.$emit('appEvent','folder_close_'+this.pastid);
              $(document).unbind();
          },
           "maxWindow":function(){
               if(this.max===false){
                   this.max=true;
               }else {
                   this.max=false;
               }
            },
            getFile:function(){
              const that = this;
                $.ajax({
                    type:"get",
                    url:"http://api.magicloud.top/api/getFile",
                    data:{"token":this.token,"path":this.path},
                    dataType:"json",
                    success:function(data){
                        that.rightboxs = [];
                        // 把文件追加到页面中
                        for (let i=0;i<data.length;i++){
                            that.rightboxs.push(data[i]);
                        }
                    }
                });
            },
            getNewFile:function(box){
                    // 把路径存起来
                    this.oldpath.push(this.path);
                    // 如果oldpath有值 样式设置左箭头亮
                    $(".back-button").find(".glyphicon").css("opacity",1);
                    // 取出类型
                    let type = box.type;
                    // 如果是文件夹
                    if(type==="folder"){
                        // 得到新路径保存
                        this.path = box.path;
                        // 加载页面第二次执行取数据
                        this.getFile();
                    }else {
                        this.$emit('editorOpenEvent',box.path);
                    }
            },
            searchFile:function(){

              let el = event.currentTarget;
              let name = $(el).val();
              if(name===""){
                  this.getFile();
              }else {
                  const that = this;
                  $.ajax({
                      type:"get",
                      url:"http://api.magicloud.top/api/searchFile",
                      data:{"token":this.token,"path":that.path,"name":name},
                      dataType:"json",
                      success:function(data){
                          that.rightboxs= [];
                          for (let i =0;i<data.length;i++){
                              that.rightboxs.push(data[i]);
                          }
                      }
                  });
              }
            },
            activeBox:function(box){
                if(box!=null){
                    this.clearActive();
                    box.active = true;
                    this.path = box.path;
                }else {
                    this.path = $(event.currentTarget).attr("path");
                }
                this.getFile();
            },
            activeBoxR:function(box){
                this.clearActiveR();
                box.active = true;
            },
            clearActive:function(){
              let length = this.leftboxs.length;
              for(let i =0;i<length;i++){
                  if(this.leftboxs[i].active===true){
                      this.leftboxs[i].active=false;
                  }
              }
            },
            clearActiveR:function(){
                let length = this.rightboxs.length;
                for(let i =0;i<length;i++){
                    if(this.rightboxs[i].active===true){
                        this.rightboxs[i].active=false;
                    }
                }
            },
            back:function(){
                // 从oldpath中取最后一个路径 删除并保存在pop中
                let pop = this.oldpath.pop();
                // 如果pop不为空
                if(pop!=null){
                    // 把当前路径保存在新的数组里
                    this.newpath.push(this.path);
                    $(".forward-button").find(".glyphicon").css("opacity",1);
                    // 如果pop不为空 把保存的路径给path
                    this.path = pop;
                    // 加载页面执行
                    this.getFile();
                }
                // 判断oldpath是否为空
                if(this.oldpath.length===0){
                    // 如果oldpath里没有值样式就暗
                    $(".back-button").find(".glyphicon").css("opacity",0.15);
                }
            },
            forward:function(){
                // 从newpath里取出要前进的路径
                let go = this.newpath.pop();
                if(go!=null){
                    this.oldpath.push(this.path);
                    $(".back-button").find(".glyphicon").css("opacity",1);
                    this.path = go;
                    this.getFile();
                }
                if(this.newpath.length===0){
                    $(".forward-button").find(".glyphicon").css("opacity",0.15);
                }
            }

        },
        mounted:function(){

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
            this.token = getCookie('magicloud_token');
            //获取用户路径
            this.fixpath = this.homepath;
            this.path = this.nowpath;
            const that = this;
            $(".mac").draggable();
            $(".parent").attr("path",this.fixpath);
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
                }else {

                }
            });


            // 侧边栏
            $.ajax({
                type:"get",
                url:"http://api.magicloud.top/api/getFile",
                data:{"token":this.token,"path":that.fixpath},
                dataType:"json",
                success:function(data){
                    // that.leftboxs.push({"type":"folder","path":that.fixpath,"icon":"icon/house.png","name":"我的文档"})
                    for(let i=0;i<data.length;i++){
                        // 判断类型是不是文件夹，如果是就拼接字符串
                        if(data[i].type==="folder"){
                                that.leftboxs.push(data[i]);
                        }
                    }
                }
            });

            //加载页面第一次执行取数据
            this.getFile();


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
        box-shadow: 0px 5px 40px rgba(0, 0, 0, 0.4);
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
        box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.1);
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
        box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.1);
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
    .mac .mac--top .searchbar {
        padding-left: 25px;
        position: relative;
        top: 7px;
        height: 21px;
        border-radius: 4px;
        border: none;
        left: 9.5em;
        width: 17.8em;
        box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.1);
    }
    .mac .mac--top .searchbar:focus {
        outline-offset: -2px;
        outline: #84B9EF auto 5px;
    }
    .mac .mac--top .searchbar-overlay {
        position: relative;
        top: 7px;
        right: 7em;
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
    .content {
        width: 100%;
        height: 100%;
        background-color: #fff;
    }
    .content .left{
        width: 20%;
        float: left;
        height: 100%;
        background-color: #f0f0f0;
        border-right: 1px solid #f0f0f0;
    }
    .content .left .little{
        display: block;
        font-size: 13px;
        color: #858a8f;
        margin: 5px;
    }
    .content .left .yes{
        cursor: url("../../../../public/icon/Hand.png"),auto;
        height: 29px;
    }
    .content .left .parent img{
        margin-left:-13px;
    }
    .content .left .yes:hover{
        background-color: #e0e0e0;
    }
    .content .left .yes img{
        width: 20px;
        position: relative;
        left:20px;
        top:5px;
    }
    .content .left .yes .font {
        font-size: 14px;
        color: #4c4c4c;
        position: relative;
        left: 25px;
        top: 3px;
    }
    .content .left .ractive {
        background-color: #c8c8c8;
    }
    .content .right {
        width: 79%;
        float: left;
        overflow-y: auto;
         height: 100%;
    }
    .content .right .box{
        position: relative;
        width: 72px;
        height: 72px;
        float: left;
        margin-top: 10px;
        margin-left: 25px;
        text-align: center;
        margin-bottom: 30px;
        cursor: url("../../../../public/icon/Hand.png"),auto;
    }
    .content .right .box img {
        width: 100%;
        height: 100%;
    }
    .content .right .box span {
        margin-top: 10px;
        top: 9px;
        margin: 0 auto;
        padding: 3px 2px;
        font-size: 12px;
        border-radius: 3px;
        position: relative;
    }
    .content .right .box:hover{
        border-radius: 5px;
        background-color: #e0e0e0;
    }
    .content .right .ractive {
        border-radius: 5px;
        background-color: #e0e0e0;
    }
    .content .right .ractive span {
        color: #fff;
        background-color: #0863d9;
    }
</style>