<!-- Modal ATRIBUTOS-->
<div class="modal fade" id="editatrr" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" id="formeditatr">
                <div class="text-center"><h2>Editar Atributos.</h2></div>
                <div class="containera text-white" id="atributos" title="Atributos, clique para editar">
                    <input required class="atributos for form-control rounded-circle bg-transparent text-white font4"
                           type="number" min="-5" max="5" value=<?= $forca; ?> name="forca" aria-label="Força"/>
                    <input required class="atributos agi form-control rounded-circle bg-transparent text-white font4"
                           type="number" min="-5" max="5" value=<?= $agilidade; ?> name="agilidade"
                           aria-label="Agilidade"/>
                    <input required class="atributos int form-control rounded-circle bg-transparent text-white font4"
                           type="number" min="-5" max="5" value=<?= $intelecto; ?> name="intelecto"
                           aria-label="Intelecto"/>
                    <input required class="atributos pre form-control rounded-circle bg-transparent text-white font4"
                           type="number" min="-5" max="5" value=<?= $presenca; ?> name="presenca"
                           aria-label="Presença"/>
                    <input required class="atributos vig form-control rounded-circle bg-transparent text-white font4"
                           type="number" min="-5" max="5" value=<?= $vigor; ?> name="vigor" aria-label="Vigor"/>
                    <img src="https://fichasop.cf/assets/img/Atributos.png" alt="Atributos">
                </div>
                <div class="clearfix">
                    <input name="status" value="editattr" type="hidden"/>
                    <button type="button" class="btn btn-danger float-start" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success float-end" value="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
