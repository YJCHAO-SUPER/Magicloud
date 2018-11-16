<template>
    <div class="window">
        <div class="handle" @dblclick.stop="minSize">
            <div class="buttons">
                <button class="close" @click="close">
                </button>
                <button class="minimize" @click="minSize">
                </button>
                <button class="maximize" @click="maxSize">
                </button>
            </div>
            <span class="title"></span>
        </div>
        <div class="terminal"></div>
    </div>
</template>

<script>
    export default {
        name: "app-terminal",
        data:function(){
            return {
                "token":"",
                "max":false,
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
            //         $(".window").css("height","218px");
            //     }
            // },
            // height(val){
            //     if(this.max===true){
            //         $(".window").css("height",val);
            //     }
            // }
        },
        mounted:function(){
            //执行
            this.$emit('appRunEvent','terminalRun_true');
            $(".window").draggable();
            let currentPath = "";
            const that = this;
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
            $.ajax({
                type:"post",
                url:"http://api.magicloud.top/api/init",
                data:{"token":that.token},
                dataType:"json",
                success:function(data){
                    title.text(data.title);
                    currentPath = data.currentPath;
                }
            });
            // UTILITY
            function getRandomInt(min, max) {
                return Math.floor(Math.random() * (max - min)) + min;
            }
            // END UTILITY

            // COMMANDS
            function clear() {
                terminal.text("");
            }

            function echo(args) {
                var str = args.join(" ");
                terminal.append(str + "\n");
            }

            // function fortune() {
            //     var xhr = new XMLHttpRequest();
            //     xhr.open('GET', 'https://cdn.rawgit.com/bmc/fortunes/master/fortunes', false);
            //     xhr.send(null);
            //
            //     if (xhr.status === 200) {
            //         var fortunes = xhr.responseText.split("%");
            //         var fortune = fortunes[getRandomInt(0, fortunes.length)].trim();
            //         terminal.append(fortune + "\n");
            //     }
            // }

            //ajax
            function sendCmd(name,args){

                $.ajax({
                    url:"http://api.magicloud.top/api/cmd",
                    type:"post",
                    data:{"cmd":name,"args":args,"token":that.token,"currentPath":currentPath},
                    dataType:"json",
                    success:function(data){
                        //设置标题
                        // title.text("1. marc@mbp: ~ (zsh)");
                        if(data.title!=null){
                            title.text(data.title);
                        }
                        if(data.clear!=null){
                            clear();
                        }
                        if(data.currentPath!=null){
                            currentPath = data.currentPath;
                        }
                        // // 将内容添加到控制台   换行符是\n
                        terminal.append(data.msg+"\n");
                        $(".terminal").scrollTop("9999")

                    }
                });


            }


            // END COMMANDS

            var title = $(".title");
            var terminal = $(".terminal");
            var prompt = "➜";
            var path = "~";

            var commandHistory = [];
            var historyIndex = 0;

            var command = "";
            var commands = [{
                "name": "clear",
                "function": clear
            }, {
                "name": "echo",
                "function": echo
            }];

            function processCommand() {
                var isValid = false;

                // Create args list by splitting the command
                // by space characters and then shift off the
                // actual command.

                var args = command.split(" ");
                var cmd = args[0];
                args.shift();

                // Iterate through the available commands to find a match.
                // Then call that command and pass in any arguments.
                for (var i = 0; i < commands.length; i++) {
                    if (cmd === commands[i].name) {
                        commands[i].function(args);
                        isValid=true;
                        break;
                    }else {
                        if(i===commands.length-1){
                            sendCmd(cmd,args);
                            isValid=true;
                            break;
                        }
                    }
                }

                // No match was found...
                if (!isValid) {
                    terminal.append("command not found: " + command + "\n");
                }

                // Add to command history and clean up.
                commandHistory.push(command);
                historyIndex = commandHistory.length;
                command = "";
            }

            function displayPrompt() {
                terminal.append("<span class=\"prompt\">" + prompt + "</span> ");
                terminal.append("<span class=\"path\">" + path + "</span> ");
            }

// Delete n number of characters from the end of our output
            function erase(n) {
                command = command.slice(0, -n);
                terminal.html(terminal.html().slice(0, -n));
            }

            function clearCommand() {
                if (command.length > 0) {
                    erase(command.length);
                }
            }

            function appendCommand(str) {
                terminal.append(str);
                command += str;
            }

            /*
                //	Keypress doesn't catch special keys,
                //	so we catch the backspace here and
                //	prevent it from navigating to the previous
                //	page. We also handle arrow keys for command history.
                */

            $(document).keydown(function(e) {
                e = e || window.event;
                var keyCode = typeof e.which === "number" ? e.which : e.keyCode;

                // BACKSPACE
                if (keyCode === 8 && e.target.tagName !== "INPUT" && e.target.tagName !== "TEXTAREA") {
                    e.preventDefault();
                    if (command !== "") {
                        erase(1);
                    }
                }

                // UP or DOWN
                if (keyCode === 38 || keyCode === 40) {
                    // Move up or down the history
                    if (keyCode === 38) {
                        // UP
                        historyIndex--;
                        if (historyIndex < 0) {
                            historyIndex++;
                        }
                    } else if (keyCode === 40) {
                        // DOWN
                        historyIndex++;
                        if (historyIndex > commandHistory.length - 1) {
                            historyIndex--;
                        }
                    }

                    // Get command
                    var cmd = commandHistory[historyIndex];
                    if (cmd !== undefined) {
                        clearCommand();
                        appendCommand(cmd);
                    }
                }
            });

            $(document).keypress(function(e) {
                // Make sure we get the right event
                e = e || window.event;
                var keyCode = typeof e.which === "number" ? e.which : e.keyCode;

                // Which key was pressed?
                switch (keyCode) {
                    // ENTER
                    case 13:
                    {
                        terminal.append("\n");
                        processCommand();
                        displayPrompt();
                        break;
                    }
                    default:
                    {
                        appendCommand(String.fromCharCode(keyCode));
                    }
                }
            });

// Set the window title
            title.text("1. marc@mbp: ~ (zsh)");

// Get the date for our fake last-login
            var date = new Date().toString(); date = date.substr(0, date.indexOf("GMT") - 1);

// Display last-login and promt
            terminal.append("Last login: " + date + " on ttys000\n"); displayPrompt();
        },
        methods:{
            "close":function(){
                this.$emit('appRunEvent','terminalRun_false');
                this.$emit('appRunEvent','terminal_empty');
                this.$emit('appEvent','terminal_""');
                $(document).unbind();
            },
            "maxSize":function(){
                if(this.max===false){
                    this.$emit('appMaxEvent','terminalMax_true');
                    this.max=true;
                }else {
                    this.$emit('appMaxEvent','terminalMax_false');
                    this.max=false;
                }
            },
            "minSize":function(){
                if(this.min===false){
                    this.$emit('appMinEvent','terminalMin_true');
                    this.min=true;
                }else {
                    this.$emit('appMinEvent','terminalMin_false');
                    this.min=false;
                }
            }
        }
    }

</script>

<style scoped>

    * {
        box-sizing: border-box;
    }

    textarea, input, button {
        outline: none;
    }
    .maxSize {
    top:25px !important;
    left:0 !important;
    width:100% !important;
    margin-left:0 !important;
    margin-right:0 !important;
    margin-top:0 !important;
    }

    .window-button, .window .buttons .close, .window .buttons .minimize, .window .buttons .maximize {
        padding: 0;
        margin: 0;
        margin-right: 4px;
        width: 12px;
        height: 12px;
        background-color: gainsboro;
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 6px;
        color: rgba(0, 0, 0, 0.5);
    }

    .window {
        animation: bounceIn 1s ease-in-out;
        width: 640px;
        height: 218px;
        left: 50%;
        margin-left: -320px;
        top: 50%;
        margin-top: -116px;
    }
    .window .handle {
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
    .window .buttons {
        position: absolute;
        float: left;
        margin: 0 8px;
    }
    .window .buttons .close {
        background-color: #ff6159;
    }
    .window .buttons .minimize {
        background-color: #ffbf2f;
    }
    .window .buttons .maximize {
        background-color: #25cc3e;
    }
    .window .terminal {
        padding: 4px;
        background-color: black;
        opacity: 0.7;
        height: 100%;
        color: white;
        font-family: 'Source Code Pro', monospace;
        font-weight: 200;
        font-size: 14px;
        white-space: pre-wrap;
        white-space: -moz-pre-wrap;
        white-space: -o-pre-wrap;
        word-wrap: break-word;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        overflow-y: auto;
    }
    .window .terminal::after {
        content: "|";
        animation: blink 2s steps(1) infinite;
    }

    .prompt {
        color: #bde371;
    }

    .path {
        color: #5ed7ff;
    }

    @keyframes blink {
        50% {
            color: transparent;
        }
    }
    @keyframes bounceIn {
        0% {
            transform: translateY(-1000px);
        }
        60% {
            transform: translateY(200px);
        }
        100% {
            transform: translateY(0px);
        }
    }
</style>