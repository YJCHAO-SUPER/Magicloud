<template>
    <div class="desktop-body">
        <header-nav-component v-on:appRunEvent="appRun"></header-nav-component>
        <desktop-dock-component v-on:appRunEvent="appRun" :appRuns="appRuns" v-on:appMinEvent="minCom"></desktop-dock-component>
        <desktop-apps-component v-on:appRunEvent="appRun" :appRuns="appRuns" :newfolder="newfolder" v-on:appMinEvent="minCom" :refresh="desktoprefresh"></desktop-apps-component>

    </div>
</template>

<script>
    Vue.component('header-nav-component',require('./header-nav.vue'));
    Vue.component('desktop-dock-component',require('./desktop-dock.vue'));
    Vue.component('desktop-apps-component',require('./desktop-apps.vue'));
    Vue.component('empty',require('./empty'));
    export default {
        name: "desktop",
        props: ["refresh"],
        data:function(){
          return {
              //todo bug1 terminalMin,chromeMin 子组件无法检测
              appRuns:{"terminalRun":false,"chromeRun":false,"calcRun":false,"aplayerRun":false,"terminal":"","chrome":"","calc":"","aplayer":"","setting":"","terminalMin":false,"chromeMin":false,"calcMin":false},
              desktoprefresh:1,
              newfolder:[]

          }
        },
        mounted(){
            console.log("桌面挂载成功！");
        },
        watch: {
          refresh(val){
              this.desktoprefresh=val;
          }
        },
        methods:{
            "appRun":function(el){
                let arr = el.split("_");
                switch (arr[0]){
                    case "terminal":{
                        this.appRuns.terminal = arr[1];
                        break;
                    }
                    case "chrome":{
                        this.appRuns.chrome = arr[1];
                        break;
                    }
                    case "calc": {
                        this.appRuns.calc = arr[1];
                        break;
                    }
                    case "aplayer": {
                        this.appRuns.aplayer = arr[1];
                        break;
                    }
                    case "folder": {
                        this.newfolder= [];
                        this.newfolder.push(arr[1]);
                        break;
                    }
                    case "setting":{
                        this.appRuns.setting = arr[1];
                        break;
                    }
                    case "terminalRun":{
                        if(arr[1]==="false"){
                            this.appRuns.terminalRun = false;
                        }else {
                            this.appRuns.terminalRun = true;
                        }
                        break;
                    }
                    case "chromeRun":{
                        if(arr[1]==="false") {
                            this.appRuns.chromeRun = false;
                        }
                        else {
                            this.appRuns.chromeRun = true;
                        }
                        break;
                    }
                    case "calcRun": {
                        if(arr[1]==="false"){
                            this.appRuns.calcRun = false;
                        }else {
                            this.appRuns.calcRun = true;
                        }
                        break;
                    }
                    case "aplayerRun": {
                        if(arr[1]==="false"){
                            this.appRuns.aplayerRun = false;
                        }else {
                            this.appRuns.aplayerRun = true;
                        }
                        break;
                    }
                    default:{

                    }
                }
            },
            minCom:function(el){
                let arr = el.split("_");
                if(arr[0]==="folder"){
                    // eval("this.appFolders"+"["+arr[2]+"].max="+arr[1]);
                }else {
                    eval("this.appRuns." + arr[0] + "=" + arr[1]);
                }
            }
        }
    }
</script>

<style scoped>
    .desktop-body {
        width: 100%;
        position: fixed;
        z-index: 1;
        display: flex;
        height: 100vh;
        background: url("../../../../public/Wallpaper/macOS-Sierra.jpg") center center no-repeat;
        background-size: cover;
        cursor: url("../../../../public/icon/macNormSel.png"),auto;
    }
</style>