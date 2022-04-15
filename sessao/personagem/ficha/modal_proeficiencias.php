<!-- Modal proeficiencias-->
<div class="modal fade" id="addpro" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" id="formaddpro" method="post">
                <input type="hidden" name="status" value="addpro"/>
                <div class="text-center"><h2>Adicionar uma Proeficiência.</h2></div>
                <div class="m-3">
                    <label for="pronome" class="fs-4 fw-bold">Nome da Proeficiência</label>
                    <input type="text" id="pronome" name="pro" class="form-control fs-6 bg-black text-white"/>
                </div>
                <div class="clearfix">
                    <button type="button" class="btn btn-danger float-start" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success float-end" value="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
