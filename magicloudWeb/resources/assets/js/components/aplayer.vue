<template>
    <div id="player8" class="aplayer"></div>
</template>

<script>
    export default {
        name: "aplayer",
        mounted:function(){
            $(function(){
                const ap8 = new APlayer({
                    element: document.getElementById('player8'),
                    mutex: true,
                    theme: '#ad7a86',
                    order: 'random',
                    lrcType: 3,
                    fixed: true,
                });
                $.ajax({
                    url: 'https://api.i-meto.com/meting/api?server=netease&type=playlist&id=2176206803',
                    success: function (list) {
                        ap8.list.add(JSON.parse(list));
                    }
                });
            });
        }
    }
</script>

<style scoped>
    #player8 {
        z-index: 99999;
    }
</style>