<!-- Modal proeficiencias-->
<div class="modal fade" id="editdetalhes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" id="formeditdet">
                <div class="clearfix">
                    <button type="button" class="btn-close btn-close-white me-2 m-auto float-end" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    <div class="float-start m-2">
                        <span class="text-info"><i class="fa-regular fa-circle-info"></i> Os campos em azuis pode ser calculados automaticamente colocando 1.</span>
                    </div>
                </div>
                <h1 class="text-center">Editar Detalhes Pessoais</h1>
                <div class="">
                    <div class="m-2">
                        <label for="foto" class="fs-4 fw-bold">Estilo de foto.</label>
                        <select class="form-select bg-black text-light border-light" id="foto" name="foto">
                            <option value="1">Desconhecido - Masculino</option>
                            <option value="2">Desconhecido - Feminino</option>
                            <option value="3">Mauro Nunes</option>
                            <option value="4">Maya Shiruze</option>
                            <option value="5">Bruna Sampaio</option>
                            <option value="6">Leandro Weiss</option>
                            <option value="7">Jaime Orthuga</option>
                            <option value="8">Aniela Ukryty</option>
                            <option value="9" selected>Customizada</option>
                        </select>
                    </div>
                    <div class="m-2" id="divfotourl">
                        <label for="fotourl" class="fs-4 fw-bold">Link da imagem</label>
                        <div class="row">
                            <div class="col-8">
                                <input id="fotourl" class="form-control bg-black text-light border-light" name="fotourl" type="url" value="<?=$urlphoto?>" required/>
                                <div class="invalid-feedback">A Imagem precisa ser valida</div>
                            </div>
                            <div id="prev" class="col-4 d-flex align-items-center"></div>
                        </div>
                        <div id="warning"></div>
                    </div>
                    <div class="m-2">
                        <label class="fs-4" for="enome">Nome</label>
                        <input id="enome" class="form-control bg-black text-light" name="nome" value="<?=$nome?>" required/>
                        <div class="invalid-feedback">
                            O nome do seu personagem precisa conter apenas Letras e espaços.
                        </div>
                    </div>
                    <div class="m-2">
                        <label class="fs-4" for="enex">Nivel de Exposição Paranormal.</label>
                        <input id="enex" class="form-control bg-black text-light" name="nex" type="number" min="0" max="100" value="<?=$nex?>"/>
                        <div class="invalid-feedback">
                            Providencie um nivel de exposição paranormal.
                        </div>
                    </div>

                    <div class="m-2">
                    <!---SELECTOR-->
                        <label  class="fs-4 fw-bold" for="eclasse">Classe</label>
                        <select class="form-select bg-black text-light border-light" id="eclasse" name="classe" required>
                            <option value="<?=$rqs["classe"];?>"><?=$classe;?> - Atual</option>
                            <option value="0">Desconhecido</option>
                            <option value="1">Combatente</option>
                            <option value="2">Especialista</option>
                            <option value="3">Ocultista</option>
                        </select>
                    </div>

                    <div class="m-2">
                        <label class="fs-4" for="etrilha">Trilha</label>
                        <input id="etrilha" class="form-control bg-black  text-light " readonly name="trilha" value="<?=$trilha?>"/>
                    </div>

                    <div class="m-2">
                        <label  class="fs-4 fw-bold" for="eorigem">Origem</label>
                        <select class="form-select bg-black text-light border-light" id="eorigem" name="origem"  required="required">
                            <option value="<?=$rqs["origem"];?>"><?=$origem;?> - Atual</option>
                            <option value="0">Desconhecido</option>
                            <option value="1">Acadêmica</option>
                            <option value="7">Artista</option>
                            <option value="2">Atleta</option>
                            <option value="3">Exorcista</option>
                            <option value="4">Mercenária</option>
                            <option value="5">Profissional da Saúde</option>
                            <option value="6">T.I.</option>
                        </select>
                    </div>
                    <div class="m-2">
                        <label for="epatente" class="fs-4 fw-bold">Patente</label>
                        <select class="form-select bg-black text-light border-light" id="epatente" name="patente" required>
                            <option value="<?=$rqs["patente"];?>"><?=$patente;?> - Atual</option>
                            <option value="0">Desconhecido</option>
                            <option value="1">Recruta</option>
                            <option value="2">Agente</option>
                            <option value="3">Operador</option>
                            <option value="4">Veterano</option>
                            <option value="5">Elite</option>
                        </select>
                    </div>

                    <div class="m-2">
                        <label class="fs-4" for="eidade">Idade</label>
                        <input id="eidade" class="form-control bg-black  text-light " type="number" name="idade" value="<?=$rqs["idade"]?>"/>
                    </div>

                    <div class="m-2">
                        <label class="fs-4" for="elocal">Local de nascimento</label>
                        <input id="elocal" class="form-control bg-black  text-light " type="text" name="local" value="<?=$local?>"/>
                    </div>

                    <div class="m-2">
                        <label class="fs-4" for="ehistoria">Hístoria</label>
                        <textarea id="ehistoria" name="historia" class="form-control bg-black text-light "><?=$historia?></textarea>
                    </div>
                </div>
                <input type="hidden" name="status" value="editdet">
                <div class="clearfix m-2">
                    <button class="btn btn-outline-success float-start" type="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

