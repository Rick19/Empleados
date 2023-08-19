<div class="modal fade" id="editPuestoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Editar Puesto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-puesto-update">
                    {{--Input hidden para el ID--}}
                    <input type="hidden" id="puesto" name="puesto">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="name">Nombre <span
                                    class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                    <span id="name2" class="input-group-text"><i
                                                class="bx bx-buildings"></i></span>
                                <input type="text" class="form-control" id="name" name="name"
                                       placeholder="Nombre del puesto" aria-label="Nombre del puesto"
                                       aria-describedby="Nombre del puesto">
                            </div>
                            <div class="form-text">
                                Ejemplo: Reclutador JR
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" form="form-puesto-update">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>