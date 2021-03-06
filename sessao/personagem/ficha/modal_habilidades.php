<!-- Modal Habilidades-->
<div class="modal fade" id="addhab" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" id="formaddhab">
                <input type="hidden" name="status" value="addhab"/>
                <div class="text-center"><h2>Adicionar uma habilidade</h2></div>
                <div class="m-3">
                    <label for="habnome" class="fs-4 fw-bold">Nome da Habilidade</label>
                    <input type="text" id="habnome" name="hab" class="form-control fs-6 bg-black text-white"/>

                    <label for="deschab" class="fs-4 fw-bold">Descrição da Habilidade</label>
                    <textarea id="deschab" class="form-control bg-black text-white" name="desc"></textarea>
                </div>
                <div class="clearfix">
                    <button type="button" class="btn btn-danger float-start" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success float-end" value="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Editar Habilidades-->
<div class="modal fade" id="edithab" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" id="formedithab">
                <input type="hidden" name="status" value="edithab"/>
                <div class="text-center"><h2>Editar habilidades</h2></div>
                <?php
                foreach ($s[2] as $r):
                    ?>
                    <div class="m-3">
                        <input type="text" aria-label="" name="nome[]" class="form-control fs-6 bg-black text-white"
                               value="<?= $r["nome"]; ?>"/>
                        <input type="hidden" name="hid[]" value="<?= $r["id"] ?>">
                        <textarea aria-label="" name="desc[]"
                                  class="form-control bg-black text-light border-0 font7"><?= $r["descricao"]; ?></textarea>
                    </div>
                <?php
                endforeach;

                ?>
                <div class="clearfix">
                    <button type="button" class="btn btn-danger float-start" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success float-end" value="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
