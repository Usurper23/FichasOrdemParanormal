<script>
    var typingTimer;                //timer identifier
    var doneTypingInterval = 2500;  //time in ms, 5 seconds for example
    var $note = $('#notes .note');

    function updtvida(valor, ficha) {
        $.post({
            url: '?id=<?php echo $id;?>',
            data: {status: 'upv', ficha: ficha, value: valor},
        }).done(function (data) {
            $("#saude").load(location.href + " #saude>*");
        })
    }//Atualizar vida npc
    function updtsan(valor, ficha) {
        $.post({
            url: '?id=<?php echo $id;?>',
            data: {status: 'usan', ficha: ficha, value: valor},
        }).done(function (data) {
            $("#saude").load(location.href + " #saude>*");
        })
    }//Atualizar Sanidade npc
    function adicionariniciativa() {
        $.post({
            data: {status: 'criariniciativa'},
            url: '?id=<?=$id;?>',
            dataType: ""
        }).done(function (data) {
            location.reload();
        })
    }

    function submitiniciativa() {
        $.post({
            url: '?id=<?=$id;?>',
            dataType: '',
            data: $('#iniciativa :input').serialize(),
            success: function (data) {
            }
        });
    }

    function deletariniciativa(iniciativa_id) {
        $.post({
            data: {status: 'deleteini', iniciativa_id: iniciativa_id},
            url: '?id=<?=$id;?>',
        }).done(function () {
            location.reload();
        })
    }

    function deletnpc(id) {
        $.post({
            data: {status: 'deletenpc', npc: id},
            url: '?id=<?=$id;?>',
        }).done(function () {
            location.reload();
        })
    }

    updateIndex = function (e, ui) {
        $('td.index', ui.item.parent()).each(function (i) {
            $(this).html(i + 1);
        });
        $('input.hidden', ui.item.parent()).each(function (i) {
            $(this).val(i + 1);
        });
        submitiniciativa();
    };

    function updtpe(id) {
        var checkboxes = $('#npc' + id + ' .pontos_esforco input:checkbox:checked').length;
        $.post({
            url: '?id=<?php echo $id;?>',
            data: {status: 'pe', value: checkboxes, npc: id},
        }).done(function () {
            $("#npc" + id + " .pontos_esforco").load("?id=<?php echo $id;?> #npc" + id + " .pontos_esforco");
        })
    }

    function doneTyping() {
        sync = $("#noteform").serialize();
        $.post({
            url: "",
            data: sync,
        }).done(function () {
            $("#syncnotes").attr("class", "text-success fa-regular fa-cloud-check");
        }).fail(function () {
            $("#syncnotes").attr("class", "text-danger fa-regular fa-cloud-x");
        })
    }

    function addnote() {
        $.post({
            data: {status: 'addnote'},
            url: "",
        }).done(function (data) {
            location.reload();
        });
    }

    function deletenote(id) {
        $.post({
            data: {status: 'deletenote', note: id},
            url: "",
        }).done(function (data) {
            location.reload();
        });
    }
    function mostrarresultado(data){
        $("#valordados1,#valordados2,#valordados3").hide()
        var dados1 = data['d0'];
        var dados2 = data['d1'];
        var dados3 = data['d2'];
        if (dados1) {
            $("#valordados1").show()
            var dado1 = dados1['dado'];
            let d1r1 = dados1[dado1]["d1"] ? ' ' + dados1[dado1]["d1"] : '';
            let d1r2 = dados1[dado1]["d2"] ? ', ' + dados1[dado1]["d2"] : '';
            let d1r3 = dados1[dado1]["d3"] ? ', ' + dados1[dado1]["d3"] : '';
            let d1r4 = dados1[dado1]["d4"] ? ', ' + dados1[dado1]["d4"] : '';
            let d1r5 = dados1[dado1]["d5"] ? ', ' + dados1[dado1]["d5"] : '';
            let d1r6 = dados1[dado1]["d6"] ? ', ' + dados1[dado1]["d6"] : '';
            let d1r7 = dados1[dado1]["d7"] ? ', ' + dados1[dado1]["d7"] : '';
            let d1r8 = dados1[dado1]["d8"] ? ', ' + dados1[dado1]["d8"] : '';
            let d1r9 = dados1[dado1]["d9"] ? ', ' + dados1[dado1]["d9"] : '';
            let d1r0 = dados1[dado1]["d10"] ? ', ' + dados1[dado1]["d10"] : '';
            $("#dado1").html(dado1);
            $("#valores1").html(d1r1 + d1r2 + d1r3 + d1r4 + d1r5 + d1r6 + d1r7 + d1r8 + d1r9 + d1r0);
        } else {
            $('main button').attr('disabled', false);
        }
        if (dados2) {
            $("#valordados2").show()
            const dado2 = dados2['dado'];
            let d2r1 = dados2[dado2]["d1"] ? ' ' + dados2[dado2]["d1"] : '';
            let d2r2 = dados2[dado2]["d2"] ? ', ' + dados2[dado2]["d2"] : '';
            let d2r3 = dados2[dado2]["d3"] ? ', ' + dados2[dado2]["d3"] : '';
            let d2r4 = dados2[dado2]["d4"] ? ', ' + dados2[dado2]["d4"] : '';
            let d2r5 = dados2[dado2]["d5"] ? ', ' + dados2[dado2]["d5"] : '';
            let d2r6 = dados2[dado2]["d6"] ? ', ' + dados2[dado2]["d6"] : '';
            let d2r7 = dados2[dado2]["d7"] ? ', ' + dados2[dado2]["d7"] : '';
            let d2r8 = dados2[dado2]["d8"] ? ', ' + dados2[dado2]["d8"] : '';
            let d2r9 = dados2[dado2]["d9"] ? ', ' + dados2[dado2]["d9"] : '';
            let d2r0 = dados2[dado2]["d10"] ? ', ' + dados2[dado2]["d10"] : '';
            $("#dado2").html(dado2);
            $("#valores2").html(d2r1 + d2r2 + d2r3 + d2r4 + d2r5 + d2r6 + d2r7 + d2r8 + d2r9 + d2r0);
        }
        if (dados3) {
            $("#valordados3").show()
            var dado3 = dados3['dado'];
            let d3r1 = dados3[dado3]["d1"] ? ' ' + dados3[dado3]["d1"] : '';
            let d3r2 = dados3[dado3]["d2"] ? ', ' + dados3[dado3]["d2"] : '';
            let d3r3 = dados3[dado3]["d3"] ? ', ' + dados3[dado3]["d3"] : '';
            let d3r4 = dados3[dado3]["d4"] ? ', ' + dados3[dado3]["d4"] : '';
            let d3r5 = dados3[dado3]["d5"] ? ', ' + dados3[dado3]["d5"] : '';
            let d3r6 = dados3[dado3]["d6"] ? ', ' + dados3[dado3]["d6"] : '';
            let d3r7 = dados3[dado3]["d7"] ? ', ' + dados3[dado3]["d7"] : '';
            let d3r8 = dados3[dado3]["d8"] ? ', ' + dados3[dado3]["d8"] : '';
            let d3r9 = dados3[dado3]["d9"] ? ', ' + dados3[dado3]["d9"] : '';
            let d3r0 = dados3[dado3]["d10"] ? ', ' + dados3[dado3]["d10"] : '';
            $("#dado3").html(dado1);
            $("#valores3").html(d3r1 + d3r2 + d3r3 + d3r4 + d3r5 + d3r6 + d3r7 + d3r8 + d3r9 + d3r0);
        }
        $("#resultado").html(data.print);
        new bootstrap.Toast($('#Toastdados')).show();
    }
    $(document).ready(function () {

        $('#rolardadosbutton').on('click', function (){
            console.log("data");
            let dado = $("#rolardadosinput").val();
            $('#returncusdados').html("");
            let pattern = /^[d0-9+-]+\S$/g;
            let result = dado.match(pattern);
            if(result) {
                $.post({
                    url: '',
                    data: {status: 'roll', dado: dado},
                    dataType: 'JSON'
                }).done(function (data) {
                    if (data.success) {
                        mostrarresultado(data);
                    } else {
                        $('#returncusdados').html("<div class='alert alert-danger'>" + data.msg + "</div>");
                    }
                }).fail(function () {
                    $('#returncusdados').html("<div class='alert alert-danger'>Houve um erro, contate um administrador.</div>");
                })
            } else {
                $('#returncusdados').html("<div class='alert alert-danger'>Preencha o campo da forma correta</div>");
            }
        })


        $note.on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        $note.on('keydown', function () {
            clearTimeout(typingTimer);
            $("#syncnotes").attr("class", "text-warning fa-solid fa-arrows-rotate fa-spin");
        });


        $('#formadd').submit(function (e) {
            console.log("a");
            e.preventDefault();
            var form = $(this);
            $.post({
                beforeSend: function () {
                    $("#formadd input, #formadd button").attr('disabled', true);
                    $("#msgadd").html("<div class='alert alert-warning'>Aguarde enquanto verificamos os dados...</div>");
                },
                url: "",
                data: form.serialize(),
                dataType: "JSON",
                error: function (data) {
                    $("#formadd input, #formadd button").attr('disabled', false);
                    $("#msgadd").html("<div class='alert alert-danger'>Houve um erro ao fazer a solicitação, contate um administrador!</div>");
                },
            }).done(function (data) {
                if (data.msg) {
                    if (!data.success) {
                        $("#msgadd").html('<div class="alert alert-danger">' + data.msg + "</div>");
                        $("#formadd input, #formadd button").attr('disabled', false);
                    } else {
                        if (data.type == 1) {
                            $("#msgadd").html('<div class="alert alert-success">' + data.msg + '</div>');
                            setTimeout(function () {
                                $("#formadd input, #formadd button").attr('disabled', false);
                            }, 200)
                        } else {
                            $("#msgadd").html('<div class="alert alert-success">' + data.msg + ' <a href="https://fichasop.cf/?convite=1&email=' + data.email + '">https://fichasop.cf/?convite=1&email=' + data.email + '</a></div>');
                            setTimeout(function () {
                                $("#formadd input, #formadd button").attr('disabled', false);
                            }, 200)
                        }
                    }
                }

            });
        });
        $('#formaddnpc').submit(function (e) {
            console.log("a");

            e.preventDefault();
            var form = $(this);
            $.post({
                url: "",
                data: form.serialize(),
                beforeSend() {
                    $("#formaddnpc button, #formaddnpc input").attr('disabled', true)
                }
            }).done(function (data) {
                location.reload();
            });
        });
        $(".iniciativa").dblclick(function () {
            $(this).children("input").attr('readonly', false).toggleClass('border-0').delay(200).focus();
        })
        $(".iniciativa input").focusout(function () {
            let attr = $(this).attr('readonly');
            if (typeof attr !== 'undefined' && attr !== false) {
                $(this).attr('readonly', true)
            } else {
                $(this).attr('readonly', true).toggleClass('border-0')
                submitiniciativa();
            }
        })
        $(".up,.down").click(function () {
            const item = $(this).parents("tr:first");
            const ui = {item};
            if ($(this).is(".up")) {
                item.insertBefore(item.prev());
            } else {
                item.insertAfter(item.next());
            }
            updateIndex('', ui);
        });
        $('#refreshficha').click(function () {
            $('#fichasperson').load('?id=<?php echo $id;?>' + ' #fichasperson>*')
            $('#refreshficha').attr('disabled', true)
            setTimeout(function () {
                $('#refreshficha').attr("disabled", false)
            }, 2000);
        })
    });
</script>