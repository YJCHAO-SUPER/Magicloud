<template>
                <div id="editorDiv">
                </div>
</template>

<script>
    export default {
        name: "app-aceEditor",
        props:["filepath","saveContent"],
        watch:{
          filepath(val){
              const that = this;
              $.ajax({
                  "url":"http://api.magicloud.top/api/getContent",
                  "type":"get",
                  "data":{"token":this.token,"path":this.filepath},
                  "dataType":"json",
                  success:function(data){
                      that.editor.session.setMode("ace/mode/"+data.language);
                      that.editor.setValue(data.content);
                  }
              });
          },
            saveContent(val){
              let content = this.editor.getValue();
                $.ajax({
                    "url":"http://api.magicloud.top/api/saveContent",
                    "type":"post",
                    "data":{"token":this.token,"path":this.filepath,"filecontent": content},
                    "dataType":"json",
                    success:function(data){
                        if(data.code=="200"){
                            console.log("save success");
                        }else {
                            console.log("save fault");
                        }
                    }
                });
            }
        },
        data:function(){
          return {
              "token":"",
              "editor":"",
              "content":""
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
            const that = this;
            $.ajax({
                "url":"http://api.magicloud.top/api/getContent",
                "type":"get",
                "data":{"token":this.token,"path":this.filepath},
                "dataType":"json",
                success:function(data){

                    that.editor = ace.edit("editorDiv");
                    //设置编辑器样式，对应theme-*.js文件

                    //设置代码语言，对应mode-*.js文件
                    that.editor.session.setMode("ace/mode/php");
                    //设置打印线是否显示
                    that.editor.setShowPrintMargin(false);
                    //设置是否只读
                    that.editor.setReadOnly(false);

                    //以下部分是设置输入代码提示的，如果不需要可以不用引用ext-language_tools.js
                    // this.ace.require("ace/ext/language_tools");
                    that.editor.setOptions({
                        autoScrollEditorIntoView: true,
                        copyWithEmptySelection: true
                    });
                    that.editor.setOption("mergeUndoDeltas", "always");
                    that.editor.setTheme("ace/theme/monokai");
                    document.getElementById('editorDiv').style.fontSize='14px';
                    that.editor.setValue(data.content);
                }
            });

        }
    }
</script>

<style scoped>
    #editorDiv {
        height: 100%;
    }


</style>