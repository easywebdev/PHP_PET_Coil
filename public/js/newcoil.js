$(document).ready(function() {
    // design select action
    $('#designID').change(function() {
        let designID = parseInt($('#designID').val());

        if(designID) {
            // Get data
            $.ajax({
                url: '/design/' + designID,
                type: 'GET',
                data: {
                    "id": designID
                },
                success: function(answer) {
                    //alert(JSON.stringify(answer));

                    $( "#designName" ).prop( "readonly", true );
                    $('#designName').val(answer.name);
                    $('#inner_d').val(answer.inner_d);
                    $('#outer_d').val(answer.outer_d);
                    $('#length').val(answer.length);
                }
            });
        }
        else {
            $( "#designName" ).prop( "readonly", false );
        }
    });

    // wire select action
    $('#wireID').change(function() {
        let wireID = parseInt($('#wireID').val());

        if(wireID) {
            // Get data
            $.ajax({
                url: '/wire/' + wireID,
                type: 'GET',
                data: {
                    "id": wireID
                },
                success: function(answer) {
                    //alert(JSON.stringify(answer));

                    $( "#wireName" ).prop( "readonly", true );
                    $('#wireName').val(answer.name);
                    $('#conductor_d').val(answer.conductor_d);
                    $('#full_d').val(answer.full_d);

                    // let selectedMaterial = $('#materialID option[value="' + answer.material.id +'"]')
                    // $(selectedMaterial).prop( "selected", true );
                    // $( "#materialName" ).prop( "disabled", true );
                    // $('#materialName').val(answer.material.name);
                    // $('#density').val(answer.material.density);
                    // $('#resistivity').val(answer.material.resistivity);
                    // $('#alphaT').val(answer.material.alphaT);
                }
            });
        }
        else {
            $( "#wireName" ).prop( "readonly", false );
        }
    });

    // Material select action
    $('#materialID').change(function() {
        let materialID = parseInt($('#materialID').val());

        if(materialID) {
            // Get data
            $.ajax({
                url: '/material/' + materialID,
                type: 'GET',
                data: {
                    "id": materialID
                },
                success: function(answer) {
                    //alert(JSON.stringify(answer));

                    $( "#materialName" ).prop( "readonly", true );
                    $('#materialName').val(answer.name);
                    $('#density').val(answer.density);
                    $('#resistivity').val(answer.resistivity);
                    $('#alphaT').val(answer.alphaT);
                }
            });
        }
        else {
            $( "#materialName" ).prop( "readonly", false );
        }
    });
});

// Save new coil function
function saveCoil()
{
    let dataCoil = $('#coil').serializeArray().reduce(function(a, x) { a[x.name] = x.value; return a; }, {});
    let dataDesign = $('#design').serializeArray().reduce(function(a, x) { a[x.name] = x.value; return a; }, {});
    let dataWire = $('#wire').serializeArray().reduce(function(a, x) { a[x.name] = x.value; return a; }, {});
    let dataMaterial = $('#material').serializeArray().reduce(function(a, x) { a[x.name] = x.value; return a; }, {});

    // Save
    $.ajax({
        url: '/save',
        type: 'POST',
        data: {
            '_token': dataCoil['_token'],
            'coil': dataCoil,
            'design': dataDesign,
            'wire': dataWire,
            'material': dataMaterial
        },
        success: function(answer) {
            //alert(JSON.stringify(answer));

            if(!answer.err) {
                //alert(JSON.stringify(answer.result));
                window.location.href = '/' + answer.coilID;

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