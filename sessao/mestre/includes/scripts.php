<script>
    var typingTimer;                //timer identifier
    var doneTypingInterval = 2500;  //time in ms, 5 seconds for example
    var $note = $('#notes .note');
    function updtvida(valor,ficha){
        $.post({
            url: '?id=<?php echo $id;?>',
            data: {status: 'upv', ficha: ficha, value: valor},
        }).done(function (data) {
            $("#saude").load(location.href + " #saude>*");
        })
    }//Atualizar vida npc
    function updtsan(valor,ficha) {
        $.post({
            url: '?id=<?php echo $id;?>',
            data: {status: 'usan', ficha: ficha, value: valor},
        }).done(function (data) {
            $("#saude").load(location.href + " #saude>*");
        })
    }//Atualizar Sanidade npc
    function adicionariniciativa(){
        $.post({
            data: {status: 'criariniciativa'},
            url: '?id=<?=$id;?>',
            dataType: ""
        }).done(function (data) {
            location.reload();
        })
    }
    function submitiniciativa(){
        $.post({
            url: '?id=<?=$id;?>',
            dataType: '',
            data: $('#iniciativa :input').serialize(),
            success: function(data) {
            }
        });
    }
    function deletariniciativa(iniciativa_id){
        $.post({
            data: {status: 'deleteini', iniciativa_id: iniciativa_id},
            url: '?id=<?=$id;?>',
        }).done(function () {
            location.reload();
        })
    }
    function deletnpc(id){
        $.post({
            data: {status: 'deletenpc', npc: id},
            url: '?id=<?=$id;?>',
        }).done(function () {
            location.reload();
        })
    }
    updateIndex = function(e, ui){
        $('td.index', ui.item.parent()).each(function (i) {
            $(this).html(i+1);
        });
        $('input.hidden', ui.item.parent()).each(function (i) {
            $(this).val(i + 1);
        });
        submitiniciativa();
    };
    function updtpe(id){
        var checkboxes = $('#npc'+id+' .pontos_esforco input:checkbox:checked').length;
        $.post({
            url: '?id=<?php echo $id;?>',
            data: {status: 'pe',value: checkboxes,npc:id},
        }).done(function () {
            $("#npc"+id+" .pontos_esforco").load( "?id=<?php echo $id;?> #npc"+id+" .pontos_esforco" );
        })
    }
    function doneTyping () {
        sync = $("#noteform").serialize();
        $.post({
            url: "",
            data: sync,
        }).done(function () {
            $("#syncnotes").attr("class","text-success fa-regular fa-cloud-check");
        }).fail(function () {
            $("#syncnotes").attr("class","text-danger fa-regular fa-cloud-x");
        })
    }
    function addnote(){
        $.post({
            data: {status: 'addnote'},
            url: "",
        }).done(function (data) {
            location.reload();
        });
    }
    function deletenote(id){
        $.post({
            data: {status: 'deletenote',note:id},
            url: "",
        }).done(function (data) {
            location.reload();
        });
    }
    $(document).ready(function(){
        $note.on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        $note.on('keydown', function () {
            clearTimeout(typingTimer);
            $("#syncnotes").attr("class","text-warning fa-solid fa-arrows-rotate fa-spin");
        });


        $('#formadd').submit(function(e) {
            console.log("a");
            e.preventDefault();
            var form = $(this);
            $.post({
                beforeSend: function(){
                    $("#formadd input, #formadd button").attr('disabled', true);
                    $("#msgadd").html("<div class='alert alert-warning'>Aguarde enquanto verificamos os dados...</div>");
                },
                url: "",
                data: form.serialize(),
                dataType:"JSON",
                error:function(data){
                    $("#formadd input, #formadd button").attr('disabled', false);
                    $("#msgadd").html("<div class='alert alert-danger'>Houve um erro ao fazer a solicitação, contate um administrador!</div>");
                },
            }).done(function (data) {
                if (data.msg) {
                    if (!data.success){
                        $("#msgadd").html('<div class="alert alert-danger">' + data.msg + "</div>");
                        $("#formadd input, #formadd button").attr('disabled', false);
                    } else {
                        if(data.type == 1) {
                            $("#msgadd").html('<div class="alert alert-success">' + data.msg + '</div>');
                            setTimeout(function () {
                                $("#formadd input, #formadd button").attr('disabled', false);
                            }, 200)
                        } else {
                            $("#msgadd").html('<div class="alert alert-success">' + data.msg + ' <a href="https://fichasop.cf/?convite=1&email='+data.email+'">https://fichasop.cf/?convite=1&email=' +data.email + '</a></div>');
                            setTimeout(function () {
                                $("#formadd input, #formadd button").attr('disabled', false);
                            }, 200)
                        }
                    }
                }

            });
        });
        $('#formaddnpc').submit(function(e) {
            console.log("a");

            e.preventDefault();
            var form = $(this);
            $.post({
                url: "",
                data: form.serialize(),
                beforeSend(){
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
                $(this).attr('readonly',true).toggleClass('border-0')
                submitiniciativa();
            }
        })
        $(".up,.down").click(function(){
            const item = $(this).parents("tr:first");
            const ui = {item};
            if ($(this).is(".up")) {
                item.insertBefore(item.prev());
            } else {
                item.insertAfter(item.next());
            }
            updateIndex('',ui);
        });
        $('#refreshficha').click(function(){
            $('#fichasperson').load('?id=<?php echo$id;?>'+' #fichasperson>*')
            $('#refreshficha').attr('disabled', true)
            setTimeout(function() {
                $('#refreshficha').attr("disabled", false)
            }, 2000);
        })
    });
</script>