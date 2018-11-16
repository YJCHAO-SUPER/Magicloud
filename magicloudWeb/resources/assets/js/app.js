
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

window.Vue = require('vue');
window.$ = require('jquery');
window.jQuery = window.$;
//jquery-ui
require('webpack-jquery-ui');
require('webpack-jquery-ui/css');
//jquery-ui-touch
require('./jquery.ui.touch-punch.min');
//播放器
window.APlayer = require('./APlayer.min.js');
require('./APlayer.min.css');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('login-component', require('./components/login.vue'));
Vue.component('lock-screen-component',require('./components/lock-screen.vue'));
Vue.component('desktop-component',require('./components/desktop.vue'));

const app = new Vue({
    el: '#app',
    data:function(){
      return {
          login:"",
          refresh:1
      }
    },
    methods:{
      "clickRefresh":function(){
          this.refresh = this.refresh+1;
      }

    },
    mounted:function(){
        window.oncontextmenu=function(e) {
//取消默认的浏览器自带右键 很重要！！
            e.preventDefault();
            let menu=document.querySelector("#rightmenu");
            menu.style.left=e.clientX+'px';
            menu.style.top=e.clientY+'px';
            menu.style.padding = "10px 0";
            menu.style.width='190px';
            menu.style.cursor="url('icon/Hand.png'),auto";
        };
        window.onclick=function(e){
    //用户触发click事件就可以关闭了，因为绑定在window上，按事件冒泡处理，不会影响菜单的功能

            document.querySelector('#rightmenu').style.width=0;
            document.querySelector('#rightmenu').style.padding=0;
        };
        //使用html5的Page Visibility API来实现
        document.addEventListener('visibilitychange', function() {
            let isHidden = document.hidden;
            if (isHidden) {
                // 当前标签失去焦点
                $(".screensaver").show();

            } else {
                // 获得焦点了
            }
        });
        //获取token
        getCookie('magicloud_token');
        if(getCookie('magicloud_token')==""){
            this.login="login-component";
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
    }
});
