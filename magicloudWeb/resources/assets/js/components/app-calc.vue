<template>
    <div class="container">
        <div class='row'>
            <div id='calculator-container' class=''>

                <div class="mac-buttons">
                    <div class="mac-close" @click="close"></div>
                    <div class="mac-minimize" @click="min"></div>
                </div>

                <div id="display-container">
                    <!-- <h1> display</h1> -->
                    <p id='working-display' class='display'>0</p>
                    <p id='main-display' class='display'>0</p>
                </div>

                <div id='calculator-inner' class=''>
                    <div class='btn-group'>
                        <button id='btn-clear' class="button btn-grey">ac</button>
                        <button id='btn-divide' class="button operator btn-yellow btn-divider-v btn-divider-h">&divide;</button>
                        <button id='btn-multiply' class="button operator btn-yellow btn-divider-h">&times;</button>
                        <button id='btn-backspace' class="button btn-red">&#9003;</button>
                    </div>

                    <div class='btn-group'>
                        <button id='btn-seven' class="button number btn-grey">7</button>
                        <button id='btn-eight' class="button number btn-grey">8</button>
                        <button id='btn-nine' class="button number btn-grey">9</button>
                        <button id='btn-subtract' class="button operator btn-yellow btn-divider-h">&minus;</button>

                    </div>

                    <div class='btn-group'>
                        <button id='btn-four' class="button number btn-grey">4</button>
                        <button id='btn-five' class="button number btn-grey">5</button>
                        <button id='btn-six' class="button number btn-grey">6</button>
                        <button id='btn-addition' class="button operator btn-yellow">+</button>
                    </div>

                    <div class='btn-group' style="position: relative;top: -70px;">
                        <button id='btn-one' class="button number btn-grey">1</button>
                        <button id='btn-two' class="button number btn-grey">2</button>
                        <button id='btn-three' class="button number btn-grey">3</button>

                    </div>

                    <div class='btn-group'>
                        <button id='btn-zero' class="button number btn-grey" style="position: relative;left: -210px;">0</button>
                        <button id='btn-period' class="button btn-grey" style="position: relative;left: 70px;top: -70px;">.</button>
                        <button id='btn-equals' class="button btn-green" style="position: relative;left: 70px;top: -70px;">=</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "app-calc",
        methods:{
            "close":function(){
                this.$emit('appRunEvent','calcRun_false');
                this.$emit('appRunEvent','calc_empty');
            },
            "min":function(){
                this.$emit('appMinEvent','calcMin_true');
            }
        },
        mounted:function(){
            $(document).ready(function () {
                $(".container").draggable();
                //variable controls what should happen after the equals button was pressed
                var wasEquals = false;

                //format a given number with commas as thousand's separator.
                //e.g. 1000 becomes 1,000 ; 1,000,000 becomes
                //supports decimals
                //returns a string
                function formatNumber(numToFormat) {
                    let decimals = '';
                    // remove any pre-existing commas as it will upset the parseFloat later on
                    numToFormat = numToFormat.toString().replace(/,/g, '');

                    //if the number contains a period, then preserve the decimal digits as toLocaleString() removes trailing zeros
                    if (numToFormat.indexOf('.') >= 0) {
                        decimals = '.' + numToFormat.split('.')[1];
                        numToFormat = numToFormat.split('.')[0];
                    }

                    // return the formatted number
                    return parseFloat(numToFormat).toLocaleString('en-US', {
                        maximumFractionDigits: 9
                    }) + decimals;
                }


                //handle numbers
                $('.number').click(function () {
                    //limit how many digits can be entered into the displays
                    if ($('#main-display').text().length > 10) return;
                    if ($('#working-display').text().length > 29) return;

                    //if the working display is showing 0, then overwrite it with a new digit
                    if ($('#working-display').text() === '0') {
                        $('#main-display').text($(this).text());
                        $('#working-display').text($(this).text());

                        //if the main display is showing 0, and Zero is not being entered append the digit to the working display
                    } else if ($('#main-display').text() === '0' && $(this).text() != '0') {
                        $('#main-display').text($(this).text());
                        $('#working-display').text($('#working-display').text() + $(this).text());

                        //if wasEquals then overwrite both displays with the new digit
                    } else if (wasEquals) {
                        $('#main-display').text($(this).text());
                        $('#working-display').text($(this).text());
                        wasEquals = false;

                        //otherwise append the digit and format the number on both displays
                    } else {
                        // $('#main-display').text($('#main-display').text() + $(this).text());
                        // $('#working-display').text($('#working-display').text() + $(this).text());

                        // append the new digit, format it, and display the new number
                        $('#main-display').text(formatNumber($('#main-display').text() + $(this).text()));

                        // retrieve the expreesion right up to the last operator but not the last number
                        let equation = $('#working-display').text().match(/.*[÷×−+]+(?![^[÷×−+]]+$)/g);
                        // clean-up so we dont append 'null' to the working display
                        if (!equation) equation = [];

                        //add the last digit, then extract and format the last number of the current equation...
                        let currentNumber = $('#working-display').text() + $(this).text();
                        currentNumber = formatNumber(currentNumber.match(/(\d+\.?,?)+(?=[^÷×−+]*$)/g));
                        //...unless zero is being pressed. Then dont add leading zeros to the equation
                        if (currentNumber != '0') $('#working-display').text(equation + currentNumber);
                    }
                });

                //handle operators
                $('.operator').click(function () {
                    //check that the screen is not full before adding more operators
                    if ($('#working-display').text().length > 28) return;

                    //if equals was pressed last, move the main display to the working display to build the next equation
                    if (wasEquals) $('#working-display').text($('#main-display').text());

                    let workingDisplay = $('#working-display').text();

                    //if the display is not showing 0, then append the operator
                    if ($('#main-display').text() !== '0' && $('#main-display').text() !== '0.') {

                        //if the last character in the working display is a period, then remove it to append operator
                        if (workingDisplay[workingDisplay.length - 1] === '.') {
                            $('#working-display').text(workingDisplay.substring(0, workingDisplay.length - 1) + $(this).text());

                        } else {
                            $('#working-display').text($('#working-display').text() + $(this).text());
                        }
                        //zero out the main display for the next number
                        $('#main-display').text('0');
                    };

                    //swap the operator around if the user changes his mind
                    if (/[÷×−+]$/.test(workingDisplay)) {
                        $('#working-display').text(workingDisplay.substring(0, workingDisplay.length - 1) + $(this).text());
                    }

                    //need to reset the wasEquals flag incase operator is being used right after the equals was pressed
                    wasEquals = false;
                });


                //handle period
                $('#btn-period').click(function () {

                    //if equals was pressed, reset the display with
                    if (wasEquals) {
                        $('#main-display').text('0.');
                        $('#working-display').text('0.');

                        //reset wasEquals so we can append a number instead of overwriting it
                        wasEquals = false;

                        //append only one period per number sequence
                    } else if ($('#main-display').text().indexOf('.') === -1) {
                        if ($('#main-display').text() === '0' && $('#working-display').text() !== '0') {
                            $('#working-display').text($('#working-display').text() + '0.');
                        } else {
                            $('#working-display').text($('#working-display').text() + '.');
                        }
                        $('#main-display').text($('#main-display').text() + '.');
                    }
                });

                //handle clear
                $('#btn-clear').click(() => {
                    $('#working-display').text('0');
                    $('#main-display').text('0');
                    wasEquals = false;
                });

                //handle equals
                $('#btn-equals').click(function () {
                    //if the equation contains digits and ends with a period or digit
                    if (/\d+(\.?$)(\d$)?/.test($('#working-display').text())) {

                        // convertHTML symbols in the equation to javascript arithmetic operators
                        var html = {
                            "÷": ")/",
                            "×": ")*",
                            "−": ")-",
                            "+": ")+"
                        };
                        let expr = $('#working-display').text()
                            .replace(/[÷×−+]/g, (char) => html[char]);

                        //remove any thousand separator formatting before evaluating
                        expr = expr.replace(/,/g, '');

                        //add parentheses to encapsulate the mathematical equation because eval won't do it
                        //otherwise it produces incorrect results
                        for (let i = 0; i < expr.split(')').length - 1; i++) {
                            expr = '(' + expr;
                        }
                        let result = eval(expr);

                        //if the result is too big to fit into the main display - use exponential notation
                        if (result.toString().length < 10) {
                            $('#main-display').text(formatNumber(result));
                        } else {
                            $('#main-display').text(result.toExponential(5));
                        }
                        //overwrite the equation with the result
                        // $('#working-display').text(formatNumber(result));

                        //retain the equation and append an equals sign
                        $('#working-display').text($('#working-display').text() + $(this).text());
                        wasEquals = true;
                    }
                });

                //handle backspace
                $('#btn-backspace').click(function () {

                    //if equals was pressed last, then do nothing
                    if (wasEquals) return;

                    let equation = $('#working-display').text().match(/.*[÷×−+]+(?![^[÷×−+]]+$)/g);
                    // clean-up in case it's 'null'
                    if (!equation) equation = [];

                    //add the last digit, then extract and format the last number of the current equation
                    let equationLastNumber = $('#working-display').text();
                    equationLastNumber = equationLastNumber.match(/(\d+\.?,?)+(?=[^÷×−+]*$)/g);

                    //if the main display has lots of numbers
                    if ($('#main-display').text().length > 1) {
                        // remove last digit from both displays
                        $('#main-display').text(
                            formatNumber($('#main-display').text().substring(
                                0, $('#main-display').text().length - 1)));
                        $('#working-display').text(equation + $('#main-display').text());

                        //if the equation's last number is '0.', then also remove the period, leaving the zero
                        if (equationLastNumber[0] === '0.') {
                            $('#working-display').text(
                                $('#working-display').text().substring(
                                    0, $('#working-display').text().length - 1));
                        }

                        //if the main display has one digit which is not zero and we dont have an equation
                    } else if ($('#main-display').text() !== '0' && equation.length === 0) {
                        // reset both displays
                        $('#main-display').text('0');
                        $('#working-display').text('0');

                        //if the main display has one digit which is not zero and we have an equation
                    } else if ($('#main-display').text() !== '0' && equation.length >= 1) {
                        // reset the main and remove last digit from main display
                        $('#main-display').text('0');
                        $('#working-display').text(
                            $('#working-display').text().substring(
                                0, $('#working-display').text().length - 1));
                    }
                });
            });
        }
    }
