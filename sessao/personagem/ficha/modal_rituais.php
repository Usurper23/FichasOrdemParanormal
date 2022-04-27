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
                        <input id="simbolourl" class="form-control bg-black text-light border-light" name="simbolourl"
                               type="url" required disabled/>
                        <div class="invalid-feedback">A Imagem precisa ser valida.</div>
                    </div>
                    <div class="col text-center">
                        <div id="prevsimbolo">
                            <img src="https://fichasop.cf/assets/img/desconh.png" width="200" height="200" alt="Ritual">
                        </div>
                        <div id="warningsimbolo"></div>
                        <div class="container-fluid">
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                       for="arname">Ritual:</label>
                                <input type="text" class="form-control bg-black text-white border-start-0" id="arname"
                                       name="ritual"/>
                            </div>
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                       for="arcir">Circulo:</label>
                                <input type="text" class="form-control bg-black text-white border-start-0" id="arcir"
                                       name="circulo"/>
                            </div>
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                       for="arele">Elemento:</label>
                                <input type="text" class="form-control bg-black text-white border-start-0" id="arele"
                                       name="elemento"/>
                            </div>
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                       for="arcon">Conjuração:</label>
                                <input type="text" class="form-control bg-black text-white border-start-0" id="arcon"
                                       name="conjuracao"/>
                            </div>
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                       for="aralv">Alvo:</label>
                                <input type="text" class="form-control bg-black text-white border-start-0" id="aralv"
                                       name="alvo"/>
                            </div>
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                       for="aralc">Alcance:</label>
                                <input type="text" class="form-control bg-black text-white border-start-0" id="aralc"
                                       name="alcance"/>
                            </div>
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                       for="ardur">Duração:</label>
                                <input type="text" class="form-control bg-black text-white border-start-0" id="ardur"
                                       name="duracao"/>
                            </div>
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                       for="arres">Resistência:</label>
                                <input type="text" class="form-control bg-black text-white border-start-0" id="arres"
                                       name="resistencia"/>
                            </div>
                            <label class="fs-4" for="arefe">Efeito:</label>
                            <textarea id="arefe" name="efeito"
                                      class="form-control form-control-sm bg-black text-white"></textarea>
                        </div>
                    </div>
                </div>
                <div class="clearfix">
                    <input name="status" value="addritual" type="hidden"/>
                    <button type="button" class="btn btn-danger float-start" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success float-end" value="submit">Criar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Rituais-->
<div class="modal fade" id="editritual" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-fullscreen modal-dialog">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" id="formeditritual" autocomplete="off">
                <div class="text-center"><h2>Editar Rituais.</h2></div>
                <div class="container-fluid my-2 row">
                    <?php
                    foreach ($s[6] as $r):?>
                        <div class="col-md-6">
                            <div class="m-4">

                                <div class="teedfa" id="aff<?= $r["id"] ?>">
                                    <div class="m-2">
                                        <label for="fotosimbolo<?= $r["id"] ?>" class="fs-4 fw-bold ">Foto do
                                            ritual</label>
                                        <select class="form-select bg-black text-light border-light fotosimbolo"
                                                id="fotosimbolo<?= $r["id"] ?>" name="foto[]">
                                            <option value="1" <?= intval($r["foto"]) ? "selected" : "" ?>>Desconhecido
                                            </option>
                                            <option value="2" <?= intval($r["foto"]) ? "" : "selected" ?>>Customizada
                                            </option>
                                        </select>
                                    </div>
                                    <div class="m-2 divfotosimbolourl" <?= intval($r["foto"]) ? "style='display: none;'" : "" ?>>
                                        <label for="simbolourl<?= $r["id"] ?>" class="fs-4 fw-bold">Link da
                                            imagem</label>
                                        <input id="simbolourl<?= $r["id"] ?>"
                                               class="form-control bg-black text-light border-light simbolourl"
                                               name="simbolourl[<?= $r["id"] ?>]" value="<?= $r["foto"] ?>" type="url"
                                               required <?= intval($r["foto"]) ? "disabled" : "" ?>/>
                                        <div class="invalid-feedback">A Imagem precisa ser valida.</div>
                                    </div>
                                    <div class="col text-center">
                                        <div class="prevsimbolo">
                                            <img src="https://fichasop.cf/assets/img/desconh.png" width="200"
                                                 height="200" alt="Ritual">
                                        </div>
                                        <div class="warningsimbolo"></div>
                                    </div>
                                </div>
                                <div class="input-group m-1">
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                           for="arname<?= $r["id"] ?>">Ritual:</label>
                                    <input required type="text" class="form-control bg-black text-white border-start-0"
                                           id="arname<?= $r["id"] ?>" name="ritual[]" value="<?= $r["nome"] ?>"/>
                                </div>
                                <div class="input-group m-1">
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                           for="arcir<?= $r["id"] ?>">Circulo:</label>
                                    <input type="text" class="form-control bg-black text-white border-start-0"
                                           id="arcir<?= $r["id"] ?>" name="circulo[]" value="<?= $r["circulo"] ?>"/>
                                </div>
                                <div class="input-group m-1">
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                           for="arele<?= $r["id"] ?>">Elemento:</label>
                                    <input type="text" class="form-control bg-black text-white border-start-0"
                                           id="arele<?= $r["id"] ?>" name="elemento[]" value="<?= $r["elemento"] ?>"/>
                                </div>
                                <div class="input-group m-1">
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                           for="arcon<?= $r["id"] ?>">Conjuração:</label>
                                    <input type="text" class="form-control bg-black text-white border-start-0"
                                           id="arcon<?= $r["id"] ?>" name="conjuracao[]"
                                           value="<?= $r["conjuracao"] ?>"/>
                                </div>
                                <div class="input-group m-1">
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                           for="aralv<?= $r["id"] ?>">Alvo:</label>
                                    <input type="text" class="form-control bg-black text-white border-start-0"
                                           id="aralv<?= $r["id"] ?>" name="alvo[]" value="<?= $r["alvo"] ?>"/>
                                </div>
                                <div class="input-group m-1">
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                           for="aralc<?= $r["id"] ?>">Alcance:</label>
                                    <input type="text" class="form-control bg-black text-white border-start-0"
                                           id="aralc<?= $r["id"] ?>" name="alcance[]" value="<?= $r["alcance"] ?>"/>
                                </div>
                                <div class="input-group m-1">
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                           for="ardur<?= $r["id"] ?>">Duração:</label>
                                    <input type="text" class="form-control bg-black text-white border-start-0"
                                           id="ardur<?= $r["id"] ?>" name="duracao[]" value="<?= $r["duracao"] ?>"/>
                                </div>
                                <div class="input-group m-1">
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                           for="arres<?= $r["id"] ?>">Resistência:</label>
                                    <input type="text" class="form-control bg-black text-white border-start-0"
                                           id="arres<?= $r["id"] ?>" name="resistencia[]"
                                           value="<?= $r["conjuracao"] ?>"/>
                                </div>
                                <label class="fs-4" for="arefe<?= $r["id"] ?>">Efeito:</label>
                                <textarea required id="arefe<?= $r["id"] ?>" name="efeito[]"
                                          class="form-control form-control-sm bg-black text-white"><?= $r["efeito"] ?></textarea>
                            </div>
                        </div>
                        <input name="ritualid[]" value="<?= $r["id"] ?>" type="hidden"/>
                    <?php endforeach; ?>
                </div>
                <div class="clearfix">
                    <input name="status" value="editritual" type="hidden"/>
                    <button type="button" class="btn btn-danger float-start" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success float-end" value="submit">Criar</button>
                </div>
            </form>
        </div>
    </div>
</div>
