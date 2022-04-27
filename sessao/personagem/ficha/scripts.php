<script>
    <?php if ($edit){?>
    function deletehab(id) {
        $.post({
            url: '?id=<?php echo $id;?>',
            data: {status: 'delethab', hid: id}
        }).done(function () {
            location.reload();
        })
    }// Deletar Habilidade
    function deletepro(id) {
        $.post({
            url: '?id=<?php echo $id;?>',
            data: {status: 'deletpro', pid: id}
        }).done(function () {
            location.reload();
        })
    }// Deletar Proeficiencia
    function cleanedit() {
        $('#armadelet').html('');
        $('#deletarmaid').val('');
        $('#editarmatitle, #enome').html('');
        $('#etipo').html('');
        $('#eataque').html('');
        $('#ealcance').html('');
        $('#edano').html('');
        $('#ecritico').html('');
        $('#erecarga').html('');
        $('#eespecial').html('');
        $('#editarmaid').val('');
        $('#enom').html('');
        $('#edes').html('');
        $('#epes').html('');
        $('#epre').html('');
        $('#edititid').val('');
        $('#anom').html('');
        $('#ades').html('');
        $('#apes').html('');
        $('#apre').html('');
        $('#additemid').val('');
    }  // Resetar
    function deletearma(id) {
        $('#armadelet').html($("#armaid" + id + " .arma").text());
        $('#deletarmaid').val(id);
    }//Deletar Arma
    function deleteitem(id) {
        $.post({
            url: '?id=<?php echo $id;?>',
            data: {status: 'delitem', iid: id}
        }).done(function () {
            location.reload();
        })
    }//Deletar Item
    function deleteritual(id) {
        $.post({
            url: '?id=<?php echo $id;?>',
            data: {status: 'deleteritual', rid: id}
        }).done(function (data) {
            location.reload();
        })
    }//Deletar Item
    function editarma(id) {
        $('#editarmatitle, #enome').val($("#armaid" + id + " .arma").text());
        $('#etipo').val($("#armaid" + id + " .tipo").text());
        $('#eataque').val($("#armaid" + id + " .ataque").text());
        $('#ealcance').val($("#armaid" + id + " .alcance").text());
        $('#edano').val($("#armaid" + id + " .dano").text());
        $('#ecritico').val($("#armaid" + id + " .critico").text());
        $('#erecarga').val($("#armaid" + id + " .recarga").text());
        $('#eespecial').val($("#armaid" + id + " .especial").text());
        $('#editarmaid').val(id);
    }// Editar Arma
    function edititem(id) {
        $('#edititemtitle, #enom').val($("#itemid" + id + " .nome").text());
        $('#edes').val($("#itemid" + id + " .desc").text());
        $('#epes').val($("#itemid" + id + " .espaco").text());
        $('#epre').val($("#itemid" + id + " .prestigio").text());
        $('#edititid').val(id);
    }// Editar Item
    function updtvida(valor) {
        $.post({
            url: '?id=<?php echo $id;?>',
            data: {status: 'upv', value: valor},
        }).done(function () {
            $("#saude").load(location.href + " #saude>*");
        })
    }//Atualizar vida
    function updtsan(valor) {
        $.post({
            url: '?id=<?php echo $id;?>',
            data: {status: 'usan', value: valor},
        }).done(function () {
            $("#saude").load(location.href + " #saude>*");
        })
    }// Atualizar Sanidade
    function rolar(dado, dano = 0) {
        $("main button").attr("disabled", true)
        $.post({
            url: "./rolar.php",
            data: {dado, dano},
            dataType: "JSON",
        }).done(function (data) {
            mostrarresultado(data);
        }).fail(function () {
            new bootstrap.Toast($('#Toastdados')).show();
            $('#resultado,#dado1,#dado2,#dado3,#valores1,#valores2,#valores3').html('');
            $('#valordados1,#valordados2,#valordados3').hide();
            $('#resultado').html('FALHA AO RODAR DADO, VERIFICAR SE ESTÀ CORRETO!');
            $('main button').attr('disabled', false);
        })
    }// Mostrar resultado dados
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
    $.fn.isValid = function () {
        return this[0].checkValidity()
    } // Função para checar validade de formularios
    $(document).ready(function () {
        $('#rolardadosbutton').on('click', function (){
            console.log("data");
            let dado = $("#rolardadosinput").val();
            $('#returncusdados').html("");
            let pattern = /^[d\d-+|*/AEFGINOPRTV]+\S$/g;
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

        $(".fa-dice-d20").hover(function () {
            $(this).toggleClass("fa-spin");
        });

        $('#prev').html('<img class="position-absolute rounded-circle border border-light" style="max-width:100px;" src="' + $('#fotourl').val() + '">');
        $('#fotourl').on('input', function () {
            var src = jQuery(this).val();

            if (!src.match("^https?://(?:[a-z\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpg|png|jpeg|webp)$") || src == "") {
                $("#warning").html("Precisa ser HTTPS, e Terminar com com extensão de imagem(.jpg, .png ...)!");
                $('#prev').html('');
                return false;
            } else {
                $("#warning").html("");
                $('#prev').html('<img class="position-absolute rounded-circle border border-light" style="max-width:100px;" src="' + src + '">');
            }

        })
        $('#foto').change(function () {
            let fotovalor = $('#foto').val()
            if (fotovalor == '9') {
                $('#divfotourl').show();
                $("#fotourl").attr("disabled", false)
            } else {
                $('#divfotourl').hide();
                $("#fotourl").attr("disabled", true)
            }
        })

        $('#simbolourl').on('input', function () {
            var src = jQuery(this).val();

            if (!src.match("^https?://(?:[a-z\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpg|png|jpeg|webp)$") || src == "") {
                $("#warningsimbolo").html("Precisa ser HTTPS, e Terminar com com extensão de imagem(jpg,png,...)!");
                $('#prevsimbolo').html(' <img src="https://fichasop.cf/assets/img/desconh.png" width="200" height="200" alt="Ritual">');
                return false;
            } else {
                $("#warningsimbolo").html("");
                $('#prevsimbolo').html('<img src="' + src + '" width="200" height="200" alt="Ritual">');
            }

        })
        $('#fotosimbolo').change(function () {
            let fotovalor = $('#fotosimbolo').val()
            if (fotovalor == '2') {
                $('#divfotosimbolourl').show();
                $("#simbolourl").attr("disabled", false)
            } else {
                $('#divfotosimbolourl').hide();
                $("#simbolourl").attr("disabled", true)
            }
        })
        $('.teedfa').on('input', function () {
            thisid = $(this).attr("id");
            var src = $('#' + thisid + ' input.simbolourl').val();
            if (!src.match("^https?://(?:[a-z\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpg|png|jpeg|webp)$") || src == "") {
                $('#' + thisid + ' div.warningsimbolo').html("Precisa ser HTTPS, e Terminar com com extensão de imagem(jpg,png,...)!");
                $('#' + thisid + ' div.prevsimbolo').html(' <img src="https://fichasop.cf/assets/img/desconh.png" width="200" height="200" alt="Ritual">');
                return false;
            } else {
                $('#' + thisid + ' div.warningsimbolo').html("");
                $('#' + thisid + ' div.prevsimbolo').html('<img src="' + src + '" width="200" height="200" alt="Ritual">');
            }

        })
        $('.teedfa').change(function () {
            thisid = $(this).attr("id");
            let fotovalor = $('#' + thisid + ' select.fotosimbolo').val()
            if (fotovalor == '2') {
                $('#' + thisid + ' .divfotosimbolourl').show();
                $('#' + thisid + ' input').attr("disabled", false)
            } else {
                $('#' + thisid + ' .divfotosimbolourl').hide();
                $('#' + thisid + ' input').attr("disabled", true)
            }
        })


        $('#addarmainvswitch').on('click', function () {
            if ($(this).is(":checked")) {
                $('#addarmainv input[type=text], #addarmainv input[type=number]').attr('disabled', false);
            } else {
                $('#addarmainv input[type=text], #addarmainv input[type=number]').attr('disabled', true);
            }
        }) //Ativar/Desativar Inventario em adicionar arma

        $('#Toastdados').on('hidden.bs.toast', function () {
            $('#resultado,#dado1,#dado2,#dado3,#valores1,#valores2,#valores3').html('');
            $('#valordados1,#valordados2,#valordados3').hide();
            $('main button').attr('disabled', false);
        })// Toast dos dados


        $("form").submit(function (event) {
            $(this).addClass('was-validated');
            if (!$(this).isValid()) {
                event.preventDefault()
                event.stopPropagation()
            } else {
                event.preventDefault();
                $.post({
                    url: '?id=<?php echo $id;?>',
                    data: $(this).serialize(),
                }).done(function (data) {
                    location.reload();
                }).fail(function () {
                })
            }
        })// Enviar qualquer formulario via jquery


        $('#card_principal .popout').on('click', function () {
            window.open("https://fichasop.cf/sessao/personagem?popout=principal&id=<?php echo $id;?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_dados .popout').on('click', function () {
            window.open("https://fichasop.cf/sessao/personagem?popout=dados&id=<?php echo $id;?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_atributos .popout').on('click', function () {
            window.open("https://fichasop.cf/sessao/personagem?popout=atributos&id=<?php echo $id;?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_inventario .popout').on('click', function () {
            window.open("https://fichasop.cf/sessao/personagem?popout=inventario&id=<?php echo $id;?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_pericias .popout').on('click', function () {
            window.open("https://fichasop.cf/sessao/personagem?popout=pericias&id=<?php echo $id;?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_habilidades .popout').on('click', function () {
            window.open("https://fichasop.cf/sessao/personagem?popout=habilidades&id=<?php echo $id;?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_proeficiencias .popout').on('click', function () {
            window.open("https://fichasop.cf/sessao/personagem?popout=proeficiencias&id=<?php echo $id;?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_rituais .popout').on('click', function () {
            window.open("https://fichasop.cf/sessao/personagem?popout=rituais&id=<?php echo $id;?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })

        $('#pe input[type=checkbox]').change(function () {
            var checkboxes = $('#pe input:checkbox:checked').length;
            $.post({
                url: '?id=<?php echo $id;?>',
                data: {status: 'pe', value: checkboxes},
            }).done(function () {
                $("#peatual").load("index.php?id=<?php echo $id;?> #peatual");
            })
        });
        $('#morrendo').change(function () {
            var x;
            if ($('#morrendo').is(":checked")) {
                x = 1;
            } else {
                x = 0;
            }
            $.post({
                url: '?id=<?php echo $id;?>',
                data: {status: 'morrendo', value: x},
            }).done(function (data) {
            })
        })
        $('#enlouquecendo').change(function () {
            var y;
            if ($('#enlouquecendo').is(":checked")) {
                y = 1;
            } else {
                y = 0;
            }
            $.post({
                url: '?id=<?php echo $id;?>',
                data: {status: 'enlouquecendo', value: y},
            }).done(function (data) {
            })
        })
        $("#verp").click(function () {
            $("#pericias .destreinado").toggle();
            $(this).toggleClass("fa-eye fa-eye-slash");
        });
        $("#vera").click(function () {
            $('#inv .trocavision').toggle();
            $(this).toggleClass("fa-eye fa-eye-slash");
        });
    });
    <?php } else {?>
    $(document).ready(function () {
        $("#verp").click(function () {
            $("#pericias .destreinado").toggle();
            $(this).toggleClass("fa-eye fa-eye-slash");
        });
        $("#vera").click(function () {
            $('#inv .trocavision').toggle();
            $(this).toggleClass("fa-eye fa-eye-slash");
        });
    });
    <?php
    }?>
</script>