</script>

<style scoped>



    /*.col-xs-*/

    @media screen and (max-width: 767px) {
        body {
            font-size: 20px;
        }
    }


    /*.col-sm-*/

    @media only screen and (min-width: 768px) {
        body {
            font-size: 20px;
        }

    }


    /*.col-md-*/

    @media only screen and (min-width: 992px) {
        body {
            font-size: 20px;
        }

    }


    /*.col-lg-*/

    @media screen and (min-width: 1200px) {
        body {
            font-size: 26px;
        }
    }

    h1 {
        font-size: 2em;
    }

    a,
    a:visited,
    a:hover,
    a:focus {
        color: inherit;
        text-decoration: none;
        transition: .3s;
    }
    .container {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -140px;
        margin-top: -25%;
    }
    #calculator-container {
        float: none;
        width: 280px;
        height: auto;
        margin: 150px auto;
        background: #EEEEEE;
        box-shadow: 0px 6px 20px #808080;
    }

    #display-container {
        padding-top: 40px;
        border-bottom: 1px solid #e3e3e3;
        box-shadow: 0px 3px 5px rgba(175, 175, 175, 0.62);
        z-index: 1;
    }

    .mac-buttons {
        padding-left: 10px;
        padding-top: 8px;
        float: left;
        line-height: 0px;
        display: inline-block;
    }

    .mac-close {
        /* grey button */
        /*	background: #bfbfbf;*/
        /*	border: 1px solid #bfbfbf;*/
        background: #ff5c5c;
        border: 1px solid #e33e41;
        width: 11px;
        height: 11px;
        border-radius: 50%;
        display: inline-block;
        cursor: url("../../../../public/icon/Hand.png"),auto;

    }

    .mac-minimize {
        /* grey button */
        /*	background: #bfbfbf;*/
        /*	border: 1px solid #bfbfbf;*/
        background: #ffbd4c;
        border: 1px solid #e09e3e;
        width: 11px;
        height: 11px;
        border-radius: 50%;
        display: inline-block;
        cursor: url("../../../../public/icon/Hand.png"),auto;

    }

    .mac-zoom {
        /* grey button */
        /*	background: #bfbfbf;*/
        /*	border: 1px solid #bfbfbf;*/
        background: #00ca56;
        border: 1px solid #14ae46;
        width: 11px;
        height: 11px;
        border-radius: 50%;
        display: inline-block;
    }

    #calculator-inner {
        width: 287px;
        padding: 15px auto;
        border-right: 7px solid #37474F;
        z-index: 0;
    }

    .display {
        padding-right: 7px;
        text-align: right;
        color: #37474F;
    }

    #working-display {
        font-size: .75em;
        color: #546E7A;
    }

    #main-display {
        font-size: 2em;
        color: #37474F;
        margin: 0;
        z-index: 1;
    }

    .btn-group .button {
        width: 70px;
        height: 70px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
        float: left;
        border: none;
        outline: 0;
        transition: .05s;
    }

    .btn-group .button:active {
        background: pink;
    }

    .btn-grey {
        color: #546E7A;
        background: hsl(0, 0%, 93%);
    }

    .btn-grey:hover {
        background-color: #b8b9bf;
        background: hsl(0, 0%, 80%);
    }

    .btn-yellow {
        background-color: hsl(54, 100%, 62%);
        color: #546E7A;
    }

    .btn-yellow:hover {
        background-color: hsl(54, 80%, 52%);
    }

    .btn-red {
        background-color: hsl(4, 90%, 58%);
        color: #F5F5F5;
    }

    .btn-red:active {
        background-color: #ff6868 !important;
    }

    .btn-red:hover {
        background-color: hsl(4, 70%, 48%);
    }

    .btn-green {
        background-color: hsl(122, 39%, 49%);
        color: #F5F5F5;
    }

    .btn-green:hover {
        background-color: hsl(122, 39%, 44%);
    }

    .btn-green:active {
        background-color: #ed8d86 !important;
    }

    .btn-divider-v {
        border-right: 1px solid #CCDB96 !important;
    }

    .btn-divider-h {
        border-bottom: 1px solid #CCDB96 !important;
    }

    .operator {
        font-size: 1.5em;
    }

    .btn-warning {
        background: #FCEB3B;
        color: #546E7A;
    }

    .btn-success:focus {
        background-color: #5cb85c;
        border-color: #4cae4c;
        outline: none;
    }

    .btn-success:hover {
        background-color: #449d44;
    }

    .btn-warning:focus {
        background-color: #f0ad4e;
        border-color: #eea236;
        outline: none;
    }

    .btn-warning:hover {
        background-color: #ec971f;
    }

    .tall-btn {
        height: 97px;
        position: absolute;
        left: 145px;
        z-index: 1;
    }


    /*
    .dbl-btn {
        width: 92px;
    }


    /*
    .number-row {
        padding-top: 5px;
        position: relative;
    }
    */

    #btn-zero {
        /*	width: 92px;*/
    }

    #btn-clear {
        /*		width: 44px;*/
    }

    #btn-backspace {
        font-size: .80em;
        /*
        width: 44px;
        background: #F44336;
        color: #F5F5F5;
    */
    }

    #btn-period {
        /*	width: 45px;*/
        font-size: 1.5em;
    }

    #btn-addition {
        height: 140px;
        position: relative;
        z-index: 1;
    }

    #btn-equals {
        width: 140px;
    }

</style>