@extends('layouts.master')

@section('title', 'Gestión de Temas de Curso')

@section('content')
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">
                    <i class="bi bi-list-ul"></i> Gestión de Temas de Curso
                </h1>
                <button class="btn btn-primary" onclick="openCreateModal()">
                    <i class="bi bi-plus-circle"></i> Nuevo Tema
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="courseTopicsTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Fecha Publicación</th>
                                    <th>Obligatorio</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Mostrando <span id="showing">0</span> de <span id="total">0</span> registros
                        </div>
                        <nav aria-label="Paginación">
                            <ul class="pagination mb-0" id="pagination">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Modals -->
    @include('course-topics.modals.form')
@endsection

@push('scripts')
    <script>
        let currentPage = 1;
        let perPage = 10;
        let courseTopicModal;
        let isEditMode = false;

        $(document).ready(function() {
            courseTopicModal = new bootstrap.Modal(document.getElementById('courseTopicModal'));
            loadCourseTopics();

            // Form submission
            $('#courseTopicForm').on('submit', function(e) {
                e.preventDefault();
                submitForm();
            });
        });

        function loadCourseTopics(page = 1) {
            currentPage = page;
            $('#tableBody').html(
                '<tr><td colspan="6" class="text-center"><div class="spinner-border" role="status"></div></td></tr>');

            $.ajax({
                url: `/api/v1/course-topics?page=${page}&per_page=${perPage}`,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        renderTable(response.data);
                        renderPagination(response.data);
                    } else {
                        showError('Error al cargar los temas');
                    }
                },
                error: function() {
                    showError('Error al cargar los temas');
                }
            });
        }

        function renderTable(data) {
            let html = '';

            if (data.data.length === 0) {
                html = '<tr><td colspan="6" class="text-center text-muted">No hay temas registrados</td></tr>';
            } else {
                data.data.forEach(function(topic) {
                    html += `
                    <tr>
                        <td>${topic.id}</td>
                        <td>${topic.name}</td>
                        <td>${topic.description || '<span class="text-muted">Sin descripción</span>'}</td>
                        <td>${formatDate(topic.publication_date)}</td>
                        <td>
                            ${topic.is_mandatory ?
                                '<span class="badge bg-success mandatory-badge">Obligatorio</span>' :
                                '<span class="badge bg-secondary mandatory-badge">Opcional</span>'
                            }
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary btn-action" onclick="editTopic(${topic.id})" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger btn-action" onclick="deleteTopic(${topic.id})" title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                });
            }

            $('#tableBody').html(html);
            $('#showing').text(data.data.length);
            $('#total').text(data.total);
        }

        function renderPagination(data) {
            let html = '';
            const totalPages = Math.ceil(data.total / perPage);

            if (totalPages > 1) {
                // Previous button
                html += `
                <li class="page-item ${data.current_page === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="loadCourseTopics(${data.current_page - 1})">Anterior</a>
                </li>
            `;

                // Page numbers
                for (let i = 1; i <= totalPages; i++) {
                    if (i === data.current_page) {
                        html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
                    } else {
                        html +=
                            `<li class="page-item"><a class="page-link" href="#" onclick="loadCourseTopics(${i})">${i}</a></li>`;
                    }
                }

                // Next button
                html += `
                <li class="page-item ${data.current_page === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="loadCourseTopics(${data.current_page + 1})">Siguiente</a>
                </li>
            `;
            }

            $('#pagination').html(html);
        }

        function openCreateModal() {
            isEditMode = false;
            $('#modalTitle').text('Nuevo Tema de Curso');
            $('#courseTopicForm')[0].reset();
            $('#topicId').val('');
            clearFormErrors('#courseTopicForm');
            courseTopicModal.show();
        }

        function editTopic(id) {
            isEditMode = true;
            $('#modalTitle').text('Editar Tema de Curso');
            clearFormErrors('#courseTopicForm');

            $.ajax({
                url: `/api/v1/course-topics/${id}`,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        const topic = response.data;
                        $('#topicId').val(topic.id);
                        $('#name').val(topic.name);
                        $('#description').val(topic.description);
                        $('#publication_date').val(formatDateForInput(topic.publication_date));
                        $('#is_mandatory').prop('checked', topic.is_mandatory);
                        courseTopicModal.show();
                    } else {
                        showError('Error al cargar el tema');
                    }
                },
                error: function() {
                    showError('Error al cargar el tema');
                }
            });
        }

        function submitForm() {
            const formData = {
                name: $('#name').val(),
                description: $('#description').val(),
                publication_date: $('#publication_date').val(),
                is_mandatory: $('#is_mandatory').is(':checked')
            };

            const topicId = $('#topicId').val();
            const url = isEditMode ? `/api/v1/course-topics/${topicId}` : '/api/v1/course-topics';
            const method = isEditMode ? 'PUT' : 'POST';

            setLoading('#submitBtn', true);
            clearFormErrors('#courseTopicForm');

            $.ajax({
                url: url,
                method: method,
                data: JSON.stringify(formData),
                contentType: 'application/json',
                success: function(response) {
                    if (response.success) {
                        courseTopicModal.hide();
                        showSuccess(isEditMode ? 'Tema actualizado correctamente' :
                            'Tema creado correctamente');
                        loadCourseTopics(currentPage);
                    } else {
                        showError(response.message || 'Error al guardar el tema');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(function(field) {
                            $(`#${field}`).addClass('is-invalid');
                            $(`#${field}Error`).text(errors[field][0]);
                        });
                    } else {
                        showError('Error al guardar el tema');
                    }
                },
                complete: function() {
                    setLoading('#submitBtn', false);
                }
            });
        }

        function deleteTopic(id) {
            showConfirm('¿Estás seguro?', 'Esta acción no se puede deshacer', function() {
                $.ajax({
                    url: `/api/v1/course-topics/${id}`,
                    method: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            showSuccess('Tema eliminado correctamente');
                            loadCourseTopics(currentPage);
                        } else {
                            showError('Error al eliminar el tema');
                        }
                    },
                    error: function() {
                        showError('Error al eliminar el tema');
                    }
                });
            });
        }

        function formatDateForInput(dateString) {
            if (!dateString) return '';

            if (/^\d{4}-\d{2}-\d{2}$/.test(dateString)) {
                return dateString;
            }

            const date = new Date(dateString);
            if (isNaN(date.getTime())) {
                return '';
            }

            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');

            return `${year}-${month}-${day}`;
        }
    </script>
@endpush
