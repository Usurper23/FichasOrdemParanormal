<div class="col-md pb-2 px-1" id="card_rolar">
    <div class="card h-100 bg-black border-light">
        <div class="card-body p-0 font1">
            <div class="position-absolute end-0">
                <?php if ($edit) {
                    if (!isset($_GET["popout"])) { ?>
                        <button class="btn btn-sm text-white popout" title="PopOut">
                            <i class="fa-regular fa-rectangle-vertical-history"></i>
                        </button>
                    <?php } ?>
                    <button class="btn btn-sm text-info" title="Como rolar dados.">
                        <i class="fa-regular fa-circle-info"></i>
                    </button>
                <?php } ?>
            </div>
            <div class="container-fluid p-2 justify-content-center text-center">
                <label class="font6 fs-1" for="rolardadosinput">Criar Dados</label>
                <div id="returncusdados"></div>
                <div class="input-group">
                    <input type="text" class="form-control bg-black text-white" id="rolardadosinput"/>
                    <button class="btn btn-sm btn-outline-light fa-regular fa-paper-plane-top" id="rolardadosbutton">
                </div>
            </div>
        </div>
    </div>
</div>
