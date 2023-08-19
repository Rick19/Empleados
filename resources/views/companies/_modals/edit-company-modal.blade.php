<div class="modal fade" id="editCompanyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Editar Compañía</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-company-update">
                    {{--Input hidden para el ID--}}
                    <input type="hidden" id="company" name="company">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="name">Nombre <span
                                    class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                    <span id="name2" class="input-group-text"><i
                                                class="bx bx-buildings"></i></span>
                                <input type="text" class="form-control" id="name" name="name"
                                       placeholder="Nombre de la compañía" aria-label="Nombre de la compañía"
                                       aria-describedby="Nombre de la compañía">
                            </div>
                            <div id="defaultFormControlHelp" class="form-text">
                                Ejemplo: Hewlett-Packard, Pepsico
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="alias">Alias <span
                                    class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                    <span id="alias2" class="input-group-text"><i
                                                class="bx bxs-user-detail"></i></span>
                                <input type="text" id="alias" class="form-control" name="alias"
                                       placeholder="Asigna un alias a la empresa" aria-label="ACME Inc."
                                       aria-describedby="Alias de la compañía">
                            </div>
                            <div id="defaultFormControlHelp" class="form-text">
                                Ejemplo: HP, Pepsi, Bimbo
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" form="form-company-update">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>