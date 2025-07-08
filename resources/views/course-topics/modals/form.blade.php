<!-- Create/Edit Modal -->
<div class="modal fade" id="courseTopicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Nuevo Tema de Curso</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="courseTopicForm">
                <div class="modal-body">
                    <input type="hidden" id="topicId" name="id">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nombre *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="invalid-feedback" id="nameError"></div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="publication_date" class="form-label">Fecha de Publicación *</label>
                            <input type="date" class="form-control" id="publication_date" name="publication_date" required>
                            <div class="invalid-feedback" id="publication_dateError"></div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        <div class="invalid-feedback" id="descriptionError"></div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_mandatory" name="is_mandatory" value="1">
                            <label class="form-check-label" for="is_mandatory">
                                Tema obligatorio
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <span class="spinner-border spinner-border-sm d-none" id="submitSpinner"></span>
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> 