<template>
    <div class="window">
        <div class="top" @dblclick="maxSize">
            <div class="panel">
                <span class="first" @click="close"></span>
                <span class="second" @click="minSize"></span>
                <span class="third" @click="maxSize"></span>
            </div>

            <div class="nav">
                <span class="prev active"><img src="../../../../public/icon/left.png" style="width: 12px;"></span>
                <span class="next"><img src="../../../../public/icon/right.png" style="width: 12px;"></span>
                <span class="set"><img src="../../../../public/icon/refresh.png" style="width: 15px;"></span>

                <span class="address">
        <input type="text" value="blog.llllhf.com" class="address" editable="true" id="address">
        <i class="fa fa-refresh"></i>
      </span>


            </div>
            <div class="nav right">
                <span class="share"><img src="../../../../public/icon/download.png" style="width: 15px;"></span>
                <span class="tabs">
        <span class="square front"></span>
        <span class="square behind"></span>
      </span>
            </div>

            <span class="new">
      <span class="plus x"></span>
      <span class="plus y"></span>
    </span>

        </div>

        <div class="inside">
            <!--<div class="blok">-->
            <!--</div>-->
            <!--<div class="blok">-->
            <!--</div>-->
            <!--<div class="blok" style="margin:0;">-->
            <!--</div>-->
            <iframe src="http://blog.llllhf.com" frameborder="0" style="width: 100%;height: 90%;" id="iframe"></iframe>
        </div>

    </div>
</template>

<script>
    export default {
        name: "app-chrome",
        data:function(){
            return {
                "max": false,
                "min":false,
                "height":0
            }
        },
        watch:{
            // max(val){
            //     if(val===true){
            //         $(".window").addClass("maxSize");
            //         $(".window").css("height",this.height);
            //     }else {
            //         $(".window").removeClass("maxSize");
            //         $(".window").css("height","500px");
            //     }
            // },
            // height(val){
            //     if(this.max===true){
            //         $(".window").css("height",val);
            //     }
            // }
        },
        mounted:function(){
            this.$emit('appRunEvent','chromeRun_true');
            const that = this;
            this.height = document.documentElement.clientHeight;
            window.onresize = () => {
                return (() => {
                    that.height = document.documentElement.clientHeight;
                })()
            };
            $( ".window" ).draggable({ cancel: ".inside,input,textarea" });
            $("input.address").focus(function(){
                $(".fa-refresh").hide(500);
                this.select();
            }).focusout(function(){
                $(".fa-refresh").show(500);
            });

            $(".window").keypress(function(e){
                let keynum = (event.keyCode ? event.keyCode : event.which);
                if(keynum == '13'){
                    let address = "http://"+$("#address").val();
                    $("#iframe").attr("src",address);
                }
            });

            $(".set").click(function(){
                let address = "http://"+$("#address").val();
                $("#iframe").attr("src",address);
            })

        },
        methods:{
            "close":function(){
                this.$emit('appRunEvent','chromeRun_false');
                this.$emit('appRunEvent','chrome_empty');
                this.$emit('appEvent','chrome_""');
            },
            "maxSize":function(){

                if(this.max===false){
                    console.log(this.max);
                    this.max=true;
                    this.$emit('appMaxEvent','chromeMax_true');
                }else {
                    this.max=false;
                    this.$emit('appMaxEvent','chromeMax_false');
                }
            },
            "minSize":function(){
                if(this.min===false){
                    this.$emit('appMinEvent','chromeMin_true');
                    this.min=true;
                }else {
                    this.$emit('appMinEvent','chromeMin_false');
                    this.min=false;
                }
            }
        }
    }
</script>

