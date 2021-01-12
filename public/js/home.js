// Variables
var chartB = new ChartBuilder(document.getElementById('chartB'), 'Magnetic field', 'I [A]', 'B [mT]', '#D0D0CE');
var chartW = new ChartBuilder(document.getElementById('chartW'), 'Power', 'I [A]', 'W [W]', 'red');
var chartR = new ChartBuilder(document.getElementById('chartR'), 'Resistance', 'T [C]', 'R [Ohm]', 'green');
var chartV = new ChartBuilder(document.getElementById('chartV'), 'Voltage', 'T [C]', 'V [V]', 'orange');

$(document).ready(function() {
    // coil select action
    $('#coil').change(function() {
        window.location.href = '/' + $('#coil').val();
    });

    // autocalculate at page loaded
    calculateCoil();

    // Set chart font size
    //setChartFonts();
});

// Action for browser window resizing
$(window).resize(function() {
    setChartFonts();
});

// Design select change action
$('#design').change(function() {
    let designID = $('#design').val();

    // Get data
    $.ajax({
        url: '/design/' + designID,
        type: 'GET',
        data: {
            "id": designID
        },
        success: function(answer) {
            //alert(JSON.stringify(answer));

            $('#inner_d').val(answer.inner_d);
            $('#outer_d').val(answer.outer_d);
            $('#length').val(answer.length);
        }
    });

});

// Wire select change action
$('#wire').change(function() {
    let wireID = $('#wire').val();

    // Get data
    $.ajax({
        url: '/wire/' + wireID,
        type: 'GET',
        data: {
            "id": wireID
        },
        success: function(answer) {
            //alert(JSON.stringify(answer));

            $('#conductor_d').val(answer.conductor_d);
            $('#full_d').val(answer.full_d);

            $('#density').val(answer.material.density);
            $('#resistivity').val(answer.material.resistivity);
            $('#alphaT').val(answer.material.alphaT);
        }
    });

});

// Material select change action
$('#material').change(function() {
    let materialID = $('#material').val();

    // Get data
    $.ajax({
        url: '/material/' + materialID,
        type: 'GET',
        data: {
            "id": materialID
        },
        success: function(answer) {
            //alert(JSON.stringify(answer));

            $('#density').val(answer.density);
            $('#resistivity').val(answer.resistivity);
            $('#alphaT').val(answer.alphaT);
        }
    });

});

// Calculate
function calculateCoil()
{
    // let dataCoil = $('#coildata').serializeArray().reduce(function(a, x) { a[x.name] = x.value; return a; }, {});
    // let chartBW = $('#chartBW').serializeArray().reduce(function(a, x) { a[x.name] = x.value; return a; }, {});
    // let chartRV = $('#chartRV').serializeArray().reduce(function(a, x) { a[x.name] = x.value; return a; }, {});
    // let data = Object.assign(dataCoil, chartBW, chartRV);
    let data = $('#coildata').serializeArray().reduce(function(a, x) { a[x.name] = x.value; return a; }, {});
    //console.log(data);

    // Calculate
    $.ajax({
        url: '/calculate',
        type: 'POST',
        data: data,
        success: function(answer) {
            //alert(JSON.stringify(answer));

            if(!answer.err) {
                //alert(JSON.stringify(answer.result));

                // fill calculation table results
                $('#N').text(answer.result.N);
                $('#lambda').text(answer.result.lambda);
                $('#G').text(answer.result.G);
                $('#L').text(answer.result.L);
                $('#m').text(answer.result.m);
                $('#R').text(answer.result.R);
                $('#T').text(answer.result.T);
                $('#II').text(answer.result.I);
                $('#V').text(answer.result.V);
                $('#W').text(answer.result.W);
                $('#B').text(answer.result.B);
                $('#Li').text(answer.result.Li);

                // build charts
                //alert(JSON.stringify(answer.chartBW[0]));
                chartB.buildChart(answer.chartBW[0]);
                chartW.buildChart(answer.chartBW[1]);
                chartR.buildChart(answer.chartRV[0]);
                chartV.buildChart(answer.chartRV[1]);
            }
            else {
                msg = 'Error list:\n';
                $.each(answer.err, function (key, value) {
                    msg += (key + 1) + '. ' + value + '\n';
                });
                alert(msg);
            }
        }
    });
}

// Save coil
function saveCoil()
{
    let dataCoil = $('#coildata').serializeArray().reduce(function(a, x) { a[x.name] = x.value; return a; }, {});
    let chartBW = $('#chartBW').serializeArray().reduce(function(a, x) { a[x.name] = x.value; return a; }, {});
    let chartRV = $('#chartRV').serializeArray().reduce(function(a, x) { a[x.name] = x.value; return a; }, {});
    let data = Object.assign(dataCoil, chartBW, chartRV);
    console.log(data);

    // Calculate
    $.ajax({
        url: '/update',
        type: 'POST',
        data: data,
        success: function(answer) {
            //alert(JSON.stringify(answer));

            if(!answer.err) {
                let msg = '';
                $.each(answer.result, function (key, value) {
                    msg += (key + 1) + '. ' + value + '\n';
                });
                alert(msg);
            }
            else {
                let msg = 'Error list:\n';
                $.each(answer.err, function (key, value) {
                    msg += (key + 1) + '. ' + value + '\n';
                });
                alert(msg);
            }
        }
    });
}

// Delete coil
function delCoil()
{
    let coilID = $('#coil').val();

    if(confirm('Do You really want to delete coil ' + $( '#coil option:selected' ).text())) {
        $.ajax({
            url: '/delcoil/' + coilID,
            type: 'GET',
            data: coilID,
            success: function(answer) {
                alert(answer);
                document.location.reload();
            }
        });
    }
    else {
        //alert('No');
    }
}

// Delete design
function delDesign()
{
    let designID = $('#design').val();

    if(confirm('Do You really want to delete design ' + $( '#design option:selected' ).text())) {
        $.ajax({
            url: '/deldesign/' + designID,
            type: 'GET',
            data: designID,
            success: function(answer) {
                alert(answer);
                document.location.reload();
            }
        });
    }
}

// Delete wire
function delWire()
{
    let wireID = $('#wire').val();

    if(confirm('Do You really want to delete wire ' + $( '#wire option:selected' ).text())) {
        $.ajax({
            url: '/delwire/' + wireID,
            type: 'GET',
            data: wireID,
            success: function(answer) {
                alert(answer);
                document.location.reload();
            }
        });
    }
}

// Delete material
function delMaterial()
{
    let materialID = $('#material').val();

    if(confirm('Do You really want to delete material ' + $( '#material option:selected' ).text())) {
        $.ajax({
            url: '/delmaterial/' + materialID,
            type: 'GET',
            data: materialID,
            success: function(answer) {
                alert(answer);
                document.location.reload();
            }
        });
    }
}

function setChartFonts()
{
    let fontSize =  $('html').css('font-size');
    fontSize = fontSize.replace('px', '');

    this.chartB.setFontSize(fontSize, fontSize, fontSize);
    this.chartW.setFontSize(fontSize, fontSize, fontSize);
    this.chartR.setFontSize(fontSize, fontSize, fontSize);
    this.chartV.setFontSize(fontSize, fontSize, fontSize);
}