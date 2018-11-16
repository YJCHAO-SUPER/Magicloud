<template>
    <div class="screensaver">
        <div class="content">
            <time class="time" datetime=""></time>
            <time class="date" datetime=""></time>
        </div>
        <div class="unlock">click to unlock</div>
    </div>
</template>

<script>
    export default {
        name: "lock-screen",
        mounted:function(){
            function setTime(ts) {
                var date = new Date(ts);
                $('.time').text(date.toLocaleString(navigator.language, {
                    hour: '2-digit',
                    minute: '2-digit'
                })).attr('datetime', date.getHours() + ':' + date.getMinutes());
                $('.date').text(date.toLocaleString(navigator.language, {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                })).attr('datetime', date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate());
                setTimeout(function () {
                    setTime(Date.now());
                }, 1000);
            }
            setTime(Date.now());
            $('.screensaver').on('click', function () {
                $(this).fadeOut(500);
            });
        }
    }
</script>

<style scoped>
    *, *:after, *:before {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .screensaver {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 99999;
        width: 100%;
        height: 100%;
        background: linear-gradient(#24C6DC 10%, #514A9D 90%) whitesmoke;
        text-align: center;
        color: whitesmoke;
        font-weight: 300;
        cursor: url('../../../../public/icon/macNormSel.png'),auto;
    }
    .screensaver > .content {
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
    .screensaver > .content time {
        display: block;
        font-size: 1.5rem;
        line-height: 1.875rem;
    }
    .screensaver > .content time:first-of-type {
        font-size: 5rem;
        line-height: 6.25rem;
    }
    .screensaver > .unlock {
        position: absolute;
        top: 75%;
        left: 50%;
        -webkit-transform: translateX(-50%);
        transform: translateX(-50%);
        text-shadow: 0 0 5px whitesmoke;
        color: rgba(255, 255, 255, 0.5);
        -webkit-animation: flash 1500ms ease infinite alternate;
        animation: flash 1500ms ease infinite alternate;
    }

    @-webkit-keyframes flash {
        0% {
            opacity: 0;
        }
        75% {
            opacity: 1;
        }
    }

    @keyframes flash {
        0% {
            opacity: 0;
        }
        75% {
            opacity: 1;
        }
    }
</style>