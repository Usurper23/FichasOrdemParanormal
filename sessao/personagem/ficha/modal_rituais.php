<!-- Modal Rituais-->
<div class="modal fade" id="addritual" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-lg modal-dialog">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" id="formaddritual">
                <div class="text-center"><h2>Adicionar Ritual.</h2></div>
                <div class="container-fluid my-2">
                    <div class="m-2">
                        <label for="fotosimbolo" class="fs-4 fw-bold">Foto do ritual</label>
                        <select class="form-select bg-black text-light border-light" id="fotosimbolo" name="foto">
                            <option value="1" selected>Desconhecido</option>
                            <option value="2">Customizada</option>
                        </select>
                    </div>
                    <div class="m-2" id="divfotosimbolourl" style="display: none;">
                        <label for="simbolourl" class="fs-4 fw-bold">Link da imagem</label>
                        <input id="simbolourl" class="form-control bg-black text-light border-light" name="simbolourl" type="url" required disabled/>
                        <div class="invalid-feedback">A Imagem precisa ser valida.</div>
                    </div>
                    <div class="col text-center">
                        <div id="prevsimbolo">
                            <img src="https://fichasop.cf/assets/img/desconh.png" width="200" height="200" alt="Ritual">
                        </div>
                        <div id="warningsimbolo"></div>
                        <div class="container-fluid">
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0" for="arname">Ritual:</label>
                                <input type="text" class="form-control bg-black text-white border-start-0" id="arname" name="ritual"/>
                            </div>
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0" for="arcir">Circulo:</label>
                                <input type="text" class="form-control bg-black text-white border-start-0" id="arcir" name="circulo"/>
                            </div>
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0" for="arele">Elemento:</label>
                                <input type="text" class="form-control bg-black text-white border-start-0" id="arele" name="elemento"/>
                            </div>
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0" for="arcon">Conjuração:</label>
                                <input type="text" class="form-control bg-black text-white border-start-0" id="arcon" name="conjuracao"/>
                            </div>
                            <label class="fs-4" for="arefe">Efeito:</label>
                            <textarea id="arefe" name="efeito" class="form-control form-control-sm bg-black text-white"></textarea>
                        </div>
                    </div>
                </div>
                <div class="clearfix">
                    <input name="status" value="addritual" type="hidden" />
                    <button type="button" class="btn btn-danger float-start" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success float-end" value="submit">Criar</button>
                </div>
            </form>
        </div>
    </div>
</div>
