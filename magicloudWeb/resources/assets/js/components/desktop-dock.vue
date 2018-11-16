<template>
    <div id="dock">
        <div class="icons">
            <!--<div class="icon"><img src="icon/folder.png" alt="folder"><div class="running"></div></div>-->
            <div class="icon" @click="appRun('terminal')"><img src="icon/terminal.png" alt="terminal"><div :class="{'running':appRuns.terminalRun}"></div></div>
            <div class="icon" @click="appRun('chrome')" ><img src="icon/Google_Chrome_icon_(2011).png" alt="Chrome"><div  :class="{'running':appRuns.chromeRun}"></div></div>
            <div class="icon" @click="appRun('calc')"><img src="icon/calc.png" alt="calc"><div :class="{'running':appRuns.calcRun}" ></div></div>
            <div class="icon" @click="unknow()"><img src="icon/calendar-icon.png" alt="Calendar"><div ></div></div>
            <div class="icon" @click="unknow()"><img src="icon/reminders-icon.png" alt="reminders"><div ></div></div>
            <div class="icon" @click="unknow()"><img src="icon/facetime-icon.png" alt="facetime"><div ></div></div>
            <div class="icon" @click="unknow()"><img src="icon/21cabddae0ef1e593f7d11a4262a3ec9-appstore.png" alt="App Store"><div> </div></div>
            <div class="icon" @click="unknow()"><img src="icon/contacts-icon.png" alt="contacts"><div ></div></div>
            <div class="icon" @click="unknow()"><img src="icon/mail-icon.png" alt="mail"><div ></div></div>
            <div class="icon" @click="unknow()"><img src="icon/maps-icon-os-x-300x300.png" alt="maps"><div></div></div>
            <div class="icon" @click="unknow()"><img src="icon/messages-icon.png" alt="messages"><div ></div></div>
            <div class="icon" @click="appRun('aplayer')"><img src="icon/itunes_5122x.png" alt="itunes"><div :class="{'running':appRuns.aplayerRun}"></div></div>
            <div class="icon settings" @click="appRun('setting')"><img src="icon/system-preferences-icon.png" alt="system preferences"></div>
            </div>
    </div>
</template>

<script>
    export default {
        name: "desktop-dock",
        props:["appRuns"],
        data:function(){
          return {

          }
        },
        mounted() {
            console.log('dock 挂载成功!.');
            //
            // let icons = [];
            // $(".icon").click(function(){
            //     icons[$(this).index()] = true;
            //     $(this).children(".running").css("display","block");
            // });
        },
        methods:{
            appRun:function(name){
                this.$emit('appRunEvent',name+'Run_true');
                this.$emit('appMinEvent',name+'Min_false');
                this.$emit('appRunEvent',name+'_app-'+name+'-component');
            },
            unknow:function(){
                alert("这个应用还没做呢！");
            }
        }
    }
</script>

<style scoped>
    #dock {
        position: absolute;
        bottom: 0;
        height: 50px;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        background-color: #cecece;
        padding: 5px 15px 13px;
        left: 50%;
        margin-left: -25%;
        z-index: 9999;
    }
    #dock .icons {
        text-align: center;
        width: 100%;
        display:inline-block;
    }
    .icons .icon {
        position: relative;
        width: 50px;
        display: inline-block;
        cursor: url('../../../../public/icon/Hand.png'),auto;
    }
    .icons .icon img {
        width: 50px;
        transition: .2s;
        height: 50px;
    }
    .icons .icon img:hover {
        transform: scale(1.2);
    }
    .icons .icon .running {
        display: block;
        content: " ";
        height: 5px;
        width: 5px;
        background-color: #fff;
        border-radius: 50%;
        position: absolute;
        top: 53px;
        left: 50%;
        margin-left: -2.5px;
    }
    .icons .settings {
        border-left: 1px solid #fff;
        padding-left: 10px;
    }
</style>