<style scoped>
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
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        -moz-box-shadow: 0 4px 12px rgba(0,0,0,.5);
        -webkit-box-shadow: 0 4px 12px rgba(0,0,0,.5);
        box-shadow: 0 4px 12px rgba(0,0,0,.5);
        width: 800px;
        margin:auto;
        top: 50%;
        margin-top: -250px;
        left: 50%;
        margin-left: -400px;
        overflow:hidden;
        border:1px solid #C1C2C2;
        height: 500px;
    }

    .inside {
        background:#fff;
        overflow:hidden;
        padding:10px;
        height: 100%;
    }
    .inside .blok {
        width:32%;float:left;margin-right:1.5%;
        height:50px;
        background:#efefef;
    }
    .top {
        padding:7px 0;
        position:relative;
        background: #f1f1f1;
        background: -moz-linear-gradient(top, #E9E9E9 3%, #d8d8d8 100%);
        background: -webkit-linear-gradient(top, #E9E9E9 3%, #d8d8d8 100%);
        background: -o-linear-gradient(top, #E9E9E9 3%, #d8d8d8 100%);
        background: -ms-linear-gradient(top, #E9E9E9 3%, #d8d8d8 100%);
        background: linear-gradient(to bottom, #E9E9E9 3%, #d8d8d8 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f1f1f1', endColorstr='#d8d8d8', GradientType=0 );

        -webkit-box-shadow: inset 0px 1px 1px 0px rgba(255, 255, 255, 0.76);
        -moz-box-shadow:    inset 0px 1px 1px 0px rgba(255, 255, 255, 0.76);
        box-shadow:         inset 0px 1px 1px 0px rgba(255, 255, 255, 0.76);

        overflow:hidden;
        border-bottom:2px solid #BDBCC1;
    }

    .top > div {
        float:left;
    }


    .panel {
        padding-left:9px;
        padding-top:2px;
    }

    .panel > span {
        display:inline-block;
        float:left;
        width:12px;
        height:12px;
        margin-right:7px;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        border-radius: 6px;
        cursor:pointer;

    }

    .panel span.first {
        background:#FF5F4F;
    }

    .panel span.second {
        background:#F9C206;
    }

    .panel span.third {
        background:#19CC32;
    }


    .nav {
        overflow:hidden;
    }

    .nav > span {
        display:inline-block;
        float:left;
        background:#FBFBFB;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        height:23px;
        padding:0 8px;
        cursor:pointer;
        color:#B4B4B4;
        border-bottom:1px solid #CECECE;
    }
    .nav > span:hover {
        background:#f2f2f2;
        color:#666;
    }
    .nav > span i.fa {
        font-size:23px;
    }

    .nav span.active {
        color:#707070;
    }

    .nav span.prev {
        margin-right:1px;
        margin-left:7px;
    }

    .nav span.next {
        margin-right:7px;
    }

    .nav span.set i {
        font-size:14px;
        position:relative;
        top:3px;
    }

    .nav span.address {
        position: absolute;
        width:400px;
        left: 50%;
        margin-left: -200px;
        display:inline-block;
        background:#fff;
        line-height:23px;
        padding:0;
        text-align:center;
    }
    .nav span.address > input {
        font-size:12px;
        color:#505050;
        border:none;
        background:none;
        text-align:center;
        position:relative;
        width:300px;
    }

    .nav span.address > input:focus {
        outline:none;
    }

    .nav span.address > input.class {
        text-align:left;
    }



    .nav span.address > i.fa {
        position:absolute;
        right:5px;
        top:7px;
        font-size:11px;
        color:#010101;
    }

    .nav.right {
        float:right !important;
        margin-right:35px;
    }

    .nav span.share {
        margin-right:7px;
    }
    .nav span.share > i.fa {
        font-size:11px;
        position:relative;
        top:2px;
    }

    .nav span.tabs {
        position:relative;
        width:26px;
        padding:0;
    }

    .nav span.tabs span {
        height:7px;
        width:7px;
        border:1px solid #B4B4B4;
        display:inline-block;
        position:absolute;
        background:#FBFBFB;
    }

    .nav span.tabs span.front {
        top:8px;
        left:6px;
        z-index:6;
    }

    .nav span.tabs span.behind {
        top:6px;
        left:8px;
        z-index:5;
    }

    .nav span.tabs:hover span {
        border:1px solid #666;
    }

    span.new {
        cursor:pointer;
        position:absolute;
        right:0;
        bottom:0;
        background:#CACACA;
        width:23px;
        height:23px;
        text-align:center;
        line-height:23px;
        border-top:1px solid #C1C2C2;
        border-left:1px solid #C1C2C2;
    }

    span.new:hover {
        -webkit-box-shadow: inset 0px 1px 1px 0px rgba(0, 0, 0, 0.1);
        -moz-box-shadow:    inset 0px 1px 1px 0px rgba(0, 0, 0, 0.1);
        box-shadow:         inset 0px 1px 1px 0px rgba(0, 0, 0, 0.1);
    }
    span.new .plus {
        position:absolute;
        background:#b0b0b0;
        display:inline-block;
    }

    span.new .plus.x {
        height:1px;
        width:14px;
        top:12px;
        right:0;
        left:0;
        margin:auto;
    }

    span.new .plus.y {
        height:14px;
        width:1px;
        bottom:0;
        top:0;
        margin:auto;

    }
</style>